<?php
$el = $this->el('div', []);

// Title
$title = null;
if ($props['title'] ?? null) {
    $title = $this->el($props['title_element'], [

        'class' => [
            'uk-{title_style}',
            'uk-heading-{title_decoration}',
            'uk-font-{title_font_family}',
            'uk-text-{title_color} {@!title_color: background}',
        ],

    ]);
}

// Quote condition if it is an actual string
$props['on_condition'] =    (!is_numeric($props['on_condition']) &&
    $props['on_condition'] !== 'true' &&
    $props['on_condition'] !== 'false' &&
    $props['on_condition'] !== '')
    ? "'".$props['on_condition']."'"
    : $props['on_condition'];

// Quote condition if it is an actual string
$props['off_condition'] =    (!is_numeric($props['off_condition']) &&
    $props['off_condition'] !== 'true' &&
    $props['off_condition'] !== 'false' &&
    $props['off_condition'] !== '')
    ? "'".$props['off_condition']."'"
    : $props['off_condition'];

?>

<?= $el($props, $attrs); ?>

    <ais-toggle-refinement
            attribute="<?= $props['facet'] ?>"
            label="<?= $props['title'] ?>"

        <?php if ($props['on_condition']) : ?>
            :on="<?= $props['on_condition'] ?>"
        <?php endif ?>

        <?php if ($props['off_condition']) : ?>
            :off="<?= $props['off_condition'] ?>"
        <?php endif ?>
    >
        <div slot-scope="{ value, refine, createURL, sendEvent }">

            <?php if ($title): ?>
                <?php $titleAttrs = ['v-if' => 'value']; ?>
                <?= $title($props, $titleAttrs) ?>
                <?php if ($props['title_color'] == 'background') : ?>
                    <span class="uk-text-background"><?= $props['title'] ?></span>
                <?php elseif ($props['title_decoration'] == 'line') : ?>
                    <span><?= $props['title'] ?></span>
                <?php else : ?>
                    <?= $props['title'] ?>
                <?php endif ?>
                <?= $title->end() ?>
            <?php endif ?>

            <ul v-if="value" class="uk-list uk-list-small facet-filters">
                <li>
                    <label class="uk-form-label uk-flex uk-flex-row uk-flex-middle">
                        <input
                                class="uk-checkbox uk-margin-small-right"
                                type="checkbox"
                                :value="value"
                                :checked="value.isRefined"
                                @change="refine(value)"
                        />
                        <span class="uk-flex-1"><?= $props['facet_name'] ?></span>
                        <span class="uk-padding-small-left facet-count">{{ value.count }}</span>
                    </label>
                </li>
            </ul>
        </div>
    </ais-toggle-refinement>

<?= $el->end() ?>