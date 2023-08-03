<?php


use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

return [

    'transforms' => [

        'render' => function ($node) {

            $metadata = app(Metadata::class);
            $metadata->set('script:algolia-autocomplete', [
                'src' => Path::get('~yooalgolia/assets/autocomplete.min.js'),
                'defer' => true,
            ]);
        },

    ],


];
