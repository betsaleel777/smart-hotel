<template>
<div class="form-group">
    <label>Batiment:</label>
    <select v-on:change="refresh" class="form-control" name="batiment" v-model="choosen">
        <option disabled selected> choix du batiment</option>
        <option v-for="bat in bats" :value="bat.id">{{bat.libelle}}</option>
    </select>
    <label for="used">Occupée</label><input v-on:change="crier" class="form-group" type="radio" value="plein" v-model="statut">
    <label for="empty">Vide</label><input v-on:change="crier" class="form-group" type="radio" value="vide" v-model="statut">
</div>
</template>

<script>
export default {
    props: ['batiments'],
    data() {
        return {
            bats: this.batiments,
            choosen: null,
            statut: null,
        }
    },
    methods: {
        crier: function() {
            //const csrf = document.querySelector('head meta[name="csrf-token"]').getAttribute('content')
            if (this.choosen && this.statut) {
                this.$root.$emit('charger', this.statut, this.choosen)
            }
        },
        refresh (){
          console.log('refresh run!!');
        }
    }
}
</script>

<style lang="css" scoped>
</style>
