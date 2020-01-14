<template>
<div class="">
    <FullCalendar @eventClick="handleEventClick" @select="handleSelect" defaultView="dayGridMonth" :events="evenement" :plugins="calendarPlugins" :selectable="true" :eventLimit="true" :weekends="true" />

    <b-modal @hidden="resetModal" @ok="saveEvent" id="modal">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input class="form-control" id="nom" type="text" v-model="client.nom">
            <label for="prenom">Prenom:</label>
            <input class="form-control" id="prenom" type="text" v-model="client.prenom">
            <label for="type">Piece:</label>
            <b-form-select v-model="client.piece">
                <option id="type" v-for="typePiece in typePieces" :key="typePiece.id" :value="typePiece.id">{{typePiece.libelle}}</option>
            </b-form-select>
            <label for="batiment">Batiments:</label>
            <b-form-select @change="getChambres" id="batiment" v-model="batiment">
                <option v-for="bat in batiments" :key="bat.id" :value="bat.id">{{bat.libelle}}</option>
            </b-form-select>
            <label for="chambre">Chambre:</label>
            <b-form-select @change="getRoomDetails" id="chambre" v-model="chambre">
                <option v-for="room in chambres" :key="room.id" :value="room.id">{{room.libelle}}</option>
            </b-form-select>
            <small class="text-muted">{{message.details}}</small><br>
            <label for="remise">Remise:</label>
            <b-form-select id="remise" class="form-control" v-model="remise">
                <option v-for="remise in pourcentages" :key="remise.valeur" :value="remise.valeur">{{remise.libelle}}</option>
            </b-form-select>
            <label for="avance">Avance:</label>
            <b-form-select @change="prixNet" id="avance" v-model="avance">
                <option v-for="avance in pourcentages" :key="avance.valeur" :value="avance.valeur">{{avance.libelle}}</option>
            </b-form-select>
            <small class="text-muted">{{message.net}}</small><br>
            <label for="numero">Numero de la pièce:</label>
            <input class="form-control" id="numero" type="text" v-model="client.numero">
            <label for="contact">Contact du client:</label>
            <input class="form-control" id="contact" type="text" v-model="client.contact">
        </div>
    </b-modal>

    <b-modal @hidden="resetModal" @ok="updateEvent" id="modal-update">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input class="form-control" id="nom" type="text" v-model="client.nom">
            <label for="prenom">Prenom:</label>
            <input class="form-control" id="prenom" type="text" v-model="client.prenom">
            <label for="remise">Remise:</label>
            <b-form-select id="remise" class="form-control" v-model="remise">
                <option v-for="remise in pourcentages" :key="remise.valeur" :value="remise.valeur">{{remise.libelle}}</option>
            </b-form-select>
            <label for="avance">Avance:</label>
            <b-form-select id="avance" v-model="avance">
                <option v-for="avance in pourcentages" :key="avance.valeur" :value="avance.valeur">{{avance.libelle}}</option>
            </b-form-select>
            <label for="debut">Debut:</label>
            <input id="debut" v-model="timeInterval.debut" type="text" class="form-control">
            <label for="contact">Fin:</label>
            <input id="fin" v-model="timeInterval.fin" type="text" class="form-control">
            <div class="row form-group">
                <div class="col-md-4">
                    <button @click="liberer" class="btn btn-light"><i class="fas fa-door-open"></i>libération</button>
                </div>
                <div class="col-md-4">
                    <button @click="supprimer" class="btn btn-light"><i class="fas fa-trash"></i>suppression</button>
                </div>
                <div class="col-md-4">
                    <button @click="runRestaurantPage" class="btn btn-light"><i class="fas fa-drumstick-bite"></i>restauration</button>
                </div>
            </div>
        </div>
    </b-modal>
</div>
</template>

