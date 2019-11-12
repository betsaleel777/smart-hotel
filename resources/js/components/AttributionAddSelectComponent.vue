<template>
<div class="form-group">
    <label>Batiment:</label>
    <select @change="crier" class="form-control" id="batiment" name="batiment">
        <option disabled selected> choix du batiment</option>
        <option v-for="bat in bats" :value="bat.id">{{bat.libelle}}</option>
    </select>
      <label for="">Occupée</label><input class="form-group" type="radio" name="statut" value="plein">
      <label for="">Vide</label><input class="form-group" type="radio" name="statut" value="vide">
</div>
</template>

<script>
export default {
    props:['batiments'],
    data() {
        return {
            bats: this.batiments
        }
    },
    methods:{
      crier: function(){
        const csrf = document.querySelector('head meta[name="csrf-token"]').getAttribute('content')
        const radios = document.getElementsByName('statut')
        const batiment = document.getElementById('batiment').value
        let statut = null
        for (var i = 0, c = radios.length ; i < c; i++) {
          if(radios[i].checked){
            statut = radios[i].value
          }
        }
        this.$root.$emit('charger',statut,csrf,batiment)
      }
    }
}
</script>

<style lang="css" scoped>
</style>
