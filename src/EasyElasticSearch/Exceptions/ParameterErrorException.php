<?php


namespace sn01615\EasyElasticSearch\Exceptions;


class ParameterErrorException extends EsEsException
{

    public function __construct($message, $code = 10)
    {
        parent::__construct($message, $code);
    }
}