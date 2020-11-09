<template>
    <div class="">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <label for="">Departements</label>
                    <b-form-select
                        v-model="departement"
                        :options="departements"
                        :disabled="disableDepartement"
                    ></b-form-select>
                </div>
                <div class="col">
                    <label for="">Famille</label>
                    <b-form-select
                        v-model="famille"
                        :options="familles"
                        @change="getSousFamilles"
                    ></b-form-select>
                </div>
                <div class="col">
                    <label for="">Sous Famille</label>
                    <b-form-select
                        v-model="sous_famille"
                        :options="sous_familles"
                    ></b-form-select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Type</label>
            <b-form-select v-model="type" :options="types"></b-form-select>
        </div>
        <div class="form-group">
            <center>
                <div class="col-md-6">
                    <button
                        style="width: 100%"
                        type="button"
                        class="btn btn-outline-success"
                        @click="send"
                    >
                        Afficher
                    </button>
                </div>
            </center>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <SearchResult :products="produits"></SearchResult>
            </div>
        </div>
    </div>
</template>

<script>
import { BFormSelect } from "bootstrap-vue";
import SearchResult from "./SearchResultComponent";
export default {
    components: {
        BFormSelect,
        SearchResult,
    },
    props: {
        userdep: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            produits: [],
            departement: 1,
            departements: [],
            secondaires: [],
            famille: "",
            familles: [],
            sous_famille: "",
            sous_familles: [],
            type: "consommable",
            types: [
                {
                    text: "accéssoires",
                    value: "accessoire",
                },
                {
                    text: "consommables",
                    value: "consommable",
                },
            ],
            disableDepartement: false,
        };
    },
    mounted() {
        this.getFamilles();
        this.getDepartements();
        if (this.userdep !== 1) {
            this.disableDepartement = true;
            this.departement = this.userdep;
        }
    },
    methods: {
        getFamilles() {
            axios
                .get("/parametre/famille/ajax/all")
                .then((response) => {
                    const data = response.data.familles;
                    this.familles = data.map((famille) => {
                        return {
                            text: famille.libelle,
                            value: famille.id,
                        };
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getSousFamilles() {
            axios
                .get("/parametre/sous_famille/ajax/" + this.famille)
                .then((response) => {
                    const data = response.data.sous_familles;
                    this.sous_familles = data.map((sous_famille) => {
                        return {
                            text: sous_famille.libelle,
                            value: sous_famille.id,
                        };
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getDepartements() {
            axios
                .get("/ajax/departements")
                .then((response) => {
                    this.departements = response.data.departements.map(
                        (departement) => {
                            return {
                                text: departement.nom,
                                value: departement.id,
                            };
                        }
                    );
                })
                .catch((err) => {});
        },
        getSecondaire() {
            axios
                .get("/ajax/secondaires")
                .then((response) => {
                    this.secondaires = response.data.secondaires;
                })
                .catch((err) => {});
        },
        send() {
            if (this.departement === 1) {
                //les sortie du stock général vers les différents départements
                this.getSecondaire();
                axios
                    .post("/ajax/multicritere/default", {
                        type: this.type,
                        famille: this.famille,
                        sous_famille: this.sous_famille,
                        departement: this.departement,
                    })
                    .then((response) => {
                        if (response.data.inventaire.length > 0) {
                            //inventaire de l'approvisionement général en considérerant uniquement les sortie du département siège
                            const produits = response.data.inventaire.map(
                                (produit) => {
                                    return {
                                        libelle: produit.libelle,
                                        id: produit.produit,
                                        entrees: produit.entree,
                                        sorties: produit.sortie,
                                        restes:
                                            Number(produit.entree) -
                                            Number(produit.sortie),
                                    };
                                }
                            );
                            //deduire les sortie de stock lié aux differents départements de l'inventaire précedent pour avoir le vrai inventaire
                            this.produits = produits.map((produit) => {
                                let found = this.secondaires.filter(
                                    (secondaire) =>
                                        secondaire.produit == produit.id
                                );
                                if (found.length > 0) {
                                    return {
                                        libelle: produit.libelle,
                                        restes:
                                            produit.restes - found[0].quantite,
                                    };
                                } else {
                                    return {
                                        libelle: produit.libelle,
                                        restes: produit.restes,
                                    };
                                }
                            });
                        } else {
                            this.$awn.info(
                                "Aucun resultat trouvé pour cette recherche"
                            );
                        }
                    })
                    .catch((err) => console.log(err));
            } else {
                axios
                    .post("/ajax/multicritere/departement", {
                        type: this.type,
                        famille: this.famille,
                        sous_famille: this.sous_famille,
                        departement: this.departement,
                    })
                    .then((response) => {
                        if (response.data.inventaire.length > 0) {
                            this.produits = response.data.inventaire.map(
                                (produit) => {
                                    return {
                                        libelle: produit.libelle,
                                        entrees: produit.entree,
                                        sorties: produit.sortie,
                                        restes:
                                            Number(produit.entree) -
                                            Number(produit.sortie),
                                    };
                                }
                            );
                        } else {
                            this.$awn.info(
                                "Aucun resultat trouvé pour cette recherche"
                            );
                        }
                    })
                    .catch((err) => console.log(err));
            }
        },
    },
};
</script>

<style scoped>
.invisible {
    visibility: hidden;
}

.reset {
    width: 100%;
}
</style>
