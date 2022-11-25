<?php


return [

    'transforms' => [


        'render' => function ($node) {

            $facets = [];
            foreach ($node->props['facets'] as $facet) {

                $facet = (array) $facet->props;
                $facets[] = $facet['field'];
            }

            if (empty($facets)) {
                $facets[] = " ";
            }

            $node->facets = json_encode($facets);
            $node->facets_count = count($facets);
        }

    ],

    'fields' => [

        'facet' => [
            'type' => 'text',
            'label' => 'Facet'
        ]
    ]

];
