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
    router: historyRouter({
        createURL({ qsModule, routeState, location }) {
            const queryParameters = {};

            if (routeState.query) {
                queryParameters.query = encodeURIComponent(routeState.query);
            }
            if (routeState.page !== 1) {
                queryParameters.page = routeState.page;
            }
            if (routeState.category) {
                queryParameters.category = routeState.category.map(encodeURIComponent);
            }
            if (routeState.exclusive) {
                queryParameters.exclusive = routeState.exclusive;
            }

            const queryString = qsModule.stringify(queryParameters, {
                addQueryPrefix: true,
                arrayFormat: 'repeat',
            });

            return `${location.origin}${location.pathname}${queryString}`;
        },

        parseURL({ qsModule, location }) {
            const uiState = qsModule.parse(
                location.search.slice(1)
            );

            // `qs` does not return an array when there's a single value.
            return {
                query: decodeURIComponent(uiState.query ?? ''),
                page: uiState.page,
                category: toArray(uiState.category).map(decodeURIComponent),
                toggle: uiState.exclusive
            };
        },
    }),

    stateMapping: {
        stateToRoute(uiState) {
            /* uiState[~index_name~] */
            const indexUiState = uiState['prod_products'] || {};
            console.log(indexUiState);

            return {
                query: indexUiState.query,
                page: indexUiState.page,
                category: indexUiState.refinementList && indexUiState.refinementList['primary_category.name.en-GB'],
                exclusive: indexUiState.toggle && indexUiState.toggle['esclusiva.names'] || indexUiState.toggle && indexUiState.toggle['esclusiva.values']
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
                        'esclusiva.names': routeState.exclusive === 'true',
                        'esclusiva.values': routeState.exclusive === 'true',
                    }
                }
            };
        }
    }
};

const toArray = function(array) {
    return Array.isArray(array)
        ? array
        : [array].filter(Boolean);
}

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
            return xs.reduce(function(rv, x) {
                (rv[x[key][key1][key2]] = rv[x[key][key1][key2]] || []).push(x);
                return rv;
            }, {});
        },

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
