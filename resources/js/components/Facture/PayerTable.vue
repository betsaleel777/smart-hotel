<template>
  <div>
   <button @click="runModal" class="btn btn-success float-right" ><i class="far fa-credit-card"></i> Faire Payer</button>
   <b-modal @ok="send" id="payer" title="PAYEMENT TABLE">
     <form class="form-group">
     <label for="heures">Nombre de Personne</label>
     <input class="form-control" type="text" v-model="nombre">
     </form>
   </b-modal>
  </div>
</template>

<script>
import { BModal } from 'bootstrap-vue'
export default {
  props: ['facture'],
  components: {
    BModal
  },
  data () {
    return { nombre: 0 }
  },
  methods: {
    runModal () {
      this.$bvModal.show('payer')
      console.log('modal is running, facture:' + this.facture)
    },
    send () {
      axios.post('/ajax/solder', { encaissement: this.facture, nombre: this.nombre }).then((response) => {
        location.href = '/home/facture'
      }).catch((err) => { console.log(err) })
    }
  }
}
</script>

<style>

</style>
