<?php
use YOOtheme\Path;

$config = \YOOtheme\app(YOOtheme\Config::class);

$path = $__dir . "/" . $props['template'];
// check for override in child theme
if ($childDir = $config('theme.childDir')) {
    $path = $childDir . '/builder/algolia_hits/templates/' . $props['template'];
}
?>
<?= $this->render($path, compact('props')) ?>
