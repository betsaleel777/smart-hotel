<template>
    <b-table responsive hover :items="products" :fields="fields">
        <template v-slot:table-caption
            ><b>Total Vendus:</b> {{ vendus() }}
        </template>
    </b-table>
</template>
<script>
import { BTable } from "bootstrap-vue";
export default {
    name: "SearchResultPoint",
    components: {
        BTable,
    },
    props: ["products"],
    data() {
        return {
            fields: [
                {
                    key: "libelle",
                    label: "Libellé",
                },
                {
                    key: "prixVente",
                    label: "Prix Vente",
                },
                {
                    key: "sorties",
                    label: "Vendues",
                },
                {
                    key: "montant",
                    label: "Montant Vente",
                },
            ],
        };
    },
    methods: {
        vendus() {
            let totalVendu = 0;
            this.products.forEach((product) => {
                totalVendu += Number(product.montant);
            });
            return totalVendu;
        },
    },
};
</script>

<style scoped></style>
