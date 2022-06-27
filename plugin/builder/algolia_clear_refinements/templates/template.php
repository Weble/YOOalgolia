<?php
$el = $this->el('ais-clear-refinements', [
    'class' => 'el-element'
]);

// Button
$button = $this->el('a', [
    'class'     => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}'                                              => ['button_style' => $props['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
    ], $props),

    ':href' => 'createURL()',
    '@click.prevent' => 'refine',
    'v-if' => 'canRefine',

    'title' => ['{button_text}'],

]);


?>

<?= $el($props, $attrs); ?>
    <div slot-scope="{ canRefine, refine, createURL }">

    <?php if ($props['button_text']) : ?>
        <?= $button($props) ?>

        <?php if ($props['icon']) : ?>

            <?php if ($props['icon_align'] == 'left') : ?>
                <span uk-icon="<?= $props['icon'] ?>"></span>
            <?php endif ?>

            <span class="uk-text-middle">
                  <?php echo $props['button_text'] ?>
            </span>

            <?php if ($props['icon_align'] == 'right') : ?>
                <span uk-icon="<?= $props['icon'] ?>"></span>
            <?php endif ?>

        <?php else : ?>
            <span class="uk-text-middle">
                  <?php echo $props['button_text'] ?>
            </span>
        <?php endif ?>

        <?= $button->end(); ?>

    <?php endif; ?>
    </div>
<?= $el->end(); ?>
