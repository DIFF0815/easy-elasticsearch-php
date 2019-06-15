<?php


namespace sn01615\EasyElasticSearch;


use Elasticsearch\ClientBuilder;
use sn01615\EasyElasticSearch\Exceptions\ParameterErrorException;
use stdClass;

class Client
{

    private $client;
    private $index;
    private $type;

    /**
     * @param mixed $id 记录id
     * @param stdClass|array $data 记录对象
     *        See https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html
     * @return array|callable
     * @throws ParameterErrorException
     */
    public function index($id, $data)
    {
        if (!$this->index)
            throw new ParameterErrorException("Set index first. (->setIndex())");
        if (!$this->type)
            throw new ParameterErrorException("Set type first. (->setType())");
        $client = $this->getClient();
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
        ];
        $params['body'] = $data;
        return $client->index($params);
    }


    /**
     * @param array $hosts See https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/configuration.html
     * @return \Elasticsearch\Client
     */
    public function getClient($hosts = null)
    {
        if (!$this->client) {
            $client = ClientBuilder::create();
            if ($hosts) {
                $client->setHosts($hosts);
            }
            $this->client = $client->build();
        }
        return $this->client;
    }

    /**
     * @param mixed $index
     * @return Client
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param mixed $type
     * @return Client
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    private function escaping($wd)
    {
        $search = ['+', '-', '&&', '||', '!', '(', ')', '{', '}', '[', ']', '^', '"', '~', '*', '?', ':', '\\', '/',];
        return trim(str_replace($search, ' ', $wd));
    }
}