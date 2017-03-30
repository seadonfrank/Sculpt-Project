<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SolBianca\BotBuilder\Client;
//use GuzzleHttp\Client;


class HomeController extends Controller
{
    //
    public function test()
    {

        $authOptions = [
            'grantType' => 'client_credentials',
            'clientId' => '57bdc8ed-1041-4c61-ad3e-2233020ff7fd',
            'clientSecret' => 'VbByPuOmwfom38oDKAtmBDa',
            'scope' => 'https://api.botframework.com/.default',
            'reciveTokenURL' => 'login.microsoftonline.com/botframework.com/oauth2/v2.0/token',
        ];




        //$client = new Client(['base_uri' => '']);
        ///$response = $client->send(POST$authOptions);


       // $content = $response->getBody()->getContents();

        $client = (new Client($authOptions))->auth();

        /*$client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://httpbin.org',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);*/


       // $client->setRequest($_POST)->makeResponse('TEST')->send();

        die(var_dump($client));
        $authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6ImEzUU4wQlpTN3M0bk4tQmRyamJGMFlfTGRNTSIsImtpZCI6ImEzUU4wQlpTN3M0bk4tQmRyamJGMFlfTGRNTSJ9.eyJhdWQiOiJodHRwczovL2FwaS5ib3RmcmFtZXdvcmsuY29tIiwiaXNzIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvZDZkNDk0MjAtZjM5Yi00ZGY3LWExZGMtZDU5YTkzNTg3MWRiLyIsImlhdCI6MTQ5MDE3OTkxMywibmJmIjoxNDkwMTc5OTEzLCJleHAiOjE0OTAxODM4MTMsImFpbyI6IkFRQUJBQUVBQUFEUk5ZUlEzZGhSU3JtLTRLLWFkcENKUTNoellxaElseEpoeUNVWFpZbFc2a1RZYnVMWTZIbFRhTG5iV1BRRWhVQWJWQTJ4dHJ5dFpPNEhweWNLSDRVT2FLbTMwX1VSREhMQjVEOEprZnhONGlBQSIsImFwcGlkIjoiNTdiZGM4ZWQtMTA0MS00YzYxLWFkM2UtMjIzMzAyMGZmN2ZkIiwiYXBwaWRhY3IiOiIxIiwiaWRwIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvZDZkNDk0MjAtZjM5Yi00ZGY3LWExZGMtZDU5YTkzNTg3MWRiLyIsInRpZCI6ImQ2ZDQ5NDIwLWYzOWItNGRmNy1hMWRjLWQ1OWE5MzU4NzFkYiIsInZlciI6IjEuMCJ9.HapessZlSQEla3HqB0IUZwDrxDyvtVnwNQPmM4zlHwHDfRPdIHtidgTZbKs4Z4eaBUG0cjph3K6QV4_4Ht6rx3s18up9bHdje2RrbPZitkRoeId1a4lhiBUfB5pz4LDjxCL9fhqPn6INjrzFXmzHgQtCyO2E-P1D5Sa2vvPgXId1_c2_Bd4HQ84mQYW-ZPiEhbR0kdnbOXL48FtqCY8Bxa0EzbeWYMWfUD6AMUg2VifVocs7Gtz7GlszOSdcYwtkE-PZbzhn-5lwePEQ_1i4B_wE-6qovvZJuxs2nPycCSb1XzUvIYvvysPlSP9GPFU-AdUvxAzLh8hVuXyNbLpljw";

        $ch = curl_init('https://api.botframework.com/v3/conversations');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        die(var_dump($result));
    }
}
