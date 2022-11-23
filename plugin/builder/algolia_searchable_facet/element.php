<?php
use YOOtheme\Builder\Source\SourceTransform;
use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

return [

    'transforms' => [


        'render' => function ($node, $root) {

            /* FILTERS */
            $filters = [];

            foreach ($node->props['facets'] as $facet) {

                $facet->props = (array) $facet->props;
                $filters[] = $facet->props['field'];
            }

            $node->filters = json_encode($filters);

            
            /* OTHER FILTERS */
            $node->other_filters = null;
            $filters = $node->props['filters'] ?? [];

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
                $node->other_filters = implode(" AND ", $filtersStrings);
            }

            /* Attributes override */
            $attributes = [];

            foreach ($node->props['attributes_override'] as $facet) {

                $facet->props = (array) $facet->props;

                if (!isset($facet->props['field']) || !isset($facet->props['name'])) {
                    continue;
                }

                if (!$facet->props['field'] || !$facet->props['name']) {
                    continue;
                }

                $attributes[$facet->props['field']] = $facet->props['name'];
            }

            $node->facet_names = json_encode($attributes);
        }

    ],

    'fields' => [

        'facet' => [
            'type' => 'text',
            'label' => 'Facet'
        ]
    ]

];
