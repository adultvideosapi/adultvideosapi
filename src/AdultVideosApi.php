<?php
namespace AdultVideosApi;

use AdultVideosApi\Exception\CurlException;
use AdultVideosApi\Exception\ResponseDecodeException;
use Curl\Curl;
use Curl\MultiCurl;

class AdultVideosApi
{
    const BASE_URI = 'https://adultvideosapi.com/api';
    private string $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function get()
    {
        $uris = [];

        $models = func_get_args();
        foreach($models as $model) {
            if(!is_object($model) || !defined(get_class($model).'::ENDPOINT_URI')) {
                throw new \InvalidArgumentException('Wrong model provided');
            }

            $uris[] = $this->buildModelEndpointUri($model);
        }

        $responses = [];

        $this->call($uris, function(Curl $call) use (&$responses) {
            $order = $call->_order;

            if($call->error) {
                $responses[$order] = new CurlException($call->errorCode . ' ' . $call->errorMessage);
                return;
            }

            $response = @json_decode($call->getRawResponse());
            if(json_last_error() !== JSON_ERROR_NONE) {
                $responses[$order] = new ResponseDecodeException('Unable to parse response from API, response is not valid JSON (JSON Error: '.json_last_error_msg().')');
            }

            $responses[$order] = $response;
        });

        if(count($responses) == 1) {
            return current($responses);
        }

        ksort($responses);

        return $responses;
    }

    private function buildModelEndpointUri($model): string
    {
        $modelVars = get_object_vars($model);
        array_walk($modelVars, function(&$paramValue){
            if(is_bool($paramValue)) {
                $paramValue = var_export($paramValue, true);
            }
        });

        $queryParams = http_build_query($modelVars);
        return self::BASE_URI . $model::ENDPOINT_URI . '?' . $queryParams;
    }

    private function call(array $uris, callable $callback): void
    {
        $mculr = new MultiCurl();
        $mculr->setOpt(CURLOPT_ENCODING, '');
        $mculr->setConcurrency(10);
        $mculr->setRetry(3);
        $mculr->setConnectTimeout(10);
        $mculr->setTimeout(10);
        $mculr->setUserAgent('');

        $mculr->setHeaders([
            'X-Api-Key: ' . $this->apiKey
        ]);

        foreach($uris as $key => $uri) {
            $mculr->addGet($uri)->_order = $key;
        }

        $mculr->complete(function($instance) use ($callback){
            $callback($instance);
        });

        $mculr->start();
    }
}