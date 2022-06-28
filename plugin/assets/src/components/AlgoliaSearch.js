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
} from 'vue-instantsearch';

import {history as historyRouter} from 'instantsearch.js/es/lib/routers';

const routing = {
    router: historyRouter(),
    stateMapping: {
        stateToRoute({query, page}) {
            return {
                query: query,
                page: page
            };
        },
        routeToState({query, page}) {
            return {
                search: {
                    query: query,
                    page: page
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
