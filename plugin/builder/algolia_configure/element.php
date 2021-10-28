<?php

namespace Iess\Template\Algolia;

use Iess\Template\AlgoliaService;
use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

return [

    'transforms' => [

        'render' => function ($node, $root) {
            $node->filters = null;
            $filters = $node->props['_filters'] ?? [];

            $filtersStrings = [];
            if (count($filters) > 0) {
                foreach ($filters as $filter) {
                    $filter->props = (array) $filter->props;
                    app(SourceTransform::class)->__invoke($filter, $root);
                    $props = $filter->props;

                    $filtersStrings[] = $props['field'] . ':' . $props['value'];
                }
            }



            if (count($filtersStrings) > 0) {
                $node->filters = implode(" AND ", $filtersStrings);
            }
        }

    ],

];