<script>
import {
    BModal,
    BFormSelect
} from 'bootstrap-vue'
import moment from 'moment'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
export default {
    components: {
        FullCalendar,
        BModal,
        BFormSelect
    },
    data() {
        return {
            calendarPlugins: [dayGridPlugin, interactionPlugin],
            evenement: null,
            timeInterval: {
                debut: null,
                fin: null
            },
            client: {
                nom: null,
                prenom: null,
                numero: null,
                contact: null,
                piece: null
            },
            pourcentages: this.getPourcentages(),
            details: null,
            remise: null,
            avance: null,
            message: {
                net: null,
                details: null
            },
            idSejourAttribution: null,
            chambres: null,
            chambre: null,
            batiments: null,
            batiment: null,
            typePieces: null,
            delais: null,
        }
    },
    mounted() {
        this.getEvents()
    },
    methods: {
        runRestaurantPage() {
            location.href = '/home/restauration/add/' + this.idSejourAttribution
        },
        handleSelect(info) {
            const end = moment(info.endStr).subtract(1, 'days')
            const start = moment(info.startStr)
            this.delais = end.diff(start, 'days')
            if (end.diff(start, 'days') === 0) {
                this.$awn.warning('le délais ainsi choisit ne nécessite pas l\'enregistrement d\'une réservation, attribuez plutôt une chambre de passage')
            } else {
                this.timeInterval.debut = start.format('YYYY-MM-DD').toString()
                this.timeInterval.fin = end.format('YYYY-MM-DD').toString()
                this.getType()
                this.getBatiments()
                this.$bvModal.show('modal')
            }
        },
        handleEventClick(info) {
            //si la date de fin n'est pas déjà passé
            //changer la valeur de idSejourAttribution
            let {
                event
            } = info
            this.idSejourAttribution = event.id
            this.getType()
            this.getBatiments()
            this.getModalInfos()
            this.$bvModal.show('modal-update')
        },
        randomColor() {
            const colors = ['#00cbb5', '#fec83c', '#c2cf86', '#31367e', '#ff6652', '#ffa500', '#d3191c', '#d549c4', '#ffd700']
            return colors[Math.floor(Math.random() * 8)]
        },
        getType() {
            axios.get('/api/typePiece/all').then((response) => {
                this.typePieces = response.data.pieces
            }).catch((error) => {
                console.log(error)
            })
        },
        getPourcentages() {
            let pourcentages = []
            for (let i = 0; i < 100; i++) {
                const valeur = i / 100
                const libelle = String(i) + '%'
                pourcentages.push({
                    valeur: valeur,
                    libelle: libelle
                })
            }
            return pourcentages
        },
        getChambres() {
            axios.get('/api/chambres/empty/' + this.batiment).then((response) => {
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
        getRoomDetails() {
            axios.get('/api/chambre/details/' + this.chambre).then((response) => {
                let {
                    chambre
                } = response.data
                this.details = chambre
                this.message.details =
                    `Chambre:${chambre.libelle}, Type:${chambre.type_linked.libelle},
                     Coût/J:${chambre.type_linked.cout_reservation} jours, Delais:${this.delais},
                     Prix:${chambre.type_linked.cout_reservation*this.delais}`
            }).catch((error) => {
                console.log(error)
            })
        },
        getEvents() {
            axios.get('/api/sejour/all').then((response) => {
                this.evenement = response.data.events.map((event) => {
                    let calebasse = {}
                    calebasse.id = event.id
                    calebasse.title = event.sejour_linked.client_linked.nom + '-' + event.sejour_linked.client_linked.contact
                    calebasse.start = event.sejour_linked.debut
                    calebasse.end = moment(event.sejour_linked.fin).add(1, 'days').format('YYYY-MM-DD').toString()
                    calebasse.backgroundColor = this.randomColor()
                    return calebasse
                })
            }).catch((err) => {
                console.log(err);
            })
        },
        getModalInfos() {
            axios.get('/api/sejour/infos/' + this.idSejourAttribution).then((response) => {
                let {
                    encaissement,
                    sejour_linked
                } = response.data.infos
                let {
                    client_linked
                } = sejour_linked
                this.client.nom = client_linked.nom
                this.client.prenom = client_linked.prenom
                this.timeInterval.debut = sejour_linked.debut
                this.timeInterval.fin = sejour_linked.fin
                this.chambres = this.getChambres()
                this.remise = encaissement.remise / 100
                this.avance = encaissement.avance / 100
            }).catch((error) => {
                console.log(error)
            })
        },
        liberer() {
            axios.post('/api/sejour/liberer', {
                attribution: this.idSejourAttribution,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content')
            }).then((response) => {
                const chambre = response.data.chambre
                const message = `la chmabre ${chambre.libelle} a été libérée avec succès !!`
                this.getEvents()
                this.$awn.success(message)
            }).catch((error) => {
                console.log(error);
            })

        },
        supprimer() {
            axios.post('/api/sejour/supprimer', {
                attribution: this.idSejourAttribution,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content')
            }).then((response) => {
                const {
                    chambre
                } = response.data
                const {
                    client
                } = response.data
                const {
                    sejour
                } = response.data
                const message =
                    `la réservation du client:${client.nom} ${client.prenom}
                                 pour la chambre ${chambre.libelle}, réservée du
                                 ${sejour.debut} midi à ${sejour.fin} midi a été supprimée avec succès!!`
                this.getEvents()
                this.$awn.success(message)
            }).catch((error) => {
                console.log(error);
            })

        },
        updateEvent() {
            const end = moment(this.timeInterval.fin)
            const start = moment(this.timeInterval.debut)
            this.delais = end.diff(start, 'days')
            if (this.delais === 0) {
                this.$awn.warning('le délais ainsi choisit ne nécessite pas l\'enregistrement d\'une réservation, attribuez plutôt une chambre de passage')
            }
            axios.post('/api/sejour/update', {
                nom: this.client.nom,
                prenom: this.client.prenom,
                debut: this.timeInterval.debut,
                fin: this.timeInterval.fin,
                attribution: this.idSejourAttribution,
                remise: this.remise,
                avance: this.avance,
                delais: this.delais,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content')
            }).then((response) => {
                const message =
                    `la chambre ${response.data.chambre.libelle} a été attribuée
                     du:${this.timeInterval.debut} midi au ${this.timeInterval.fin} midi, pour le
                     client ${this.client.nom} ${this.client.prenom}`
                this.getEvents()
                this.$awn.success(message)
            }).catch((err) => {
                console.log(err)
            })
        },
        saveEvent() {
            axios.post('/api/sejour/add', {
                nom: this.client.nom,
                prenom: this.client.prenom,
                piece: this.client.piece,
                batiment: this.batiment,
                chambre: this.chambre,
                numero_piece: this.client.numero,
                contact: this.client.contact,
                debut: this.timeInterval.debut,
                fin: this.timeInterval.fin,
                remise: this.remise,
                avance: this.avance,
                delais: this.delais,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content')
            }).then((response) => {
                    const message =
                        `la chambre ${response.data.chambre.libelle} a été attribuée
                                    du:${this.timeInterval.debut} midi au ${this.timeInterval.fin} midi, pour le
                                    client ${this.client.nom} ${this.client.prenom}`
                    this.getEvents()
                    this.$awn.success(message)
            }).catch((err) => {
                console.log(err)
            })
        },
        resetModal() {
            this.client.nom = null
            this.client.prenom = null
            this.client.piece = null
            this.client.numero = null
            this.client.contact = null
            this.avance = null
            this.remise = null
            this.batiment = null
            this.chambre = null
            this.message.details = null
            this.message.net = null
            this.timeInterval.debut = null
            this.timeInterval.fin = null
            this.idSejourAttribution = null
        },
        prixNet() {

            if (this.message.details) {
                let prix_normal = this.details.type_linked.cout_reservation * this.delais
                let prix_avec_remise = prix_normal - prix_normal * Number(this.remise)
                this.message.net = `le prix net total à payer: ${prix_avec_remise},
                                Avance: ${prix_normal*this.avance} , Reste à payer: ${prix_avec_remise-prix_normal*this.avance}`
            } else {
                this.message.net = 'Vous devez choisir le batiment et la chambre !!'
            }
        }
    }
}
</script>

<style lang="scss">
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
</style>
