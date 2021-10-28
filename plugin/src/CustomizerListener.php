<?php

namespace Weble\YOOAlgolia;

use YOOtheme\Config;
use YOOtheme\Path;

class CustomizerListener
{
    public static function initCustomizer(Config $config)
    {
        // add config
        $config->addFile('customizer', Path::get('../config/customizer.json'));
    }
}
