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
} from 'vue-instantsearch';

import {history as historyRouter} from 'instantsearch.js/es/lib/routers';

const routing = {
    it: {
        router: historyRouter(),
        stateMapping: {
            stateToRoute({iess: {query, refinementList, page}}) {

                return {
                    query: query,
                    tipologie:
                        refinementList &&
                        refinementList['category.name.it-IT'] &&
                        refinementList['category.name.it-IT'].join(','),
                    page: page
                };
            },
            routeToState({query, tipologie, page}) {
                return {
                    iess: {
                        query: query,
                        refinementList: {
                            'category.name.it-IT': tipologie && tipologie.split(','),
                        },
                        page: page
                    }
                };
            }
        }
    },
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
    },

    data() {
        return {
            searchClient: algoliasearch(
                this.algoliaAppId,
                this.algoliaSearchKey
            ),
            routing: routing.it
        };
    },

    created() {

    },


    methods: {},

    watch: {}


};
