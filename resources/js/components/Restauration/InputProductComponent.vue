<template>
<div class="form-group">
    <label for="produit">Produit</label>
    <b-form-select id="produit" v-on:change="getDetails" search v-model="choice">
        <option v-for="produit in produits" :key="produit.id" :value="produit.id">{{produit.libelle}}</option>
    </b-form-select>
    <label for="quantite">Quantite</label>
    <b-form-input id="quantite" :state="quantiteState" aria-describedby="input-live-help input-live-feedback" v-model="quantite"></b-form-input>
    <b-form-invalid-feedback id="input-live-feedback">
        Quantite doit être un nombre , non vide !!
    </b-form-invalid-feedback>
    <b-form-text id="input-live-help">EX: 4</b-form-text>
    <div v-if="showDetails" class="container">
        <b-card img-width="40%" :img-src="produit.image" :alt="produit.image" img-alt="Card image" img-left class="mb-3">
            <b-card-text>
                <strong>Référence:</strong>{{produit.reference}}<br>
                <strong>Libellé:</strong>{{produit.libelle}}<br>
                <strong>Prix:</strong>{{produit.prix}}<br>
                <strong>Seuil:</strong>{{produit.seuil}}<br>
                <strong>Catégorie:</strong>{{produit.sous_famille_linked.libelle}}<br>
            </b-card-text>
        </b-card>
    </div>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <button width="100%" @click="addit" type="button" class="btn btn-primary">valider</button>
        </div>
    </div>
</div>
</template>

<script lang="js">
import {
    BFormSelect,
    BCard,
    BCardText,
    BFormInput,
    BFormText,
    BFormInvalidFeedback
} from 'bootstrap-vue'
export default {
    components: {
        BFormSelect,
        BCard,
        BCardText,
        BFormInput,
        BFormText,
        BFormInvalidFeedback
    },
    data() {
        return {
            choice: null,
            produits: null,
            produit: null,
            quantite: '',
            showDetails: false,
        }
    },
    mounted() {
        this.getConsommables()
    },
    computed: {
        quantiteState() {
            if (this.quantite) {
                let etat = null
                if (this.quantite.length > 0 && !isNaN(Number(this.quantite)) && this.quantite != 0) {
                    etat = true
                } else {
                    etat = false
                }
                return etat
            } else {
                return null
            }
        }
    },
    methods: {
        getDetails() {
            axios.post('/ajax/produit/show', {
                produit: this.choice,
            }).then((response) => {
                const {
                    produit
                } = response.data
                this.produit = produit
                this.showDetails = true;
            }).catch((err) => {
                console.log(err)
            })
        },
        getConsommables() {
            axios.get('/ajax/produit/consommables/all').then((response) => {
                const {
                    products
                } = response.data
                this.produits = products
            }).catch((err) => {
                console.log(err)
            })
        },
        addit() {
            this.$root.$emit('add', this.produit, this.quantite)
            this.choice = null
            this.quantite = ''
        }
    }
}
</script>
