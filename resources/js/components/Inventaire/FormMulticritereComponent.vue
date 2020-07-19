<template>
  <div class="">
    <div class="form-group">
      <div class="form-row">
        <div class="col">
          <label for="">Famille</label>
          <b-form-select
            @change="getSousFamilles"
            v-model="famille"
            :options="familles"
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
            style="width:100%"
            @click="send"
            type="button"
            class="btn btn-outline-success"
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
import { BFormSelect } from 'bootstrap-vue'
import SearchResult from './SearchResultComponent'
export default {
  components: {
    BFormSelect,
    SearchResult
  },
  data () {
    return {
      produits: [],
      famille: '',
      familles: [],
      sous_famille: '',
      sous_familles: [],
      type: 'consommable',
      types: [
        {
          text: 'accéssoires',
          value: 'accessoire'
        },
        {
          text: 'consommables',
          value: 'consommable'
        }
      ]
    }
  },
  mounted () {
    this.getFamilles()
  },
  methods: {
    getFamilles () {
      axios
        .get('/parametre/famille/ajax/all')
        .then(response => {
          const data = response.data.familles
          this.familles = data.map(famille => {
            return {
              text: famille.libelle,
              value: famille.id
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    getSousFamilles () {
      axios
        .get('/parametre/sous_famille/ajax/' + this.famille)
        .then(response => {
          const data = response.data.sous_familles
          this.sous_familles = data.map(sous_famille => {
            return {
              text: sous_famille.libelle,
              value: sous_famille.id
            }
          })
        })
        .catch(err => {
          console.log(err)
        })
    },
    send () {
      axios
        .post('/ajax/multicritere/default/', {
          type: this.type,
          famille: this.famille,
          sous_famille: this.sous_famille
        })
        .then(response => {
          if (response.data.inventaire.length > 0) {
            this.produits = response.data.inventaire.map(produit => {
              return {
                libelle: produit.libelle,
                prix: produit.prix,
                entrees: produit.entree,
                sorties: produit.sortie,
                restes: Number(produit.entree) - Number(produit.sortie),
                marge: Number(produit.sortie) * produit.prix
              }
            })
          } else {
            this.$awn.info('Aucun resultat trouvé pour cette recherche')
          }
        })
        .catch(err => console.log(err))
    }
  }
}
</script>

<style scoped>
.invisible {
  visibility: hidden;
}

.reset {
  width: 100%;
}
</style>
