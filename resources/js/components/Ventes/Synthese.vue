<template>
    <div class="container">
        <b-card border-variant="warning" :header="'items sélectionnés'">
            <b-card-text>
                <ul class="list-group list-group-flush">
                    <li
                        v-for="line in list"
                        :key="line.id"
                        class="list-group-item"
                    >
                        <div class="row">
                            <div class="col-md-7">{{ `${line.libelle} ` }}</div>
                            <div class="col-md-4">
                                <strong>{{ `(${line.quantite})` }}</strong>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-danger btn-sm">
                                    <i
                                        class="fas fa-trash-alt"
                                        @click="removeIt(line.id)"
                                    ></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </b-card-text>
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <button class="btn btn-primary" @click="envoyer">
                        <i class="fas fa-send"></i> Envoyer
                    </button>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
import { BCard, BCardText } from "bootstrap-vue";
export default {
    components: {
        BCard,
        BCardText,
    },
    data() {
        return {
            total: "0",
            list: [],
            departement: null,
            fields: [
                {
                    key: "libelle",
                    label: "Libellé",
                    sortable: true,
                },
                {
                    key: "quantite",
                    label: "Quantité",
                    sortable: true,
                },
                {
                    key: "option",
                    label: "Option",
                    sortable: true,
                },
            ],
        };
    },
    mounted() {
        this.$root.$on("add", (produit, quantite, prix, departement) => {
            if (produit && quantite && departement) {
                let elt = {};
                let found = false;
                if (this.list.length > 0) {
                    let newTab = this.list.map((line) => {
                        if (line.id === produit.id) {
                            line.quantite =
                                Number(line.quantite) + Number(quantite);
                            line.prix = Number(prix);
                            found = true;
                        }
                        return line;
                    });
                    this.list = newTab;
                }
                if (!found) {
                    elt.id = produit.id;
                    elt.libelle = produit.libelle;
                    elt.quantite = Number(quantite);
                    elt.prix = Number(prix);
                    this.list.push(elt);
                }
                this.departement = departement;
            } else {
                this.$awn.warning(
                    "Veuillez choisir le produit, la quantité et le département!!"
                );
            }
        });
    },
    methods: {
        removeIt(id) {
            let newTab = this.list.filter((line) => line.id !== id);
            this.list = newTab;
        },
        envoyer() {
            if (this.list.length > 0) {
                axios
                    .post("/ajax/ventes/store", {
                        items: this.list,
                        departement: this.departement,
                    })
                    .then((response) => {
                        // console.log(response.data);
                        if (response.data.message) {
                            this.$awn.success(response.data.message);
                            this.list = [];
                            this.$root.$emit("vider");
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.$awn.warning("Aucun produit sélectionné");
            }
        },
    },
};
</script>
