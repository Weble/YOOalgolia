<?php

namespace Weble\YOOAlgolia;

use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\SearchIndex;
use YOOtheme\Config;
use function YOOtheme\app;

class AlgoliaService
{
    private ?SearchClient $client = null;
    private ?SearchIndex $index = null;

    private string $appId;
    private string $adminKey;
    private string $searchKey;
    private string $indexName;

    public function __construct(array $config)
    {
        $themeConfig = app(Config::class)->get('~theme.algolia', []);

        $this->appId = $config['app_id'] ?? $themeConfig['app_id'] ?? '';
        $this->adminKey = $config['admin_key'] ?? $themeConfig['admin_key'] ?? '';
        $this->searchKey = $config['search_key'] ?? $themeConfig['search_key'] ?? '';
        $this->indexName = $config['index_name'] ?? $themeConfig['index_name'] ?? '';
        $this->routingRefinements = $config['routing_refinements'] ?? $themeConfig['routing_refinements'] ?? '';
    }

    public function setCredentials(string $appId, string $adminKey, string $searchKey): self
    {
        $this->appId = $appId;
        $this->adminKey = $adminKey;
        $this->searchKey = $searchKey;

        $this->client = SearchClient::create($this->appId(), $this->adminKey());
        return $this;
    }

    public function setIndexName(string $indexName): self
    {
        $this->indexName = $indexName;
        $this->index = $this->client()->initIndex($this->indexName());
        return $this;
    }

    public function client(): ?SearchClient
    {
        if (!$this->client) {
            $this->client = SearchClient::create($this->appId(), $this->adminKey());
        }

        return $this->client;
    }

    public function index(): ?SearchIndex
    {
        if (!$this->index) {
            $this->index = $this->client()->initIndex($this->indexName());
        }

        return $this->index;
    }

    public function appId(): ?string
    {
        return $this->appId;
    }

    public function searchKey(): ?string
    {
        return $this->searchKey;
    }

    public function adminKey(): ?string
    {
        return $this->adminKey;
    }

    public function indexName(): ?string
    {
        return $this->indexName;
    }

    public function routingRefinements(): ?array
    {
        return $this->routingRefinements;
    }

    public function config(): array
    {
        return [
            'app_id'     => $this->appId(),
            'admin_key'  => $this->adminKey(),
            'search_key' => $this->searchKey(),
            'index_name' => $this->indexName(),
            'routing_refinements' => $this->routingRefinements()
        ];
    }

    public function facets(): array
    {
        return $this->index()->getSettings()['attributesForFaceting'] ?? [];
    }
}
