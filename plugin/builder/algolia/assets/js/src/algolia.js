import Vue from 'vue/dist/vue.esm'
import AlgoliaSearch from './components/AlgoliaSearch'

let $$ = window.UIkit.util.$$;

$$('[data-algolia]').forEach(element => {
    new Vue({
        el: element,
        components: {
            AlgoliaSearch
        }
    })
})
