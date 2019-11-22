<template>
<div class="">
    <table v-show="visible" class="table table-bordered table-striped">
        <thead>
            <th>Chambre</th>
            <th>Type</th>
            <th>Coût</th>
            <th>Statut</th>
            <th>Options</th>
        </thead>
        <tbody>
            <tr v-for="chambre in chambres" :key="chambre.id">
                <td>{{chambre.libelle}}</td>
                <td>{{chambre.type_linked.libelle}}</td>
                <td>{{chambre.type_linked.cout_passage}}</td>
                <td v-show="chambre.statut === 'inoccupée'">
                    <h5><span class="badge badge-success">{{chambre.statut}}</span></h5>
                </td>
                <td v-show="chambre.statut === 'occupée'">
                    <h5><span class="badge badge-danger">{{chambre.statut}}</span></h5>
                </td>
                <td v-show="chambre.statut === 'reservée'">
                    <h5><span class="badge badge-primary">{{chambre.statut}}</span></h5>
                </td>
                <td><button @click="open(chambre.id)" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-small-attribution">attribuer</button></td>
            </tr>
        </tbody>
        <tfoot>
            <th>Chambre</th>
            <th>Type</th>
            <th>Coût</th>
            <th>Statut</th>
        </tfoot>
        <attribution-add-modal :batiment="batiment" :chambre="identifiant"></attribution-add-modal>
    </table>
</div>
</template>

<script>
Vue.component('attribution-add-modal', require('./AttributionAddModalComponent').default);
export default {
    data() {
        return {
            visible: false,
            chambres: '',
            identifiant: null,
            message: null,
            batiment: null,
        }
    },
    mounted() {
        this.$root.$on('charger', (statut, batiment) => {
            this.batiment = batiment
            this.getChambres(statut, batiment)
        })
    },
    methods: {
        open: function(chambre) {
            this.identifiant = chambre
        },
        getChambres: function(statut, batiment) {
            this.visible = true
            if (statut == null) {
                this.fetchAllRooms(batiment)
            } else if (statut == 'vide') {
                this.fetchEmptyRooms(batiment)
            } else {
                this.fetchUsedRooms(batiment)
            }
        },
        fetchAllRooms: function(batiment) {
            let current = this
            axios.get('/api/chambres/all/' + batiment).then(function(response) {
                current.chambres = response.data.chambres
                current.message = `${response.data.chambres.length} chambres ont été répertoriées !!`
                current.showAlert()
            }, function(response) {
                console.log('une erreure a eu lieu', response);
            });
        },
        fetchEmptyRooms: function(batiment) {
            let current = this
            axios.get('/api/chambres/empty/' + batiment).then(function(response) {
                current.chambres = response.data.chambres
                current.message = `${response.data.chambres.length} chambres vides !!`
                current.showAlert()
            }, function(response) {
                console.log('une erreure a eu lieu', response);
            });
        },
        fetchUsedRooms: function(batiment) {
            let current = this
            axios.get('/api/chambres/used/' + batiment).then(function(response) {
                current.chambres = response.data.chambres
                current.message = `${response.data.chambres.length} chambres utilisées !!`
                current.showAlert()
            }, function(response) {
                console.log('une erreure a eu lieu', response);
            });
        }
    }
}
</script>
