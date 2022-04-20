<?php


return [

    'transforms' => [

        'render' => function ($node) {



            foreach ($node->children as $child) {
                $node->props['sorting_items'][] = [
                    'value' => $child->props['item_value'],
                    'label' => $child->props['item_label']
                ];
            }

        }

    ],

];
