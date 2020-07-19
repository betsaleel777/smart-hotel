<template>
    <b-table responsive hover :items="products" :fields="fields"></b-table>
</template>
<script>
import { BTable } from 'bootstrap-vue'
export default {
  name: 'SearchResultPoint',
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
          key: 'prixAchat',
          label: 'Prix Achat'
        },
        {
          key: 'prixVente',
          label: 'Prix Vente'
        },
        {
          key: 'sorties',
          label: 'Vendus'
        },
        {
          key: 'montant',
          label: 'Montant Vente'
        },
        {
          key: 'marge',
          label: 'Marge'
        }
      ]
    }
  },
  methods: {}
}
</script>

<style scoped></style>
