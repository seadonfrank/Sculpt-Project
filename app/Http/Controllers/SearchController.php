<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $header = ["Authorization: Bearer ".config('services.wit.server'),];
        $request = config('services.wit.url').'/message?v='.config('services.wit.version').'&q='.urlencode($keyword);

        $ch = curl_init($request);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        $status = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );

        if($status == 200) {
            $entities = array_keys($response['entities']);
            $indices = array('entity_organization', 'entity_person');
            $field="";
            $value="";

            if(count(array_diff($entities, $indices)) > 0){
                if(array_diff($entities, $indices)[1] == 'location'){
                    $field="country";
                } else {
                    $field=array_diff($entities, $indices)[1];
                }
                $value=$response['entities'][array_diff($entities, $indices)[1]][0]['value'];
            } else {
                $field="company";
                $value=$response['entities'][array_intersect($entities, $indices)[0]][0]['value'];
            }

            $client = ClientBuilder::create()->build();

            $params['index'] = implode(',', array_intersect($entities,$indices));
            $params['type']  = 'cbinsights';
            $array = array(
                $field =>array (
                    'value' => $value,
                    "boost" => 1.0,
                    "fuzziness" => 3,
                    "prefix_length" => 0,
                    "max_expansions" => 100
                ),
                /*'state' =>array (
                    'value' => $response['entities'][array_diff($entities, $indices)[1]][0]['value'],
                    "boost" => 1.0,
                    "fuzziness" => 3,
                    "prefix_length" => 0,
                    "max_expansions" => 100
                ),
                'city' =>array (
                    'value' => $response['entities'][array_diff($entities, $indices)[1]][0]['value'],
                    "boost" => 1.0,
                    "fuzziness" => 3,
                    "prefix_length" => 0,
                    "max_expansions" => 100
                )*/
            );

            $params['body']['query']['fuzzy']= $array;
            $params['size']=50;

            $results = $client->search($params);
            return $results['hits']['hits'];
        }
    }
}
