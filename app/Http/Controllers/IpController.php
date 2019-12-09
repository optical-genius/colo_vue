<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Neo4jClient;

class IpController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */

    public function index()
    {
        return view('ips');
    }

    public function get()
    {
        $start = microtime(true);
        $memorylim = memory_get_usage() / 1024;
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, h.host_name LIMIT 6000');
        $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN { id: ID(n), ip_name: n.ip_name }, collect(distinct { id: ID(h), host_name: h.host_name }) LIMIT 100');
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, collect(distinct h.host_name) LIMIT 100');
        //$records = $test->getRecords();
        $records = $test->getRecords();

        $vueRecordArray = [];
        foreach ($records as $vue) {
            $vueRecordArray[] = $vue->values();
        }
        $start = round(microtime(true) - $start, 4);
        return response()->json(['vueRecordArray' => $vueRecordArray, 'start' => $start, 'memorylim' => $memorylim]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Удаляем IP, все хосты связанные с адресом и связи с портами.
     */
    public function delete($id)
    {
//        $test = Neo4jClient::run('MATCH (n:Ip)-[r]-(h:Host) WHERE ID(n) = './* $id */.' DELETE n, r, h');
        return response()->json($id);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(Request $request)
    {
        return response()->json($request);
    }


    public function clusterize()
    {
        $start = microtime(true);
        $memorylim = memory_get_usage() / 1024;
//      $test = Neo4jClient::run('MATCH (n:Ip) RETURN { id: ID(n), ip_name: n.ip_name } LIMIT 10');
        $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN { id: ID(n), ip_name: n.ip_name }, collect({host_name: h.host_name}) LIMIT 5000');
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, collect(distinct h.host_name) LIMIT 100');
        $records = $test->getRecords();

        $vueRecordArray = [];
        foreach ($records as $vue) {
            $ip = [];
            $ip['id'] = $vue->values()['0']['id'];
            $ip['ip_name'] = $vue->values()['0']['ip_name'];
            $hosts = [];
            foreach($vue->values()['1'] as $host)
            {
                $hosts[] = $host;
            }
            $ip['host'] = $hosts;
            $vueRecordArray[] = $ip;
        }
        return view('ips-clusterize', compact('vueRecordArray', 'start', 'memorylim'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Отрисовываем динамическую таблицу в компоненте VirtualTable.vue
     * Кол-во записей устанавливается в запросе "LIMIT 100"
     * $start Замер времени выполнения скрипта
     * $cypherQuery->getRecords() Возвращает объект с protected properties. Пробегаем циклом и достаем защищенные свойства в массив
     * $memorylim затраты памяти
     */

    public function clusterizeTable()
    {
        ini_set('memory_limit', '1024M');
        $start = microtime(true);
        $cypherQuery = Neo4jClient::run('
                                MATCH (ip:Ip) 
                                WITH ip, 
                                [(ip)-->(port:Port) | port{id: ID(port), port_name: port.port_name}] as ports, 
                                [(ip)-->(host:Host) | host{id: ID(host), host_name: host.host_name}] as hosts 
                                LIMIT 100 
                                RETURN { id: ID(ip), ip_name: ip.ip_name }, ports, hosts
                                ');

        $records = $cypherQuery->getRecords();

        $vueRecordArray = [];
        foreach ($records as $vue) {
            $ip = [];
            $ip['id'] = $vue->values()['0']['id'];
            $ip['ip_name'] = $vue->values()['0']['ip_name'];

            $hosts = [];
            foreach($vue->values()['2'] as $host)
            {
                $hosts[$host['id']] = $host['host_name'];
            }
            $ip['host'] = $hosts;


            $ports = [];
            foreach($vue->values()['1'] as $port)
            {
                $ports[$port['id']] = $port['port_name'];
            }
            $ip['port'] = $ports;

            $vueRecordArray[] = $ip;
        }

        $memorylim = memory_get_usage() / 1024;
        return view('ips-clusterize-table', compact('vueRecordArray', 'start', 'memorylim'));
    }


    /**
     * @param Request $request
     * @return array
     * Поиск для компонента Search.vue
     * Результат рендерится в компоненте VirtualTable.vue
     * $start Замер времени выполнения скрипта
     * $cypherQuery->getRecords() Возвращает объект с protected properties. Пробегаем циклом и достаем защищенные свойства в массив
     * $memorylim затраты памяти
     */

    public function search(Request $request){

        if($request['ip_name']){
            ini_set('memory_limit', '1024M');
            $start = microtime(true);
            $cypherQuery = Neo4jClient::run('
                                MATCH (ip:Ip)
                                WHERE ip.ip_name STARTS WITH "' . $request["ip_name"] . '"
                                WITH ip, 
                                [(ip)-->(port:Port) | port{id: ID(port), port_name: port.port_name}] as ports, 
                                [(ip)-->(host:Host) | host{id: ID(host), host_name: host.host_name}] as hosts 
                                LIMIT 1000 
                                RETURN { id: ID(ip), ip_name: ip.ip_name }, ports, hosts
                                ');

            $records = $cypherQuery->getRecords();

            $vueRecordArray = [];
            foreach ($records as $vue) {

                $ip = [];
                $ip['id'] = $vue->values()['0']['id'];
                $ip['ip_name'] = $vue->values()['0']['ip_name'];


                $hosts = [];
                foreach($vue->values()['2'] as $host)
                {
                    $hosts[$host['id']] = $host['host_name'];
                }
                $ip['host'] = $hosts;


                $ports = [];
                foreach($vue->values()['1'] as $port)
                {
                    $ports[$port['id']] = $port['port_name'];
                }
                $ip['port'] = $ports;

                $vueRecordArray[] = $ip;
            }

            $memorylim = memory_get_usage() / 1024;
            return compact('vueRecordArray', 'start', 'memorylim');

        }elseif($request['host_name']){
//ПЕРЕДЕЛАТЬ ЗАПРОС
            ini_set('memory_limit', '1024M');
            $start = microtime(true);
            $cypherQuery = Neo4jClient::run('
                MATCH (host:Host) 
                WHERE host.host_name STARTS WITH "' . $request["host_name"] . '"
                WITH host as hosts, 
                [(host)--(ip:Ip) | ip{id: ID(ip), ip_name: ip.ip_name}] as ip, 
                [(host)--()--(port:Port) | port] as ports LIMIT 1000
                RETURN ip, ports, hosts
            ');
            $records = $cypherQuery->getRecords();


            $vueRecordArray = [];
            foreach ($records as $vue) {
                $ip = [];
                $ip['id'] = $vue->values()['0']['0']['id'];
                $ip['ip_name'] = $vue->values()['0']['0']['ip_name'];

                $ip['host'] = $vue->values()['2']->values()['host_name'];


                $ports = [];
                foreach($vue->values()['1'] as $port)
                {
                    $ports[] = $port->values()['port_name'];
                }
                $ip['port'] = $ports;
                $vueRecordArray[] = $ip;
            }

            $memorylim = memory_get_usage() / 1024;
            return compact('vueRecordArray', 'start', 'memorylim');

        }

    }
}
