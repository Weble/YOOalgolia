<?php

namespace Weble\YOOAlgolia;

use YOOtheme\Builder;
use function YOOtheme\app;

class AlgoliaTransform
{
    /** @var Builder */
    protected Builder $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function __invoke($node, array $params)
    {
        if ($this->isAlgoliaNode($node)) {
            $this->createNode($node, $params, 'algolia');
        }
    }

    protected function isAlgoliaNode($node): bool
    {
        return (bool) ($node->props['algolia']->state ?? false);
    }

    protected function createNode($node, $params, $type): void
    {
        $config = (array) $node->props[$type];
        $this->wrap($node, $config, $params, $type);
    }

    protected function wrap($node, array $config, array $params, string $type)
    {
        $algoliaId = hash('crc32b', json_encode([
            $type, app()->config->get('req.url'), $params['parent']->id ?? 0, $params['index'] ?? 0
        ]));

        $algoliaNode = $this->builder->load(json_encode([
            'id' => $algoliaId,
            'type' => $type,
            'props' => $config
            ]), ['context' => 'render']);

        $algoliaNode->config = $config;
        $algoliaNode->children = $node->children;

        $node->children = [$algoliaNode];

        return $algoliaNode;
    }
}
