<template>
    <div class="">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <label for="">Départements</label>
                    <b-form-select
                        v-model="selected"
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
            <div class="row">
                <div class="col-md-5">
                    <label for="start">Debut</label>
                    <b-form-datepicker
                        id="start"
                        v-model="debut"
                        :disabled="desactiverFirst"
                        :date-disabled-fn="dateDisabled"
                        placeholder="Choix de la date de debut"
                        locale="fr"
                        @context="onSelect"
                    ></b-form-datepicker>
                </div>
                <div class="col-md-5">
                    <label for="fin">Fin</label>
                    <b-form-datepicker
                        id="fin"
                        v-model="fin"
                        locale="fr"
                        :min="minDate"
                        :max="maxDate"
                        :date-disabled-fn="dateDisabled"
                        :disabled="desactiverSecond"
                        placeholder="Choix de la date de fin"
                        @context="onSelectSecond"
                    ></b-form-datepicker>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <label for="date">Date</label>
                    <b-form-datepicker
                        id="date"
                        v-model="oneDate"
                        :disabled="desactiverThree"
                        placeholder="Choix de la date unique"
                        locale="fr"
                        :date-disabled-fn="dateDisabled"
                        @context="onSelectUnique"
                    ></b-form-datepicker>
                </div>
                <div class="col-md-2">
                    <label class="invisible">invisible</label>
                    <button
                        type="button"
                        class="reset btn btn-outline-primary"
                        @click="clear"
                    >
                        reset
                    </button>
                </div>
            </div>
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
                <SearchResultPoint :products="produits"></SearchResultPoint>
            </div>
        </div>
    </div>
</template>

<script>
import { BFormSelect, BFormDatepicker } from "bootstrap-vue";
import moment from "moment";
import SearchResultPoint from "./SearchResultPoint";
export default {
    components: {
        BFormSelect,
        BFormDatepicker,
        SearchResultPoint,
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
            famille: "",
            familles: [],
            selected: 1,
            departements: [],
            sous_famille: "",
            sous_familles: [],
            oneDate: null,
            debut: null,
            fin: null,
            desactiverFirst: false,
            desactiverSecond: true,
            desactiverThree: false,
            minDate: null,
            maxDate: null,
            disableDepartement: false,
        };
    },
    mounted() {
        this.getFamilles();
        this.getDepartements();
        if (this.userdep !== 1) {
            this.disableDepartement = true;
            this.selected = this.userdep;
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
                .catch(() => {});
        },
        dateDisabled(ymd, date) {
            const someDate = date.getTime();
            const now = new Date();
            return now < someDate;
        },
        onSelect(context) {
            if (context.selectedDate) {
                const now = new Date();
                if (context.selectedDate.getDate() === now.getDate()) {
                    this.clear();
                    this.$awn.warning(
                        "Attention la date d'aujourd'hui ne peut être choisie comme date de debut"
                    );
                } else {
                    this.desactiverSecond = null;
                    this.desactiverThree = "disabled";
                    this.minDate = context.selectedDate;
                    this.maxDate = now;
                }
            }
        },
        onSelectSecond(context) {
            if (context.selectedDate) {
                if (context.selectedDate.getDate() === this.minDate.getDate()) {
                    this.clear();
                    this.$awn.warning(
                        "Attention des dates différentes doivent être spécifiées"
                    );
                }
            }
        },
        onSelectUnique(context) {
            if (context.selectedDate) {
                this.desactiverFirst = true;
                this.desactiverSecond = true;
                this.minDate = null;
                this.minDate = null;
                this.debut = null;
                this.fin = null;
            }
        },
        clear() {
            this.desactiverSecond = true;
            this.desactiverFirst = false;
            this.desactiverThree = false;
            this.type = "all";
            this.oneDate = null;
            this.debut = null;
            this.fin = null;
            this.famille = null;
            this.sous_famille = null;
            this.selected = this.userdep;
        },
        send() {
            if (this.debut && this.fin) {
                if (moment(this.fin).isAfter(this.debut)) {
                    axios
                        .post("/ajax/multicritere/vente/interval_date", {
                            type: this.type,
                            famille: this.famille,
                            sous_famille: this.sous_famille,
                            departement: this.selected,
                            debut: this.debut,
                            fin: this.fin,
                        })
                        .then((response) => {
                            if (response.data.point.length > 0) {
                                this.produits = response.data.point.map(
                                    (produit) => {
                                        return {
                                            libelle: produit.libelle,
                                            prixVente: produit.prix,
                                            sorties: produit.sortie,
                                            montant:
                                                Number(produit.sortie) *
                                                produit.prix,
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
                } else {
                    this.clear();
                    this.$awn.warning(
                        "Intervale de date selectionné incorrecte! la date de début doit précéder celle de fin"
                    );
                }
            } else if (this.oneDate) {
                axios
                    .post("/ajax/multicritere/vente/one_date", {
                        type: this.type,
                        famille: this.famille,
                        sous_famille: this.sous_famille,
                        oneDate: this.oneDate,
                        departement: this.selected,
                    })
                    .then((response) => {
                        if (response.data.point.length > 0) {
                            this.produits = response.data.point.map(
                                (produit) => {
                                    return {
                                        libelle: produit.libelle,
                                        prixVente: produit.prix,
                                        sorties: produit.sortie,
                                        montant:
                                            Number(produit.sortie) *
                                            produit.prix,
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
            } else {
                axios
                    .post("/ajax/multicritere/vente/default", {
                        type: this.type,
                        famille: this.famille,
                        sous_famille: this.sous_famille,
                        departement: this.selected,
                    })
                    .then((response) => {
                        if (response.data.point.length > 0) {
                            this.produits = response.data.point.map(
                                (produit) => {
                                    return {
                                        libelle: produit.libelle,
                                        prixVente: produit.prix,
                                        sorties: produit.sortie,
                                        montant:
                                            Number(produit.sortie) *
                                            produit.prix,
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
