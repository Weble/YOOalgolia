<?php

namespace Weble\YOOAlgolia;

use YOOtheme\Config;
use function YOOtheme\app;

class AlgoliaService
{

    private string $appId;
    private string $adminKey;
    private string $searchKey;
    private string $indexName;
    private string $routerArrayFormat;
    private $routingRefinements;

    public function __construct(array $config)
    {
        $themeConfig = app(Config::class)->get('~theme.algolia', []);

        $this->appId = $config['app_id'] ?? $themeConfig['app_id'] ?? '';
        $this->adminKey = $config['admin_key'] ?? $themeConfig['admin_key'] ?? '';
        $this->searchKey = $config['search_key'] ?? $themeConfig['search_key'] ?? '';
        $this->indexName = $config['index_name'] ?? $themeConfig['index_name'] ?? '';
        $this->routingRefinements = $config['routing_refinements'] ?? $themeConfig['routing_refinements'] ?? [];
        $this->routerArrayFormat = $config['router_array_format'] ?? $themeConfig['router_array_format'] ?? '';
    }

    public function setCredentials(string $appId, string $adminKey, string $searchKey): self
    {
        $this->appId = $appId;
        $this->adminKey = $adminKey;
        $this->searchKey = $searchKey;

        return $this;
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

    public function routerArrayFormat(): ?string
    {
        return $this->routerArrayFormat;
    }

    public function config(): array
    {
        return [
            'app_id'     => $this->appId(),
            'admin_key'  => $this->adminKey(),
            'search_key' => $this->searchKey(),
            'index_name' => $this->indexName(),
            'routing_refinements' => $this->routingRefinements(),
            'router_array_format' => $this->routerArrayFormat()
        ];
    }

}
