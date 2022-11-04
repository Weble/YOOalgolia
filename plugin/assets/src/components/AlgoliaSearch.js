import algoliasearch from 'algoliasearch/lite';
import {
    AisConfigure,
    AisCurrentRefinements,
    AisHits,
    AisInstantSearch,
    AisMenu,
    AisPagination,
    AisRefinementList,
    AisStats,
    AisSearchBox,
    AisSortBy,
    AisRangeInput,
    AisToggleRefinement,
    AisClearRefinements
} from 'vue-instantsearch';

import {history as historyRouter} from 'instantsearch.js/es/lib/routers';

const routing = {
    router: historyRouter(),
    stateMapping: {
        stateToRoute(uiState) {
            /* uiState[~index_name~] */
            const indexUiState = uiState['prod_products'] || {};
            
            return {
                query: indexUiState.query,
                page: indexUiState.page,
                category: indexUiState.refinementList && indexUiState.refinementList['primary_category.name.en-GB'],
                exclusive: indexUiState.toggle && indexUiState.toggle['esclusiva.names'] || indexUiState.toggle && indexUiState.toggle['esclusiva.values'],
                sortBy: indexUiState.sortBy
            };
        },
        routeToState(routeState) {
            return {
                /* Index name */
                prod_products: {
                    query: routeState.query,
                    page: routeState.page,
                    refinementList: {
                        'primary_category.name.en-GB': routeState.category
                    },
                    toggle: {
                        'esclusiva.names': routeState.exclusive,
                        'esclusiva.values': routeState.exclusive,
                    },
                    sortBy: routeState.sortBy
                }
            };
        }
    }
};

export default {

    props: ['baseUrl', 'algoliaIndexName', 'algoliaAppId', 'algoliaSearchKey', 'refinementsOrder'],

    components: {
        AisInstantSearch,
        AisHits,
        AisConfigure,
        AisRefinementList,
        AisMenu,
        AisPagination,
        AisCurrentRefinements,
        AisStats,
        AisSearchBox,
        AisSortBy,
        AisRangeInput,
        AisToggleRefinement,
        AisClearRefinements
    },

    data() {
        return {
            searchClient: algoliasearch(
                this.algoliaAppId,
                this.algoliaSearchKey
            ),
            routing: routing
        };
    },

    created() {

    },


    methods: {

        groupBy: function(xs, key, key1, key2) {
            try {
                return xs.reduce(function(rv, x) {
                    (rv[x[key][key1][key2]] = rv[x[key][key1][key2]] || []).push(x);
                    return rv;
                }, {});
            }
            catch(err) {
                let missing = [];
                xs.forEach(item => {
                    if (item['primary_category'] === null) {
                        missing.push({ id: item.id, name: item.name })
                    }
                })

                console.error("Missing item categories:");
                console.error(missing);
            }
        },

        // Used for range element
        formatMinValue: function(minValue, minRange) {
            return minValue !== null && minValue !== minRange ? minValue : '';
        },
        formatMaxValue: function(maxValue, maxRange) {
            return maxValue !== null && maxValue !== maxRange ? maxValue : '';
        },

        truncate: function(text, length, clamp){
            clamp = clamp || '...';
            let node = document.createElement('div');
            node.innerHTML = text;
            let content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        }

    },

    watch: {}


};
