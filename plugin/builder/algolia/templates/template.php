<?php
$container = $this->el('div', [
    'data-algolia' => 'true',
    'v-cloak' => true
]);

$config = $node->algolia ?? [];
$attrs['id'] = $attrs['id'] ?? 'algolia-' . $node->id;
?>

<?= $container($props, $attrs) ?>
    <algolia-search
        algolia-app-id="<?= $config['app_id']; ?>"
        algolia-search-key="<?= $config['search_key']; ?>"
        algolia-index-name="<?= $config['index_name']; ?>"
        algolia-routing-refinements=<?= $node->routing; ?>
        algolia-router-array-format="<?= $config['router_array_format'] ?>"
        inline-template
    >
        <ais-instant-search
                :search-client="searchClient"
                :index-name="algoliaIndexName"
                :middlewares="middlewares"
                :routing="routing">
            <div>
                <?= $builder->render($children) ?>
            </div>
        </ais-instant-search>
    </algolia-search>
<?= $container->end(); ?>
