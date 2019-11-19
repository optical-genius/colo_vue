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
        $test = Neo4jClient::run('MATCH (n:Ip)-->(h:Host) RETURN { id: ID(n), ip_name: n.ip_name }, collect(distinct { id: ID(h), host_name: h.host_name }) LIMIT 10');
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
        return response()->json("ok");
    }


}
