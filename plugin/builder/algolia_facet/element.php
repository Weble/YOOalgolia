<?php

namespace Iess\Template\Algolia;


return [

    'transforms' => [


        'render' => function ($node) {

        }

    ],

    'fields' => [

        'facet' => [
            'type' => 'text',
            'label' => 'Facet'
        ]
    ]

];
