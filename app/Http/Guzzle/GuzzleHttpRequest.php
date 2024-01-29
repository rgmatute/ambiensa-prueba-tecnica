<?php

namespace App\Http\Guzzle;
use GuzzleHttp\Client;

trait GuzzleHttpRequest{
    protected $client;

    public function __construct(Client $client){
        $this->client = $client;
        // dd($this->client);
        $this->client = new Client(['http_errors' => false]);
    }

    protected function get ($url, array $headers = []){
        return $this->invoke('GET',$url,[],$headers);
    }

    protected function post($url, array $array, array $headers = []){
        return $this->invoke('POST',$url, $array, $headers);
    }

    protected function put($url, array $array, array $headers = []){
        return $this->invoke('PUT',$url, $array, $headers);
    }

    protected function delete($url, array $array, array $headers = []){
        return $this->invoke('DELETE',$url, $array, $headers);
    }

    private function invoke(String $method, String $url, Array $data = [], Array $headers = [] ){
        // $headers['Authorization'] = 'Bearer '.session()->get('token');
        $response = $this->client->request($method, $url,
            [
                'http_errors' => false,
                'headers' => $headers,
                /*'headers' => [
                    'Authorization' => 'Bearer '.session()->get('token')
                ],*/
                'body' => json_encode($data)
            ]);
        return $response;
    }

    public function multipart(String $method, String $url, Array $data = [], Array $headers = [] ){
        $response = $this->client->request($method, $url,
            [
                'http_errors' => false,
                'headers' => $headers,
                'multipart' => $data
            ]);
        return $response;
    }
}

