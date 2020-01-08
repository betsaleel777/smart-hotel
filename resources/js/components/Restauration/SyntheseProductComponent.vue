<template>
  <div class="container">
    <b-card border-variant="warning" :header="`total:${total}`" :footer="`total:${total}`" align="center">
      <b-card-text>
        <ul >
          <li v-for="line in list" :key="line.id">{{`${line.libelle}:`}}
             <strong>{{`${line.prix}x${line.quantite}`}}</strong>
             <i @click="removeIt(line.id)" class="red fas fa-trash"></i>
           </li>
        </ul>
      </b-card-text>
      <div class="row">
        <div class="col-md-4"><button @click="saveProforma"  class="btn btn-primary"><i class="fas fa-file-invoice"></i> proforma</button></div>
        <div class="col-md-4"><button @click="supprimer" class="btn btn-danger"><i class="fas fa-trash-alt"></i> supprimer</button></div>
        <div class="col-md-4"><button @click="facturer" class="btn btn-success"><i class="fas fa-file-invoice-dollar"></i> facturer</button></div>
      </div>
    </b-card>
  </div>
</template>

<script>
import {BCard,BCardText} from 'bootstrap-vue'
export default {
    components:{
      BCard,
      BCardText
    },
    props: ['client','sejour'] ,
    data() {
        return {
            total:'0',
            list:[]
        }
    },
    mounted(){
      this.getProformas()
      this.$root.$on('add',(produit,quantite) => {
        if(produit && quantite){
          let elt = {}
          let found = false
          if(this.list.length>0){
            let newTab = this.list.map((line) =>{
              if(line.id === produit.id){
                line.quantite = Number(line.quantite) + Number(quantite)
                found = true
              }
              return line
            })
            this.list = newTab
          }

          if(!found){
            elt.id = produit.id
            elt.libelle = produit.libelle
            elt.prix = Number(produit.prix)
            elt.quantite = Number(quantite)
            this.list.push(elt)
          }
          this.totaliser()
        }else{
          this.$awn.warning('Veuillez choisir un produit et renseigner la quantité !!')
        }
      })
    },
    methods:{
      removeIt(id){
        let newTab = this.list.filter(line => line.id !== id )
        this.list = newTab
        this.totaliser()
      },
      totaliser(){
        let total = 0
        this.list.forEach((line) =>{
          total += line.quantite*line.prix
        })
        this.total = total
      },
      getProformas(){
        axios.post('/api/restauration/proformas',{sejour:this.sejour}).then((response) => {
           this.list = response.data.proformas
           this.totaliser()
        }).catch((err) => {
           console.log(err);
        })
      },
      saveProforma(){
        if(this.list.length>0){
          axios.post('/api/restauration/save',{proformas:this.list,sejour:this.sejour}).then((response) =>{
            this.$awn.success('la commande vient d\'être enregistrée avec succès!!')
          }).catch((err) => {
            console.log(err);
          })
        }else{
          this.$awn.info('aucun produit selectionné')
        }
      },
      supprimer(){
        if(this.list.length>0){
          axios.post('/api/restauration/delete',{sejour:this.sejour}).then((response) =>{
            this.$awn.success('la suppression de la commande vient d\'être éffectuée avec succès!!' )
            this.list = null
          }).catch((err) =>{
            console.log(err);
          })
        }else{
          this.$awn.info('aucune commande de restauration enregistrée')
        }
      },
      facturer(){
        if(this.list.length>0){
          this.$awn.info('le bouuton n\'est pas encore fonctionnel')
          // axios.post('/api/restauration/facturer',{sejour:this.sejour}).then((response) =>{
          //   const {facture} = response.data
          //   this.$awn.success('la commande de restauration a bien été facturer définitivement \n reférence: '+ facture.reference)
          //   this.list = null
          // }).catch((err) =>{
          //   console.log(err);
          // })
        }else{
            this.$awn.info('aucune commande de restauration enregistrée')
        }
      },
      proformaPdf(){
        location.href='/home/restauration/sejour/pdf/proforma/'+this.sejour
      },
      facturerPdf(){
        // location.href='/home/restauration/sejour/pdf/facture/'+this.sejour
        this.$awn.info('le boutton n\'est pas encore fonctionnel')
      }
    }
}
// arranger le style des listes
// envoyer le client en props
// utiliser la table restauration comme pivot laravel model config
//
</script>
<style>

</style>
