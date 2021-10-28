<?php

use Joomla\CMS\Factory;
use function YOOtheme\trans;

$url = 'item.url.it.default';
$language = 'it';
$el = $this->el('div', [
    'v-cloak' => true
]);

// Grid
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-[1-{@!grid_default: auto}]{grid_default}',
        'uk-child-width-[1-{@!grid_small: auto}]{grid_small}@s',
        'uk-child-width-[1-{@!grid_medium: auto}]{grid_medium}@m',
        'uk-child-width-[1-{@!grid_large: auto}]{grid_large}@l',
        'uk-child-width-[1-{@!grid_xlarge: auto}]{grid_xlarge}@xl',
        'uk-flex-center {@grid_column_align}',
        'uk-flex-middle {@grid_row_align}',
        $props['grid_column_gap'] == $props['grid_row_gap'] ? 'uk-grid-{grid_column_gap}' : '[uk-grid-column-{grid_column_gap}] [uk-grid-row-{grid_row_gap}]',
        'uk-grid-divider {@grid_divider} {@!grid_column_gap:collapse} {@!grid_row_gap:collapse}',
        'uk-grid-match {@!grid_masonry}',
    ],

    'uk-grid' => $this->expr([
        'masonry: {grid_masonry};',
        'parallax: {grid_parallax};',
    ], $props) ?: true,


    'slot-scope' => '{ items }'
]);

$lang = Factory::getLanguage()->getTag();
?>

<?= $el($props, $attrs); ?>
<ais-hits>
    <?= $grid($props) ?>
    <div v-for="item in items">

        <div class="uk-card uk-card-small uk-card-default uk-card-hover uk-flex-1 uk-flex uk-flex-column">
            <div class="uk-card-body uk-background-hover-muted uk-flex-1">
                <div class="uk-padding-small">
                    <div class="uk-text-muted" v-if="item.category">
                        {{ item.category.name['<?php echo $lang; ?>'] }}
                    </div>
                    <h4>{{ item.title }}</h4>
                    <div v-html="item.text.join('<br/>')" v-if="item.text && item.text.length > 0"></div>
                </div>
            </div>
        </div>
    </div>
    <?= $grid->end(); ?>
</ais-hits>
<?= $el->end(); ?>
