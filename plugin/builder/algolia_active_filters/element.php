<?php


return [

    'transforms' => [

        'render' => function ($node) {

            $excluded_facets = [];

            foreach ($node->props['excluded-attributes'] ?? [] as $facet) {

                $facet = (array) $facet;
                $facet['field'] = $facet['title'] ?? null;

                if (!isset($facet['field'])) {
                    continue;
                }

                if (!$facet['field']) {
                    continue;
                }

                $excluded_facets[] = $facet['field'];
            }

            $node->excluded_facets = json_encode($excluded_facets);


            /* Attributes override */
            $attributes = [];

            foreach ($node->props['attributes_override'] ?? [] as $facet) {

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

];
