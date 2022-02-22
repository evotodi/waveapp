<?php

namespace Evotodi\WaveBundle\Builder;

use Evotodi\WaveBundle\Exceptions\ResponseException;

class ResponseBuilder
{
    /**
     * @throws ResponseException
     */
    public function success($res): array
    {
        $json= json_decode($res->getBody(), 1);
        if(key_exists('errors', $json)){
            throw new ResponseException($json['errors'][0]['message']);
        }
        return $json;
    }

    /**
     * @throws ResponseException
     */
    public function errors($e)
    {
        if($e instanceof ResponseException){
            throw $e;
        }
        if ($e->hasResponse()) {
            $response = json_decode($e->getResponse()->getBody(), 1);
            throw new ResponseException($response['errors'][0]['message']);
        }

        throw new ResponseException($e->getMessage());
    }
}
