<?php
use \YOOtheme\File;

$config = \YOOtheme\app(YOOtheme\Config::class);

$path = $__dir . "/" . $props['template'];
// check for override in child theme
if ($childDir = $config('theme.childDir')) {
    if (File::exists(($child_path = $childDir . '/builder/algolia_table/templates/' . $props['template']) . '.php')) {
        $path = $child_path;
    }
}

?>

<?= $this->render($path, compact('props')) ?>
