<?php

namespace Wangzd\ScoutES;

use Elasticsearch\ClientBuilder;

trait ESClientTrait
{
    /**
     * Get ElasticSearch Client
     *
     * @return \Elasticsearch\Client
     */
    public function getElasticsearchClient()
    {
        $hosts = config('scout.elasticsearch.hosts');
        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
        return $client;
    }
}
