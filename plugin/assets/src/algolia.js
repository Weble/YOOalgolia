import Vue from 'vue/dist/vue.esm'
import AlgoliaSearch from './components/AlgoliaSearch'

let $$ = window.UIkit.util.$$;

window.UIkit.util.ready(function(){
    $$('[data-algolia]').forEach(element => {
        new Vue({
            el: element,
            components: {
                AlgoliaSearch
            }
        })
    })
})

/* UTILS */
Vue.filter('truncate', function(text, length, clamp){
    clamp = clamp || '...';
    let node = document.createElement('div');
    node.innerHTML = text;
    let content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
});

