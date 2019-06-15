<?php


namespace sn01615\EasyElasticSearch\Exceptions;


use Exception;

class EsEsException extends Exception
{
    private $error;

    public function __construct($message, $code, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $error
     * @return static
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}