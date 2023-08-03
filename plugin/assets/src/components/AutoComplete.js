import algoliasearch from "algoliasearch/lite";
import {createQuerySuggestionsPlugin} from "@algolia/autocomplete-plugin-query-suggestions";
import {autocomplete, getAlgoliaResults} from "@algolia/autocomplete-js";
import { createRedirectUrlPlugin } from '@algolia/autocomplete-plugin-redirect-url';

import '@algolia/autocomplete-theme-classic';

const addClass = window.UIkit.util.addClass;
const attr = window.UIkit.util.attr;

export default {

    name: 'algoliaAutocomplete',

    props: {
        sources: Array,
        app_id: String,
        search_key: String,
        template: String,
        placeholder: String,
        openOnFocus: Boolean,
    },

    data: {

    },

    connected() {
        console.log(this.$props)
        addClass(this.$el, this.$options.id);
        attr(this.$el, 'role', this.role);
        this.createAutocomplete();
    },

    disconnected() {

    },

    events: {},

    methods: {
        createAutocomplete() {
            const props = this.$props;
            const searchClient = algoliasearch(props.app_id, props.search_key);
            const sources = props.sources[0] || [];
            const createSourceFromProps = this.createSourceFromProps;
            const generateTemplateLiteral = this.generateTemplateLiteral;

            const redirectUrlPlugin = createRedirectUrlPlugin();

            autocomplete({

                container: this.$el,
                placeholder: props.placeholder || 'Search',
                openOnFocus: props.openOnFocus || true,
                insights: true,
                plugins: [redirectUrlPlugin],
                getSources({query, state, setQuery, refresh}) {
                    if (!query) {
                        return [];
                    }

                    return sources.map((source) => createSourceFromProps({
                        searchClient,
                        query,
                        source,
                        state,
                        setQuery,
                        refresh,
                    }));
                },
                render({elements, render, html}, root) {
                    render(
                        generateTemplateLiteral(props.template, {html, elements: {...elements}}),
                        root
                    );
                },
            });


        },

        generateTemplateLiteral(templateString, templateVars){
            // templateString = templateString.replaceAll("${", "${this.");
            return new Function("return this.html`"+templateString +"`;").call(templateVars)
        },

        createSourceFromProps({searchClient, query, source, state, setQuery, refresh}) {
            const generateTemplateLiteral = this.generateTemplateLiteral;

            console.log(source);
            switch (source.type) {
                case "query-suggestions":
                    const plugin = createQuerySuggestionsPlugin({
                        searchClient,
                        indexName: source.props.index_name,
                        getSearchParams() {
                            return {
                                hitsPerPage: source.props.hits_per_page || 5,
                            };
                        },
                    });

                    return {
                        sourceId: source.props.name || 'querySuggestionsPlugin',
                        ...plugin.getSources({searchClient, query, source})[0]
                    };

                case "source":
                    return {
                        sourceId: source.props.name || 'items',
                        getItems() {
                            return getAlgoliaResults({
                                searchClient,
                                queries: [
                                    {
                                        indexName: source.props.index_name,
                                        query,
                                        params: {
                                            hitsPerPage: source.props.hits_per_page
                                            // attributesToSnippet: ['name:10'],
                                            // snippetEllipsisText: '…',
                                        },
                                    },
                                ],
                            });
                        },
                        templates: {
                            header({html}) {
                                return generateTemplateLiteral(source.props.header, {html});
                            },
                            footer({html}) {
                                return generateTemplateLiteral(source.props.footer, {html});
                            },
                            item({item, html, components, insights}) {
                                const vars = {
                                    hit: item,
                                    html,
                                    components,
                                    insights,
                                    state,
                                    setQuery,
                                    refresh,
                                };
                                return generateTemplateLiteral(source.props.template, vars);
                            },
                            noResults({html}) {
                                return generateTemplateLiteral(source.props.no_results, {html});
                            },
                        },
                    };
            }
        }
    }
};
