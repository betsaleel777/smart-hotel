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
                                <strong>{{
                                    `${line.prix}x${line.quantite}`
                                }}</strong>
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
                <div role="group" class="btn-group-vertical col-md-4">
                    <button class="btn btn-primary" @click="saveProforma">
                        <i class="fas fa-file-invoice"></i> Enregistrer
                    </button>
                    <!-- <button @click="proformaPdf" class="btn btn-warning"><i class="fas fa-print"></i> exporter pdf</button> -->
                </div>
                <div role="group" class="btn-group-vertical col-md-4">
                    <button class="btn btn-success" @click="solder">
                        <i class="fas fa-file-invoice-dollar"></i> Solder
                    </button>
                    <!-- <button @click="facturerPdf" class="btn btn-warning"><i class="fas fa-print"></i> exporter pdf</button> -->
                </div>
                <div class="col-md-4">
                    <button class="btn btn-danger" @click="supprimer">
                        <i class="fas fa-trash-alt"></i> Supprimer
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
    props: ["client", "passage", "attribution"],
    data() {
        return {
            total: "0",
            list: [],
            checkResponse: {},
        };
    },
    mounted() {
        this.getProformas();
        //on definit ce que le composant doit faire quand il detecte qu'un produit a été ajouté à sa liste
        this.$root.$on("add", (produit, quantite) => {
            if (produit && quantite) {
                let elt = {};
                let found = false;
                //si le produit selectionné plus d'une fois on modifie la quantite dans la section suivante
                if (this.list.length > 0) {
                    let quantiteUpdated = 0;
                    let newTab = this.list.map((line) => {
                        if (line.id === produit.id) {
                            line.quantite =
                                Number(line.quantite) + Number(quantite);
                            quantiteUpdated = line.quantite;
                            this.checkStock(produit.id, quantiteUpdated);
                            found = true;
                        }
                        return line;
                    });
                    this.list = newTab;
                }
                //fin de section
                //dans le cas où le produit a été nouvellement sélectionné on l'ajoute à la liste dans la section suivante
                if (!found) {
                    elt.id = produit.id;
                    elt.libelle = produit.libelle;
                    elt.prix = Number(produit.prix);
                    elt.quantite = Number(quantite);
                    //avant de l'ajouter à la liste des produits on vérifie si la quanité renseignée est cohérente avec le stock
                    this.checkStock(produit.id, Number(quantite));
                    this.list.push(elt);
                }
                //fin de section
                this.totaliser();
            } else {
                this.$awn.warning(
                    "Veuillez choisir un produit et renseigner la quantité !!"
                );
            }
        });
    },
    methods: {
        removeIt(id) {
            let newTab = this.list.filter((line) => line.id !== id);
            this.list = newTab;
            this.totaliser();
        },
        totaliser() {
            let total = 0;
            this.list.forEach((line) => {
                total += line.quantite * line.prix;
            });
            this.total = total;
        },
        getProformas() {
            const url = this.passage
                ? "/ajax/restauration/passage/proformas"
                : "/ajax/restauration/proformas";
            axios
                .post(url, {
                    attribution: this.attribution,
                })
                .then((response) => {
                    this.list = response.data.proformas;
                    this.totaliser();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        saveProforma() {
            if (this.list.length > 0) {
                const url = this.passage
                    ? "/ajax/restauration/passage/save"
                    : "/ajax/restauration/save";
                axios
                    .post(url, {
                        proformas: this.list,
                        attribution: this.attribution,
                    })
                    .then((response) => {
                        this.$awn.success(response.data.message);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.$awn.info("aucun produit selectionné");
            }
        },
        supprimer() {
            if (this.list.length > 0) {
                const url = this.passage
                    ? "/ajax/restauration/passage/save"
                    : "/ajax/restauration/save";
                axios
                    .post(url, {
                        attribution: this.attribution,
                    })
                    .then(() => {
                        this.$awn.success(
                            "la suppression de la commande vient d'être éffectuée avec succès!!"
                        );
                        this.list = null;
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.$awn.info("aucune commande de restauration enregistrée");
            }
        },
        solder() {
            if (this.list.length > 0) {
                const url = this.passage
                    ? "/ajax/restauration/passage/solder"
                    : "/ajax/restauration/solder";
                axios
                    .post(url, {
                        attribution: this.attribution,
                        proformas: this.list,
                    })
                    .then((response) => {
                        this.$awn.success(response.data.message);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                this.$awn.info("aucune commande de restauration enregistrée");
            }
        },
        checkStock(produit, quantite) {
            console.log(produit, quantite);
            axios
                .post("/ajax/restauration/check", {
                    produit: produit,
                    quantite: quantite,
                })
                .then((response) => {
                    if (!response.data.state) {
                        this.$awn.warning(response.data.message);
                        this.removeIt(produit);
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        proformaPdf() {
            const url = this.passage
                ? "/home/restauration/passage/pdf/proforma/"
                : "/home/restauration/sejour/pdf/proforma/";
            location.href = url + this.attribution;
        },
        facturerPdf() {
            const url = this.passage
                ? "/home/restauration/passage/pdf/facture/"
                : "/home/restauration/sejour/pdf/facture/";
            location.href = url + this.attribution;
        },
    },
};
</script>
