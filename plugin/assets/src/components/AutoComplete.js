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
        template: String,
        placeholder: String,
        openOnFocus: Boolean,
        autoFocus: Boolean,
        debug: Boolean,
        query: String,
        activeItemId: Number,
        clearButtonTitle: String,
        detachedCancelButtonText: String,
        submitButtonTitle: String,
        detachedMediaQuery: String,
        detachedCancelButton: String,
        detachedFormContainer: String,
        detachedContainer: String,
        detachedOverlay: String,
        detachedSearchButton: String,
        detachedSearchButtonIcon: String,
        detachedSearchButtonPlaceholder: String,
        form: String,
        input: String,
        inputWrapper: String,
        inputWrapperPrefix: String,
        inputWrapperSuffix: String,
        item: String,
        label: String,
        list: String,
        loadingIndicator: String,
        panel: String,
        panelLayout: String,
        clearButton: String,
        root: String,
        source: String,
        sourceFooter: String,
        sourceHeader: String,
        submitButton: String,
    },

    data: {

    },

    connected() {
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
            const sources = props.sources[0] || [];
            const createSourceFromProps = this.createSourceFromProps;
            const generateTemplateLiteral = this.generateTemplateLiteral;

            console.log(props);

            autocomplete({
                container: this.$el,
                placeholder: props.placeholder || 'Search',
                openOnFocus: props.openOnFocus || true,
                autoFocus: props.autoFocus || false,
                debug: props.debug || false,
                insights: true,
                plugins: [],
                initialState: {
                    query: props.query || '',
                    activeItemId: props.activeItemId || 0
                },
                translations: {
                    clearButtonTitle: props.clearButtonTitle || 'Clear',
                    detachedCancelButtonText: props.detachedCancelButtonText || 'Cancel',
                    submitButtonTitle: props.submitButtonTitle || 'Submit',
                },
                classNames: {
                    detachedCancelButton: props.detachedCancelButton || '',
                    detachedFormContainer: props.detachedFormContainer || '',
                    detachedContainer: props.detachedContainer || '',
                    detachedOverlay: props.detachedOverlay || '',
                    detachedSearchButton: props.detachedSearchButton || '',
                    detachedSearchButtonIcon: props.detachedSearchButtonIcon || '',
                    detachedSearchButtonPlaceholder: props.detachedSearchButtonPlaceholder || '',
                    form: props.form || '',
                    input: props.input || '',
                    inputWrapper: props.inputWrapper || '',
                    inputWrapperPrefix: props.inputWrapperPrefix || '',
                    inputWrapperSuffix: props.inputWrapperSuffix || '',
                    item: props.item || '',
                    label: props.label || '',
                    list: props.list || '',
                    loadingIndicator: props.loadingIndicator || '',
                    panel: props.panel || '',
                    panelLayout: props.panelLayout || '',
                    clearButton: props.clearButton || '',
                    root: props.root || '',
                    source: props.source || '',
                    sourceFooter: props.sourceFooter || '',
                    sourceHeader: props.sourceHeader || '',
                    submitButton: props.submitButton || '',
                },
                detachedMediaQuery: props.detachedMediaQuery === 'null' ? '' : props.detachedMediaQuery,
                getSources({query, state, setQuery, refresh}) {
                    if (!query) {
                        return [];
                    }

                    return sources.map((source) => createSourceFromProps({
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
            return new Function("return this.html`"+templateString +"`;").call(templateVars)
        },

        createSourceFromProps({query, source, state, setQuery, refresh}) {
            const generateTemplateLiteral = this.generateTemplateLiteral;

            const searchClient = algoliasearch(source.props.app_id, source.props.search_key);

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
                        ...plugin.getSources({searchClient, query, source})[0],
                        sourceId: source.props.name || 'querySuggestionsPlugin',
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
