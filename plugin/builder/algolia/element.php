<?php

use Weble\YOOAlgolia\AlgoliaService;
use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

return [

    'transforms' => [

        'render' => function ($node) {


            $metadata = app(Metadata::class);
            $algolia = new AlgoliaService($node->props);
            $metadata->set('script:algolia-element', ['src' => "plugins/system/yooalgolia/assets/algolia.min.js", 'defer' => true]);

            $node->algolia = $algolia->config();
        }

    ],

];
