<?php

namespace Weble\YOOAlgolia;

use YOOtheme\Arr;
use YOOtheme\Config;

class AlgoliaListener
{
    public static function addAlgoliaPanel(Config $config, $type)
    {
        // make sure the main fieldset is set
        if (!Arr::has($type, 'fieldset.default')) {
            return $type;
        }

        $tabs = array_reduce($type['fieldset']['default']['fields'], function ($carry, $v) {
            return array_merge($carry, [$v['title'] ?? null]);
        }, []);

        if (($index = array_search('Advanced', $tabs)) === false) {
            return $type;
        }

        if ($type['name'] === 'section') {
            $statusField = [
                'type'  => 'checkbox',
                'name'  => 'algolia.state',
                'label' => 'Algolia',
                'text'  => 'Enable as Algolia Search Area'
            ];

            $configButton = [
                'name' => 'algolia',
                'text' => 'Configuration',
                'type' => 'button-panel',
                'panel' => 'algolia',
                'enable' => 'algolia.state',
                'description' => 'Enable this element as a Algolia Area, and set its configuration.'
            ];

            // set button right after status field
            Arr::splice($type['fieldset']['default']['fields'][$index]['fields'], 2, 0, [
                $statusField,
                $configButton
            ]);

            return $type;
        }

        return $type;
    }
}
