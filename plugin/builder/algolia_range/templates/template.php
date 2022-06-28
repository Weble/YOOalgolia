<?php
$el = $this->el('div', []);

// Title
$title = null;
if ($props['title'] ?? null) {
    $title = $this->el($props['title_element'], [

        'class' => [
            'el-title',
            'uk-{title_style}',
            'uk-heading-{title_decoration}',
            'uk-text-{title_color} {@!title_color: background}',
        ],

    ]);
}

?>

<?= $el($props, $attrs); ?>

        <ais-range-input attribute="<?= $props['facet'] ?>">
            <div slot-scope="{
                    currentRefinement,
                    range,
                    canRefine,
                    refine,
                    sendEvent
          }">

                <?php if ($title): ?>
                    <?php $titleAttrs = ['v-if' => 'canRefine']; ?>
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

                <input
                        type="number"
                        :min="range.min"
                        :max="range.max"
                        placeholder="da"
                        :disabled="!canRefine"
                        :value="formatMinValue(currentRefinement.min, range.min)"
                        @input="refine({
                              min:$event.currentTarget.value,
                              max: formatMaxValue(currentRefinement.max, range.max),
                        })"
                >
                <input
                        type="number"
                        :min="range.min"
                        :max="range.max"
                        placeholder="a"
                        :disabled="!canRefine"
                        :value="formatMaxValue(currentRefinement.max,range.max)"
                        @input="refine({
                              min:formatMinValue(currentRefinement.min, range.min),
                              max: $event.currentTarget.value,
                        })"
                >
            </div>
        </ais-range-input>

<?= $el->end(); ?>
