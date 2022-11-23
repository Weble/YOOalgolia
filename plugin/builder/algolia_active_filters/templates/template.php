<?php
$el = $this->el('div', []);

// Button
$button = $this->el('a', [

    ':href'          => "createURL(refinement)",
    '@click.prevent' => "item.refine(refinement)",

    'class' => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}'                                              => ['button_style' => $props['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
    ], $props)

]);
?>

<?= $el($props, $attrs); ?>


<ais-current-refinements :excluded-attributes=<?php echo $node->excluded_facets; ?>>
    <div slot-scope="{ items, createURL }">
        <span v-for="item in items" :key="item.attribute">
                <span
                    v-for="refinement in item.refinements"
                    :key="[
                        refinement.attribute,
                        refinement.type,
                        refinement.value,
                        refinement.operator
                    ].join(':')"
                    class="uk-margin-small-right">

                    <?= $button($props) ?>
                    <?php if ($props['close_icon']) : ?>

                        <?php if ($props['icon_align'] == 'left') : ?>
                            <span uk-icon="icon: <?= $props['close_icon'] ?>; ratio: 0.7"></span>
                        <?php endif ?>



                        <span class="uk-text-middle">
                            <span class="uk-text-small">{{ renameAttributes(refinement.attribute, <?= $node->facet_names ?>) }}:</span> {{ refinement.label }}
                        </span>

                        <?php if ($props['icon_align'] == 'right') : ?>
                            <span uk-icon="icon: <?= $props['close_icon'] ?>; ratio: 0.7"></span>
                        <?php endif ?>

                    <?php else : ?>
                        {{ refinement.label }}
                    <?php endif ?>

                    <?= $button->end(); ?>
                </span>
        </span>
    </div>
</ais-current-refinements>
<?= $el->end(); ?>
