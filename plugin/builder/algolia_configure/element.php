<?php


use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Metadata;
use YOOtheme\Path;
use ZOOlanders\YOOessentials\Builder\SourceResolver;
use function YOOtheme\app;

return [

    'transforms' => [

        'render' => function ($node, $root) {
            $node->filters = null;
            $filters = $node->props['_filters'] ?? [];
            $filtersStrings = [];

            /* @var SourceResolver $sourceResolver */
            $sourceResolver = app(SourceResolver::class);

            if (count($filters) > 0) {
                foreach ($filters as $filter) {
                    $filter->props = (array) $filter->props;
                    $filter = $sourceResolver->resolveProps($filter, $root);
                    $props = $filter->props;

                    if (isset($props['value'])) {
                        $filtersStrings[] = $props['field'] . ':' . $props['value'] ?? null;
                    }
                }
            }

            if (count($filtersStrings) > 0) {
                $node->filters = implode(" AND ", $filtersStrings);
            }
        }

    ],

];
