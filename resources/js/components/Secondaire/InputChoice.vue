<template>
    <div>
        <div class="form-group">
            <label for="departement">Département</label>
            <b-form-select id="departement" v-model="selected" search>
                <option
                    v-for="departement in departements"
                    :key="departement.id"
                    :value="departement.id"
                >
                    {{ departement.nom }}
                </option>
            </b-form-select>
        </div>
        <div class="form-group">
            <label for="produit">Produit</label>
            <b-form-select
                id="produit"
                v-model="choice"
                search
                @change="getDetails"
            >
                <option
                    v-for="element in produits"
                    :key="element.id"
                    :value="element.id"
                >
                    {{ element.libelle }}
                </option>
            </b-form-select>
        </div>
        <div class="form-group">
            <label for="quantite">Quantite</label>
            <b-form-input
                id="quantite"
                v-model="quantite"
                :state="quantiteState"
                aria-describedby="input-live-help input-live-feedback"
            ></b-form-input>
            <b-form-invalid-feedback id="input-live-feedback">
                Quantite doit être un nombre , non vide !!
            </b-form-invalid-feedback>
            <b-form-text id="input-live-help">EX: 4</b-form-text>
        </div>
        <div v-if="showDetails" class="container">
            <b-card
                img-width="40%"
                :img-src="produit.image"
                :alt="produit.image"
                img-alt="Card image"
                img-left
                class="mb-3"
            >
                <b-card-text>
                    <strong>Référence:</strong>{{ produit.reference }}<br />
                    <strong>Libellé:</strong>{{ produit.libelle }}<br />
                    <strong>Prix:</strong>{{ produit.prix }}<br />
                    <strong>Seuil:</strong>{{ produit.seuil }}<br />
                    <strong>Catégorie:</strong
                    >{{ produit.sous_famille_linked.libelle }}<br />
                </b-card-text>
            </b-card>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <button
                    width="100%"
                    type="button"
                    class="btn btn-primary"
                    @click="send"
                >
                    valider
                </button>
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
            departements: [],
            selected: null,
            choice: null,
            produits: [],
            produit: null,
            quantite: '',
            prix:0,
            showDetails: false,
        }
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
    mounted() {
      this.getConsommables()
      this.getDepartements()
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
                this.prix = produit.prix
                this.showDetails = true;
            }).catch((err) => {})
        },
        getConsommables() {
            axios.get('/ajax/produit/consommables/all').then((response) => {
                const {
                    products
                } = response.data
                this.produits = products
            }).catch((err) => {})
        },
        getDepartements(){
          axios.get('/ajax/departements').then((response) => {
             this.departements  = response.data.departements.filter(departement => departement.id !== 1)
          }).catch((err) => {})
        },
        getProducts() {
            axios.get('/ajax/produit/all').then((response) => {
                const {
                    products
                } = response.data
                this.produits = products
            }).catch((err) => {})
        },
        send() {
            axios.post('/ajax/secondaire/store', { produit: this.choice, quantite: parseInt(this.quantite), achat: parseInt(this.prix), departement: this.selected }).then((response) => {
              this.$awn.success(response.data.message)
              this.vider()
            }).catch(err => {
                if (err.response.data.errors){
                   const errors = err.response.data.errors
                   const message = `${errors.quantite[0]}, ${errors.departement[0]}, ${errors.produit[0]}`
                   this.$awn.alert(message)
                }else{
                    if(err.response.data.message){
                       this.$awn.alert(err.response.data)
                    }
                }
            })
        },
        vider(){
              this.choice = null
              this.quantite = ''
              this.prix = 0
              this.selected = null
              this.showDetails = false
        }
    }
}
</script>
