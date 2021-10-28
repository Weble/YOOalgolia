<?php
$el = $this->el('div', []);
?>

<?= $el($props, $attrs); ?>
<ais-pagination
        :class-names="{
            'ais-Pagination':'pagination pagination-toolbar clearfix',
            'ais-Pagination-list': 'pagination-list',
            'ais-Pagination-link': 'uk-padding-small',
            'ais-Pagination-item--selected': 'uk-active'
        }"
></ais-pagination>
<?= $el->end(); ?>
