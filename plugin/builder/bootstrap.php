<?php

namespace Weble\YOOAlgolia;

use YOOtheme\Builder;
use YOOtheme\Path;

require_once dirname(__DIR__) . '/vendor/autoload.php';

return [

    'events' => [

        'customizer.init' => [
            CustomizerListener::class => 'initCustomizer'
        ],

        'builder.type' => [
            AlgoliaListener::class => ['addAlgoliaPanel', -10]
        ],

    ],

    'extend' => [

        Builder::class => function (Builder $builder) {
            $builder->addTypePath(Path::get('./*/element.json'));
            $builder->addTransform('render', new AlgoliaTransform($builder));
        },

    ],


];
