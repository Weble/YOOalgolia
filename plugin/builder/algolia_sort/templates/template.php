<?php
$el = $this->el('div', $attrs);

$search = $this->el('ais-sort-by', [
    ':items' => json_encode($props['sorting_items'])
])
?>

<?= $el($props, $attrs); ?>
    <?= $search($props); ?><?= $search->end(); ?>
<?= $el->end(); ?>
