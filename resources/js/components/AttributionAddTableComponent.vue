<template>
<table v-show="visible" id="attribution">
    <thead>
        <th>Chambre</th>
        <th>Type</th>
        <th>Coût</th>
        <th>Statut</th>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <th>Chambre</th>
        <th>Type</th>
        <th>Coût</th>
        <th>Statut</th>
    </tfoot>
</table>
</template>

<script>
export default {
    data() {
        return {
            visible: false,
            chambres: ''
        }
    },
    mounted() {
        this.$root.$on('charger', (statut,csrf,batiment) => {
            console.log(statut,csrf,batiment);
            this.getChambres(statut,csrf,batiment)
        })
    },
    methods: {
        getChambres: function(statut,csrf,batiment) {
            this.visible = true
            if(statut == null){
              this.fetchAllRooms(batiment)
            }else if (statut == 'vide') {
              this.fetchEmptyRooms(statut,csrf,batiment)
            }else{
              this.fetchUsedRooms(statut,csrf,batiment)
            }
        },
        fetchAllRooms: function(batiment) {
            //get content of meta csrf and id selected
            this.$http.get('api/chambres/all/'+batiment).then(function(response) {
                console.log(reponse.data);
                this.$set('chambres', response.data);
            }, function(response) {
                console.log('une erreure a eu lieu', reponse);
            });
        },
        fetchEmptyRooms: function(statut,csrf,batiment) {
            //get by name
            // get by id this.$refs.myId.innerText = 'Hello Bro';
            this.$http.get('api/chambres/empty').then(function(response) {
                this.$set('chambres', response.data);
            }, function(response) {
                console.log('une erreure a eu lieu', reponse);
            });
        },
        fetchUsedRooms: function(statut,csrf,batiment) {
            //get content of meta csrf and id selected
            this.$http.get('api/chambres/used').then(function(response) {
                this.$set('chambres', response.data);
            }, function(response) {
                console.log('une erreure a eu lieu', reponse);
            });
        }
    }
}
</script>
