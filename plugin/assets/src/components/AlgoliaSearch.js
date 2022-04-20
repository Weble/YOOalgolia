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


    methods: {},

    watch: {}


};
