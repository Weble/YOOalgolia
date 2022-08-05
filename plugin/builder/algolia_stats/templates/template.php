<?php
$el = $this->el('div', [
    'class' => 'el-element'
]);

$dictionary = [
    '{page}' => '{{ page + 1 }}',
    '{nbPages}' => '{{ nbPages }}',
    '{hitsPerPage}' => '{{ hitsPerPage }}',
    '{nbHits}' => '{{ nbHits }}',
    '{processingTimeMS}' => '{{ processingTimeMS }}',
    '{query}' => '{{ query }}'
];

foreach ($dictionary as $search => $replace) {
    $props['text'] = str_replace($search, $replace, $props['text']);
}


?>

<?= $el($props, $attrs); ?>
    <ais-stats>
        <div slot-scope="{ hitsPerPage, nbPages, nbHits, page, processingTimeMS, query }">
            <?= $props['text'] ?>
        </div>
    </ais-stats>
<?= $el->end(); ?>
