<template>
<div class="">
    <FullCalendar @eventClick="handleEvent" @select="handleSelect" defaultView="dayGridMonth" :events="evenement" :plugins="calendarPlugins" :selectable="true" :weekends="true" />
    <b-modal @ok="handleOk" id="modal">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input class="form-control" id="nom" type="text" v-model="client.nom">
            <label for="prenom">Prenom:</label>
            <input class="form-control" id="prenom" type="text" name="" v-model="client.prenom">
            <label for="type">Piece:</label>
            <select id="type" class="form-control" v-model="client.piece">
                <option v-for="typePiece in typePieces" :value="typePiece.id">{{typePiece.libelle}}</option>
            </select>
            <label for="batiment">Batiments:</label>
            <select v-on:change="getChambres" id="batiment" class="form-control" v-model="batiment">
                <option v-for="batiment in batiments" :value="batiment.id">{{batiment.libelle}}</option>
            </select>
            <label for="chambre">Chambre:</label>
            <select id="chambre" class="form-control" v-model="chambre">
                <option v-for="chambre in chambres" :value="chambre.id">{{chambre.libelle}}</option>
            </select>
            <label for="numero">Numero de la pièce:</label>
            <input class="form-control" id="numero" type="text" v-model="client.numero">
            <label for="contact">Contact du client:</label>
            <input class="form-control" id="contact" type="text" v-model="client.contact">
        </div>
    </b-modal>
</div>
</template>

<script>
import {
    BModal
} from 'bootstrap-vue'
import moment from 'moment'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import frLocale from '@fullcalendar/core/locales/fr'
Vue.component('b-modal', BModal)
export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            calendarPlugins: [dayGridPlugin, interactionPlugin],
            evenement: [{
                    id: 1,
                    title: 'event 1',
                    date: '2019-12-01',
                    backgroundColor: this.randomColor()
                },
                {
                    id: 2,
                    title: 'event 2',
                    date: '2019-12-02',
                    backgroundColor: this.randomColor()
                }
            ],
            client: {
                nom: null,
                prenom: null,
                numero: null,
                contact: null,
                piece: null
            },
            chambres: null,
            chambre:null,
            batiments: null,
            batiment: null,
            typePieces: null
        }
    },
    methods: {
        handleSelect(info) {
            const end = moment(info.endStr).subtract(1, 'days').format('DD-MM-YYYY')
            this.getType()
            //this.getChambres()
            this.$bvModal.show('modal')
            //console.log(info.startStr,info.endStr,end)
            //lancer un modal bootstrap4
            //je dois faire une table séjour et une table attribution sejour
        },
        handleEvent(info) {
            //utiliser l'id de l'évenement pour aller chercher les information afin de préremplir les champs
            //si la date de fin n'est pas déjà passé
            this.getType()
            //this.getChambres()
            this.$bvModal.show('modal')
        },
        randomColor() {
            const colors = ['#00cbb5', '#fec83c', '#003366', '#31367e', '#ff6652', '#ffa500', '#d3191c', '#d549c4', '#ffd700']
            return colors[Math.floor(Math.random() * 8)]
        },
        getType() {
            axios.get('/api/typePiece/all').then((response) => {
                this.typePieces = response.data.pieces
            }).catch((error) => {
                console.log(error)
            })
        },
        getChambres() {
            axios.get('/api/chambres/all/'+this.batiment).then((response) => {
                this.chambres = response.data.chambres
            }).catch((error) => {
                console.log(error)
            })
        },
        getBatiments() {
            axios.get('/api/batiments/all/').then((response) => {
                this.batiments = response.data.all
            }).catch((error) => {
                console.log(error)
            })
        },
        updateEvent() {
            // la méthode à utiliser pour lancer une modification des évenement
        },
        handleOk() {
            //créer table client son controller et son model
            console.log('formulaire soumis');
        }
    }
}
</script>

<style lang="scss">
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
</style>
