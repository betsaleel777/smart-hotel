<template>
  <b-table
    responsive
    striped
    hover
    :items="products"
    :fields="fields"
  ></b-table>
</template>
<script>
import { BTable } from "bootstrap-vue";
export default {
  name: "SearchResult",
  components: {
    BTable
  },
  props: ["products"],
  data() {
    return {
      fields: [
        {
          key: "libelle",
          label: "Libellé"
        },
        {
          key: "prix",
          label: "Prix Vente"
        },
        {
          key: "entrees",
          label: "Entrées"
        },
        {
          key: "sorties",
          label: "Sorties"
        },
        {
          key: "restes",
          label: "Restes"
        },
        {
          key: "marge",
          label: "Marge"
        }
      ]
    };
  },
  methods: {}
};
</script>

<style scoped></style>
