<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Neo4jClient;

class IpController extends Controller
{
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

    public function delete($id)
    {
//        $test = Neo4jClient::run('MATCH (n:Ip)-[r]-(h:Host) WHERE ID(n) = './* $id */.' DELETE n, r, h');
        return response()->json("ok");
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

    public function clusterizeTable()
    {
        ini_set('memory_limit', '1024M');
        $start = microtime(true);
//      $test = Neo4jClient::run('MATCH (n:Ip) RETURN { id: ID(n), ip_name: n.ip_name } LIMIT 10');
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN { id: ID(n), ip_name: n.ip_name }, collect({host_name: h.host_name}) LIMIT 10');
        $test = Neo4jClient::run('MATCH (ip:Ip) WITH ip, [(ip)-->(port:Port) | port] as ports, [(ip)-->(host:Host) | host] as hosts LIMIT 100 RETURN { id: ID(ip), ip_name: ip.ip_name }, ports, hosts');
//      $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN n.ip_name, collect(distinct h.host_name) LIMIT 100');
        $records = $test->getRecords();

        $vueRecordArray = [];
        foreach ($records as $vue) {
            $ip = [];
            $ip['id'] = $vue->values()['0']['id'];
            $ip['ip_name'] = $vue->values()['0']['ip_name'];

            $hosts = [];
            foreach($vue->values()['2'] as $host)
            {
                $hosts[] = $host->values()['host_name'];
            }
            $ip['host'] = $hosts;


            $ports = [];
            foreach($vue->values()['1'] as $port)
            {
                $ports[] = $port->values()['port_name'];
            }
            $ip['port'] = $ports;
            $vueRecordArray[] = $ip;
        }
//return($vueRecordArray);
        $memorylim = memory_get_usage() / 1024;
        return view('ips-clusterize-table', compact('vueRecordArray', 'start', 'memorylim'));
    }


    public function virtual(Request $request){

        if($request['ip_name']){
            ini_set('memory_limit', '1024M');
            $start = microtime(true);
            $test = Neo4jClient::run('MATCH (ip:Ip) WHERE ip.ip_name STARTS WITH "' . $request["ip_name"] . '" WITH ip, [(ip)-->(port:Port) | port] as ports, [(ip)-->(host:Host) | host] as hosts LIMIT 1000 RETURN { id: ID(ip), ip_name: ip.ip_name }, ports, hosts');
            $records = $test->getRecords();

            $vueRecordArray = [];
            foreach ($records as $vue) {
                $ip = [];
                $ip['id'] = $vue->values()['0']['id'];
                $ip['ip_name'] = $vue->values()['0']['ip_name'];

                $hosts = [];
                foreach($vue->values()['2'] as $host)
                {
                    $hosts[] = $host->values()['host_name'];
                }
                $ip['host'] = $hosts;


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

        }elseif($request['host_name']){

            ini_set('memory_limit', '1024M');
            $start = microtime(true);
            $test = Neo4jClient::run('
                MATCH (host:Host) 
                WHERE host.host_name STARTS WITH "' . $request["host_name"] . '"
                WITH host as hosts, [(host)--(ip:Ip) | ip{id: ID(ip), ip_name: ip.ip_name}] as ip, [(host)--()--(port:Port) | port] as ports LIMIT 1000
                RETURN ip, ports, hosts
            ');
            $records = $test->getRecords();


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
