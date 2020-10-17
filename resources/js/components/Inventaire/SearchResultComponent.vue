<template>
    <b-table responsive hover :items="products" :fields="fields"></b-table>
</template>
<script>
import { BTable } from 'bootstrap-vue'
export default {
  name: 'SearchResult',
  components: {
    BTable
  },
  props: ['products'],
  data () {
    return {
      fields: [
        {
          key: 'libelle',
          label: 'Libellé'
        },
        {
          key: 'restes',
          label: 'Produits disponible'
        }
      ]
    }
  },
  methods: {}
}
</script>

<style scoped></style>
