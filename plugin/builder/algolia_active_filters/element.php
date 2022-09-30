<?php


return [

    'transforms' => [

        'render' => function ($node) {

            $excluded_facets = [];

            foreach ($node->props['excluded-attributes'] as $facet) {

                $facet->props = (array) $facet->props;

                if (!isset($facet->props['field'])) {
                    continue;
                }

                if (!$facet->props['field']) {
                    continue;
                }

                $excluded_facets[] = $facet->props['field'];
            }

            $node->excluded_facets = json_encode($excluded_facets);


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

];
