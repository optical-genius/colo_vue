<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Neo4jClient;

class HostController extends Controller
{
    public function delete($id)
    {
//        $test = Neo4jClient::run('MATCH (n:Ip)-[r]-(h:Host) WHERE ID(n) = './* $id */.' DELETE n, r, h');
        return response()->json($id);
    }
}
