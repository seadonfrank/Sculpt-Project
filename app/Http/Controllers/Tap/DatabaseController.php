<?php

namespace App\Http\Controllers\Tap;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    //
    public function mongodb()
    {
        $host = config('database.connections.mongodb.host');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $database = config('database.connections.mongodb.database');

        $mongo = new \MongoDB\Client("mongodb://".$host,
            array("username" => $username,"password" => $password));
        $db = $mongo->selectDatabase($database);

        $col = $db->selectCollection("cb_organizations");
        $cursors = $col->findOne();

        return json_encode($cursors);
    }
}
