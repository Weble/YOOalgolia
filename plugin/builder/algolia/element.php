<?php

namespace Iess\Template\Algolia;

use Iess\Template\AlgoliaService;
use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

return [

    'transforms' => [

        'render' => function ($node) {


            $metadata = app(Metadata::class);
            $algolia = new AlgoliaService($node->props);
            $metadata->set('script:algolia-element', ['src' => Path::get("./assets/js/algolia.min.js"), 'defer' => true]);

            $node->algolia = $algolia->config();
        }

    ],

];
