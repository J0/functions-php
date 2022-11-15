<?php

namespace Supabase;

use GuzzleHttp\Psr7\Response;

class FunctionsClient {

    private $apiKey;
    private $uriBase;
    private $httpClient;
    private $error;
    private $response;

    private $headers = [
        'Content-Type' => 'application/json'
    ];

    /**
     * Construct method (Set the API key, URI base and instance GuzzleHttp client)
     * @access public
     * @param $apiKey String The Supabase project API Key
     * @param $uriBase String API URI base (Ex: "https://abcdefgh.supabase.co/" OR "https://abcdefgh.supabase.co/")
     * @return void
     */
    public function __construct(string $apiKey, string $uriBase)
    {
        $this->apiKey = $apiKey;
        $this->uriBase = $uriBase;

        $this->httpClient = new \GuzzleHttp\Client();
        $this->headers['apikey'] = $this->apiKey;
    }

    /**
     * Set bearerToken to be added into headers and to be used for future requests
     * @access public
     * @param $token String The bearer user token (generated in sign in process)
     * @return void
     */
    public function setAuth($token)
    {
        $this->setHeader('Authorization', 'Bearer ' . $token);
        return $this;
    }


    /**
     * Returns the Response of last request
     * @access public
     * @return Response
     */
    public function getResponse() : Response
    {
        return $this->response;
    }


    /**
     * Set bearerToken to be added into headers and to be used for future requests
     * @access public
     * @param $functionName String The name of the function to invoke
     * @param $invokeOptions array Object with `header`, `body` and `responseType` params
     * @return Array
     */
    public function invoke(string $functionName, array $invokeOptions)
    {
         $options = [
            'headers' => $this->service->getHeaders(),
            'body'    => json_encode($invoke_options['body']) ?? []
        ];

        $this->data = $this->executeHttpRequest('POST', $this->$uriBase.$functionName, $options);


    }


     /**
     * Format the exception thrown by GuzzleHttp, formatting the error message
     * @access public
     * @param $e \GuzzleHttp\Exception\RequestException The exception thrown by GuzzleHttp
     * @return void
     */
    public function formatRequestException(\GuzzleHttp\Exception\RequestException $e) : void
    {
        if($e->hasResponse()){
            $res = json_decode($e->getResponse()->getBody());
            $searchItems = ['msg', 'message', 'error_description'];

            foreach($searchItems as $item){
                if(isset($res->$item)){
                    $this->error = $res->$item;
                    break;
                }
            }
        }
    }

    /**
     * Execute a Http request in Supabase API
     * @access public
     * @param $method String The request method (GET, POST, PUT, DELETE, PATCH, ...)
     * @param $uri String The URI to be requested (including the endpoint)
     * @param $options array Requisition options (header, body, ...)
     * @return array|object|null
     */
    public function executeHttpRequest(string $method, string $uri, array $options)
    {
        try{
            $this->response = $this->httpClient->request(
                $method,
                $uri,
                $options
            );
            return json_decode($this->response->getBody());
        } catch(\GuzzleHttp\Exception\RequestException $e){
            $this->formatRequestException($e);
            throw $e;
        } catch(\GuzzleHttp\Exception\ConnectException $e){
            $this->error = $e->getMessage();
            throw $e;
        }
    }

}
