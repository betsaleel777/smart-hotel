<template>
    <b-table responsive hover :items="products" :fields="fields">
       <template v-slot:table-caption><b>Total Vendus:</b> {{vendus()}}<br>
        <b>Total Marge:</b> {{marges()}}
       </template>
    </b-table>

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
          label: 'Quantité'
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
  methods: {
    vendus () {
      let totalVendu = 0
      this.products.forEach(product => {
        totalVendu += Number(product.montant)
      })
      return totalVendu
    },
    marges () {
      let totalMarge = 0
      this.products.forEach(product => {
        totalMarge += Number(product.marge)
      })
      return totalMarge
    }
  }
}
</script>

<style scoped></style>
