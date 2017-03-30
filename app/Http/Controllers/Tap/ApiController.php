<?php

namespace App\Http\Controllers\Tap;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function crunchbase()
    {
        set_time_limit(300); // set max execution limit to 5 minutes instead of 30 seconds
        ini_set('memory_limit', "1096M"); // increase the memory limit 10 4GB - server memory increased to 7GB - Sat Dec 20 20:36:31 IST 2014

        $client = ClientBuilder::create()->build();

        // lets pretend that the data is coming from the API
        $host = config('database.connections.mongodb.host');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $database = config('database.connections.mongodb.database');

        $mongo = new \MongoDB\Client("mongodb://".$host,
            array("username" => $username,"password" => $password));
        $db = $mongo->selectDatabase($database);

        $col = $db->selectCollection("cb_organizations");
        $cursors = $col->find();

        foreach($cursors as $cursor){

            $response = $client->index(array(
                    'index' => 'entity_organization',
                    'type' => 'crunchbase',
                    'id' => $cursor->data->uuid,
                    'body' => $cursor->data->properties,
            ));

            foreach($cursor->data->relationships->founders->items as $item) {
                $response = $client->index(array(
                    'index' => 'entity_person',
                    'type' => 'crunchbase',
                    'id' => $item->uuid,
                    'body' => $item->properties
                ));
                $response = $client->index(array(
                    'index' => 'relationship_organization_person',
                    'type' => 'crunchbase',
                    'body' => array(
                        'organization' => $cursor->data->uuid,
                        'person' => $item->uuid,
                        'actions' => array(
                            'founder' => array ()
                        )
                    )
                ));
            }
        }

        die('Done with CrunchBase API');
    }

    public function angelco()
    {
        // lets pretend that teh data is coming from the API
        $host = config('database.connections.mongodb.host');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $database = config('database.connections.mongodb.database');

        $mongo = new \MongoDB\Client("mongodb://".$host,
            array("username" => $username,"password" => $password));
        $db = $mongo->selectDatabase($database);

        $col = $db->selectCollection("al_organizations");
        $cursors = $col->find();

        set_time_limit(300); // set max execution limit to 5 minutes instead of 30 seconds
        ini_set('memory_limit', "1096M"); // increase the memory limit 10 4GB - server memory increased to 7GB - Sat Dec 20 20:36:31 IST 2014

        $client = ClientBuilder::create()->build();

        foreach($cursors as $cursor){

            die(json_encode($cursor));

            $response = $client->index(array(
                'index' => 'entity_organization',
                'type' => 'crunchbase',
                'id' => $cursor->id,
                'body' => $cursor,
            ));

            foreach($cursor->data->relationships->founders->items as $item) {
                $response = $client->index(array(
                    'index' => 'entity_person',
                    'type' => 'crunchbase',
                    'id' => $item->uuid,
                    'body' => $item->properties
                ));
                $response = $client->index(array(
                    'index' => 'relationship_organization_person',
                    'type' => 'crunchbase',
                    'body' => array(
                        'organization' => $cursor->data->uuid,
                        'person' => $item->uuid,
                        'actions' => array(
                            'founder' => array ()
                        )
                    )
                ));
            }
        }

        die("Done Good Job!!");
    }

    public function ivc()
    {
        set_time_limit(300); // set max execution limit to 5 minutes instead of 30 seconds
        ini_set('memory_limit', "1096M"); // increase the memory limit 10 4GB - server memory increased to 7GB - Sat Dec 20 20:36:31 IST 2014

        $client = ClientBuilder::create()->build();

        // lets pretend that the data is coming from the API
        $host = config('database.connections.mongodb.host');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $database = config('database.connections.mongodb.database');

        $mongo = new \MongoDB\Client("mongodb://".$host,
            array("username" => $username,"password" => $password));
        $db = $mongo->selectDatabase($database);

        $column = $db->selectCollection("ivc_organizations");
        $cursors = $column->find();

        foreach($cursors as $cursor) {
            $col = $db->selectCollection("ivc_deals");
            $curs = $col->find(array('IVCNumber' => $cursor->IVCNumber));
            $deals = array();

            foreach ($curs as $cur) {
                unset($cur->_id);
                array_push($deals, $cur);
            }

            unset($cursor->_id);
            $cursor = (object)array_merge((array)$cursor, array('deals' => $deals));

            $response = $client->index(array(
                'index' => 'entity_organization',
                'type' => 'ivc',
                'id' => $cursor->IVCNumber,
                'body' => $cursor,
            ));
        }

        die('Done with IVC API');
    }

    public function cbinsights()
    {
        set_time_limit(300); // set max execution limit to 5 minutes instead of 30 seconds
        ini_set('memory_limit', "1096M"); // increase the memory limit 10 4GB - server memory increased to 7GB - Sat Dec 20 20:36:31 IST 2014

        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'entity_organization',
            'type' => 'cbinsights',
            'body' => [
                'cbinsights' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'zip' => [
                            'type' => 'string',
                            'analyzer' => 'standard'
                        ],
                    ]
                ]
            ]
        ];
        $response = $client->indices()->putMapping($params);

        // lets pretend that the data is coming from the API
        $host = config('database.connections.mongodb.host');
        $username = config('database.connections.mongodb.username');
        $password = config('database.connections.mongodb.password');
        $database = config('database.connections.mongodb.database');

        $mongo = new \MongoDB\Client("mongodb://".$host,
            array("username" => $username,"password" => $password));
        $db = $mongo->selectDatabase($database);

        $column = $db->selectCollection("ci_organizations");
        $cursors = $column->find();

        foreach($cursors as $cursor) {
            $col = $db->selectCollection("ci_deals");
            $curs = $col->find(array('id_company' => $cursor->id_company));
            $deals = array();

            foreach ($curs as $cur) {
                unset($cur->_id);
                array_push($deals, $cur);
            }

            unset($cursor->_id);
            $cursor = (object)array_merge((array)$cursor, array('deals' => $deals));

            $client->index(array(
                'index' => 'entity_organization',
                'type' => 'cbinsights',
                'id' => $cursor->id_company,
                'body' => $cursor
            ));
        }

        die('Done with CbInsights API');
    }
}
