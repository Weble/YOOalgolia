<?php

namespace Iess\Template\Algolia;

use Iess\Template\AlgoliaService;
use Joomla\Filesystem\Folder;
use YOOtheme\File;
use YOOtheme\Metadata;
use YOOtheme\Path;
use function YOOtheme\app;

$templateFiles = Folder::files(__DIR__ . '/templates');
$templateFiles = array_filter($templateFiles, function($template){
    return stripos($template, 'template-') === 0 && pathinfo($template, PATHINFO_EXTENSION) === 'php';
});

$templates = [];
foreach ($templateFiles as $template) {
    $template = str_replace('.php', '', $template);
    $templates[$template] = $template;
}



return [

    'fields' => [
        'template' => [
            'type' => 'select',
            'label' => 'Template',
            'options' => $templates,
        ]
    ],

    'transforms' => [

        'render' => function ($node) {

        }

    ],

];
