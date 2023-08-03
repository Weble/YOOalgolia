import AutocompletePlugin from "./autocomplete.plugin";

window.UIkit.component('AlgoliaAutocomplete', AutocompletePlugin);

window.UIkit.util.$$('[uk-algolia-autocomplete]').forEach((element) => window.UIkit.algoliaAutocomplete(element));
