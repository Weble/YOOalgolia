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

function getRouting(indexName, routingRefinements) {

    const refinements = routingRefinements.split(',');

    return {
        router: historyRouter(),
        stateMapping: {
            stateToRoute(uiState) {

                let indexState = uiState[indexName];

                /* PROCESS */

                let state = {};

                refinements.forEach(function (refinement) {

                    var param = refinement.split(':');

                    if (indexState.refinementList && indexState.refinementList[param[1]]) {
                        state[param[0]] = indexState.refinementList[param[1]].join(',')
                    }
                });

                state['query'] = indexState.query;
                state['page'] = indexState.page;
                state['sortBy'] = indexState.sortBy;


                return state;
            },
            routeToState(routeState) {

                let refinementList = {};

                refinements.forEach(function (refinement) {

                    var param = refinement.split(':');

                    routeState[param[0]]

                    if (routeState[param[0]]) {
                        refinementList[param[1]] = routeState[param[0]].split(',');
                    }
                });

                let state = {};

                state[indexName] = {
                    query: routeState.query,
                    page: routeState.page,
                    refinementList: refinementList,
                    sortBy: routeState.sortBy
                }

                return state;
            }
        }
    };
}


function middleware({ instantSearchInstance }) {

    return {
        onStateChange({ uiState }) {
        },
        subscribe() {
            return
        },
        unsubscribe() {
            return
        }
    }
}

export default {

    props: ['baseUrl', 'algoliaIndexName', 'algoliaAppId', 'algoliaSearchKey', 'algoliaRoutingRefinements', 'refinementsOrder'],

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
            routing: getRouting(this.algoliaIndexName, this.algoliaRoutingRefinements),
            middlewares: [middleware]
        };
    },

    created() {

    },


    methods: {
    },

    watch: {}


};
