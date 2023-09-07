<template>
  <search-input
      v-model="searchForFacetValues"
      :placeholder="placeholder"
      :class-names="classNames"
  />
</template>

<script>
import SearchInput from 'vue-instantsearch/src/components/SearchInput.vue'
export default {
  components: {
    SearchInput
  },
  props: {
    classNames: {
      type: Object
    },
    placeholder: {
      type: String
    },
    searchForItems: {
      type: Function
    }
  },
  data() {
    return {
      searchForFacetValuesQuery: '',
    };
  },
  computed: {
    searchForFacetValues: {
      get() {
        return this.searchForFacetValuesQuery;
      },
      set(value) {
        this.searchForItems(value);
        this.searchForFacetValuesQuery = value;
      },
    },
  }
}
</script>
