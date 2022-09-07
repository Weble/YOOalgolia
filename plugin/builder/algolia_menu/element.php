<?php


return [

    'transforms' => [


        'render' => function ($node) {

            $facets = [];
            foreach ($node->props['facets'] as $facet) {

                $facet = (array) $facet->props;
                $facets[] = $facet['field'];
            }

            $node->facets = json_encode($facets);

        }

    ],

    'fields' => [

        'facet' => [
            'type' => 'text',
            'label' => 'Facet'
        ]
    ]

];
