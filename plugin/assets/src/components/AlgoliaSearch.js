import algoliasearch from 'algoliasearch/lite';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';

import {
    AisConfigure,
    AisCurrentRefinements,
    AisHits,
    AisInstantSearch,
    AisMenu,
    AisHierarchicalMenu,
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

function getRouting(component) {

    const indexName = component._props.algoliaIndexName;
    const refinements = JSON.parse(component._props.algoliaRoutingRefinements);
    const routerArrayFormat = component._props.algoliaRouterArrayFormat

    // Used for default algolia routing functions
    let defaultRouter = historyRouter();

    return {
        router: historyRouter(
            {
                createURL({qsModule, routeState, location}) {
                    let url = defaultRouter._createURL({qsModule, routeState, location});
                    let query = qsModule.parse(url.split('?')[1]);

                    Object.entries(query).forEach(([key, value]) => {
                        value = value.split(',').map(v => {
                            return v.replace(',', '');
                        })
                        query[key] = value;
                    })

                    const queryString = qsModule.stringify(query, {
                        addQueryPrefix: true,
                        arrayFormat: routerArrayFormat,
                    });

                    return `${location.origin}${location.pathname}${queryString}`;
                },

                parseURL({qsModule, location}) {
                    let query = qsModule.parse(location.search.slice(1));

                    Object.entries(query).forEach(([key, value]) => {
                        value = Array.isArray(value) ? value : [value];
                        query[key] = value.join(',')
                    })

                    return qsModule.parse(query);
                }
            }),

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
                    sortBy: routeState.sortBy,
                    refinementList,
                    hierarchicalMenu
                }

                return state;
            }
        }
    };
}


function middleware({instantSearchInstance}) {

    return {
        onStateChange({uiState}) {},
        subscribe() {},
        unsubscribe() {}
    }
}

export default {

    props: [
        'baseUrl',
        'algoliaIndexName',
        'algoliaAppId',
        'algoliaSearchKey',
        'algoliaRoutingRefinements',
        'refinementsOrder',
        'algoliaRouterArrayFormat'
    ],

    components: {
        AisInstantSearch,
        AisHits,
        AisConfigure,
        AisRefinementList,
        AisMenu,
        AisHierarchicalMenu,
        AisPagination,
        AisCurrentRefinements,
        AisStats,
        AisSearchBox,
        AisSortBy,
        VueSlider,
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
            routing: getRouting(this),
            middlewares: [middleware],
            searchableFacets: [],
            filters: []
        };
    },

    created() {

    },


    methods: {

        renameAttributes: function (attribute, data) {

            if (!data[attribute]) {
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

        searchForFacets: async function (facets, value) {

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

        getSearchableFacets: function () {
            return this.searchableFacets;
        },

        toggleFilter: function (facet, value) {


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

        getFilters: function () {
            return this.filters;
        },

        getFormattedFilters: function (additionalFilters = '') {

            let ff = [];
            for (const filter of this.filters) {

                ff.push(filter.attribute + ":'" + filter.value + "'")
            }

            if (!additionalFilters) {
                return ff.join(' OR ');
            }

            if (this.filters.length == 0) {
                return additionalFilters;
            }

            return additionalFilters + ' AND (' + ff.join(' OR ') + ')';

        },

        toValue(value, range) {
            return [
                typeof value.min === "number" ? value.min : range.min,
                typeof value.max === "number" ? value.max : range.max,
            ];
        },

        groupBy: function (xs, key, key1, key2) {
            return xs.reduce(function (rv, x) {
                (rv[x[key][key1][key2]] = rv[x[key][key1][key2]] || []).push(x);
                return rv;
            }, {});
        },

        formatMinValue: function (minValue, minRange) {
            return minValue !== null && minValue !== minRange ? minValue : '';
        },

        formatMaxValue: function (maxValue, maxRange) {
            return maxValue !== null && maxValue !== maxRange ? maxValue : '';
        },

        truncate: function (text, length, clamp) {
            clamp = clamp || '...';
            let node = document.createElement('div');
            node.innerHTML = text;
            let content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        }

    },

    watch: {}


};
