<template>
    <div class="container">
        <b-card
            border-variant="warning"
            :header="`total:${total}`"
            :footer="`total:${total}`"
        >
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
                                        @click="removeIt(line.id, line.vente)"
                                    ></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </b-card-text>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <button
                        :disabled="disableSolder"
                        style="width: 100%"
                        class="btn btn-success"
                        @click="solder"
                    >
                        <i class="fas fa-save"></i> solder
                    </button>
                </div>
                <div class="col-md-4">
                    <button
                        style="width: 100%"
                        class="btn btn-primary"
                        @click="envoyer"
                    >
                        <i class="fas fa-paper-plane"></i> Envoyer
                    </button>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
import { BCard, BCardText } from "bootstrap-vue";
import axios from "axios";
export default {
    components: {
        BCard,
        BCardText,
    },
    props: {
        code: {
            type: String,
            default: "",
        },
        departement: {
            type: Number,
            default: 0,
        },
        table: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            total: "0",
            list: [],
            selectedDepartement: null,
            disableSolder: false,
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
            this.disableSolder = true;
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
                //fin de section
                this.totaliser();
                this.selectedDepartement = departement;
            } else {
                this.$awn.warning(
                    "Veuillez choisir le produit, la quantité, département, la table"
                );
            }
        });
        this.getOldVentes();
    },
    methods: {
        removeIt(id, vente) {
            console.log(vente);
            if (vente) {
                this.deleteVente(vente);
            }
            let newTab = this.list.filter((line) => line.id !== id);
            this.list = newTab;
        },
        totaliser() {
            let total = 0;
            this.list.forEach((line) => {
                total += line.quantite * line.prix;
            });
            this.total = total;
        },
        getOldVentes() {
            axios
                .get("/ajax/ventes/old/" + this.code)
                .then((result) => {
                    this.list = result.data.ventes;
                    this.totaliser();
                })
                .catch(() => {});
        },
        envoyer() {
            if (this.list.length > 0) {
                axios
                    .post("/ajax/ventes/update", {
                        items: this.list,
                        departement: this.selectedDepartement,
                        table: this.table,
                        code: this.code,
                    })
                    .then(() => {
                        this.$root.$emit("vider");
                        location.href = "/home/vente/index";
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.$awn.warning("Aucun produit sélectionné");
            }
        },
        deleteVente(vente) {
            console.log("la vente supprimée est " + vente);
        },
        solder() {
            axios
                .post("/ajax/ventes/solder", {
                    items: this.list,
                    code: this.code,
                })
                .then(() => {
                    location.href = "/home/vente/index";
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
