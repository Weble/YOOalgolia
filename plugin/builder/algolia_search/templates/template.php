<?php
$el = $this->el('div', $attrs);

$search = $this->el('ais-search-box', [
    'placeholder' => $props['placeholder'] ?? '',
    'submit-title' => $props['submit-title'] ?? '',
    'reset-title' => $props['reset-title'] ?? '',
    'autofocus' => $props['autofocus'] ?? false,
    'show-loading-indicator' => $props['loading'] ?? false,
    ':class-names' => json_encode([
        'ais-SearchBox' => ' uk-position-relative',
        'ais-SearchBox-form' => 'uk-form',
        'ais-SearchBox-input' => 'uk-input uk-form-small',
        'ais-SearchBox-reset' => 'uk-button uk-button-default uk-button-small uk-position-absolute uk-position-right',
        'ais-SearchBox-submit' => 'uk-hidden', /*$this->expr([
            'uk-hidden uk-width-1-1 {@fullwidth}',
            'uk-{button_style: link-\w+}' => ['button_style' => $props['button_style']],
            'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $props['button_style']],
        ], $props)*/
    ])
])
?>

<?= $el($props, $attrs); ?>
    <?= $search($props); ?><?= $search->end(); ?>
<?= $el->end(); ?>
