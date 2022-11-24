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

                $facet = (array) $facet;
                $facet['field'] = $facet['title'] ?? null;
                $filters[] = $facet['field'];
            }

            $node->filters = json_encode($filters);


            /* OTHER FILTERS */
            $node->other_filters = null;
            $filters = $node->props['filters'] ?? [];

            $filtersStrings = [];
            if (count($filters) > 0) {
                foreach ($filters as $filter) {

                    $filter = (array) $filter;
                    $filter['field'] = $filter['title'] ?? null;

                    app(SourceTransform::class)->__invoke($filter, $root);

                    $filtersStrings[] = $filter['field'] . ':' . $filter['value'];
                }
            }

            if (count($filtersStrings) > 0) {
                $node->other_filters = implode(" AND ", $filtersStrings);
            }

            /* Attributes override */
            $attributes = [];

            foreach ($node->props['attributes_override'] as $facet) {

                $facet = (array) $facet;
                $facet['field'] = $facet['title'] ?? null;

                if (!isset($facet['field']) || !isset($facet['name'])) {
                    continue;
                }

                if (!$facet['field'] || !$facet['name']) {
                    continue;
                }

                $attributes[$facet['field']] = $facet['name'];
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
