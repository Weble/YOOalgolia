<?php

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/vendor/autoload.php';

use Joomla\Cms\Uri\Uri;
use YOOtheme\Application;
use YOOtheme\Path;

class plgSystemYooAlgolia extends Joomla\CMS\Plugin\CMSPlugin
{
    public function onAfterInitialise()
    {
        if (!class_exists(Application::class, false)) {
            return;
        }

        require_once __DIR__ . '/vendor/autoload.php';

        $app = Application::getInstance();

        $root = __DIR__;
        $rootUrl = Uri::root(true);

        // set alias
        Path::setAlias('~yooalgolia', $root);
        Path::setAlias('~yooalgolia_url', $rootUrl . '/plugins/system/yooalgolia');

        // bootstrap modules
        $app->load('~yooalgolia/builder/bootstrap.php');
    }
}
