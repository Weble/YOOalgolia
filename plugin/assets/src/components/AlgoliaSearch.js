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
    AisToggleRefinement,
    AisHierarchicalMenu
} from 'vue-instantsearch';

//import MultipleRefinementList from './MultipleRefinementList.vue';

import {history as historyRouter} from 'instantsearch.js/es/lib/routers';

function getRouting(indexName, routingRefinements) {

    const refinements = JSON.parse(routingRefinements);

    return {
        router: historyRouter(),
        stateMapping: {
            stateToRoute(uiState) {

                let indexState = uiState[indexName];

                let state = {};

                refinements.forEach(function (refinement) {

                    if (indexState.refinementList && indexState.refinementList[refinement.field]) {
                        state[refinement.name] = indexState.refinementList[refinement.field].join(',')
                    }

                    if (indexState.hierarchicalMenu && indexState.hierarchicalMenu[refinement.field]) {
                        state[refinement.name] = indexState.hierarchicalMenu[refinement.field].join(',')
                    }


                });

                state['query'] = indexState.query;
                state['page'] = indexState.page;
                state['sortBy'] = indexState.sortBy;

                return state;
            },
            routeToState(routeState) {

                let refinementList = {};

                let hierarchicalMenu = {};

                refinements.forEach(function (refinement) {

                    if (routeState[refinement.name]) {
                        refinementList[refinement.field] = routeState[refinement.name].split(',');
                        hierarchicalMenu[refinement.field] = routeState[refinement.name].split(',');
                    }
                });

                let state = {};

                state[indexName] = {
                    query: routeState.query,
                    page: routeState.page,
                    refinementList: refinementList,
                    hierarchicalMenu: hierarchicalMenu,
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
        AisToggleRefinement,
        AisHierarchicalMenu
    },

    data() {
        return {
            searchClient: algoliasearch(
                this.algoliaAppId,
                this.algoliaSearchKey
            ),
            routing: getRouting(this.algoliaIndexName, this.algoliaRoutingRefinements),
            middlewares: [middleware],
            searchableFacets: [],
            filters: []
        };
    },

    created() {

    },


    methods: {

        renameAttributes: function(attribute, data) {

            if (! data[attribute]) {
                return attribute;
            }

            return data[attribute];
        },

        popFacet: function (event) {

            if (event.key != 'Backspace') {
                return;
            }

            let value = event.target.value;

            if (value.length > 0) {
                return;
            }

            this.filters.pop();

        },


        searchForFacets: async function(facets, value) {

            if (value == '' || facets.length == 0) {
                this.searchableFacets = [];
                return;
            }

            let index = this.searchClient.initIndex(this.algoliaIndexName);

            let results = [];

            for (const facet of facets) {
                var result = await index.searchForFacetValues(facet, value);
                for (const value of result.facetHits) {
                    value.facet = facet
                    results.push(value);
                }
            }

            this.searchableFacets = results;

        },

        getSearchableFacets: function() {
            return this.searchableFacets;
        },

        toggleFilter: function(facet, value) {


            for (var i = 0; i < this.filters.length; i++) {
                if (this.filters[i].attribute == facet && this.filters[i].value == value) {
                    this.filters.splice(i, 1);
                    return;
                }
            }

            this.filters.push({
                attribute: facet,
                value: value
            });
        },

        getFilters: function() {
            return this.filters;
        },

        getFormattedFilters: function(additionalFilters = '') {

            let ff = [];
            for (const filter of this.filters) {

                ff.push(filter.attribute +":'"+ filter.value +"'")
            }

            if (!additionalFilters) {
                return ff.join(' OR ');
            }

            if (this.filters.length == 0) {
                return additionalFilters;
            }

            return additionalFilters + ' AND (' + ff.join(' OR ') + ')';

        }



    },

    watch: {}


};
