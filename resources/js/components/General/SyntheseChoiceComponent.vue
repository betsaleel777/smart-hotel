<template>
<div class="container">
    <b-card border-variant="warning" :header="'items sélectionnés'">
        <b-card-text>
            <ul class="list-group list-group-flush">
                <li class="list-group-item" v-for="line in list" :key="line.id">
                    <div class="row">
                        <div class="col-md-7">{{`${line.libelle} `}}</div>
                        <div class="col-md-4"><strong>{{`(${line.quantite})`}}</strong></div>
                        <div class="col-md-1"><button class="btn btn-danger btn-sm"><i @click="removeIt(line.id)" class="fas fa-trash-alt"></i></button></div>
                    </div>
                </li>
            </ul>
        </b-card-text>
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4"><button @click="envoyer" class="btn btn-primary"><i class="fas fa-send"></i> Envoyer</button></div>
        </div>
    </b-card>
    <center><button @click="decompact" class="btn btn-warning">mode</button></center>
    <b-table v-if="compact" striped hover :items="board_compact" :fields="fields_compact" caption-top>
    </b-table>
    <b-table v-if="!compact" striped hover :items="board_uncompact" :fields="fields" caption-top>
        <template v-slot:cell(option)="data">
            <button class="btn btn-primary" @click="edit(data.value.id, data.value.quantite, data.value.libelle)"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" @click="trash(data.value.id)"><i class="fas fa-trash"></i></button>
        </template>
    </b-table>
</div>
</template>

<script>
import {
    BCard,
    BCardText,
    BTable
} from 'bootstrap-vue'
export default {
    components: {
        BCard,
        BCardText,
        BTable
    },
    props: ['usingby', 'attribution', 'from', 'synchrone'],
    data() {
        return {
            total: '0',
            list: [],
            board_compact: [],
            board_uncompact: [],
            compact: true,
            fields: [{
                key: 'libelle',
                label: 'Libellé',
                sortable: true
            }, {
                key: 'quantite',
                label: 'Quantité',
                sortable: true
            }, {
                key: 'option',
                label: 'Option',
                sortable: true
            }],
            fields_compact: [{
                key: 'libelle',
                label: 'Libellé',
                sortable: true
            }, {
                key: 'quantite',
                label: 'Quantité',
                sortable: true
            }]
        }
    },
    mounted() {
        this.$root.$on('add', (produit, quantite) => {
            if (produit && quantite) {
                let elt = {}
                let found = false
                if (this.list.length > 0) {
                    let newTab = this.list.map(line => {
                        if (line.id === produit.id) {
                            line.quantite = Number(line.quantite) + Number(quantite)
                            found = true
                        }
                        return line
                    })
                    this.list = newTab
                }
                if (!found) {
                    elt.id = produit.id
                    elt.libelle = produit.libelle
                    elt.quantite = Number(quantite)
                    this.list.push(elt)
                }
            } else {
                this.$awn.warning('Veuillez choisir un produit et renseigner la quantité !!')
            }
        })
        if (this.synchrone) {
            this.getAccessoriesSaved()
        }
    },
    methods: {
        removeIt(id) {
            let newTab = this.list.filter(line => line.id !== id)
            this.list = newTab
        },
        getAccessoriesSaved() {
            axios.get('/ajax/destockage/' + this.from + '/saved/' + this.attribution).then(response => {
                let produits = response.data.produits
                this.board_uncompact = produits.decompact.map(produit => {
                    return {
                        option: {
                            id: produit.id,
                            quantite: produit.quantite,
                            libelle: produit.produit_linked.libelle
                        },
                        quantite: produit.quantite,
                        libelle: produit.produit_linked.libelle
                    }
                })
                this.board_compact = produits.compact.map(produit => {
                    return {
                        quantite: produit.quantite,
                        libelle: produit.libelle
                    }
                })
            }).catch(err => {
                console.log(err)
            });
        },
        decompact() {
            this.compact = !this.compact
        },
        trash(id) {
            console.log('delete avec ' + id);
        },
        edit(id, quantite, libelle) {
            console.log('les infos sont: ' + id, quantite, libelle);
        },
        update() {
            axios.post('/ajax/destockage/update/' + this.from + '/saved', {}).then(response => {
                if(response.data.message){
                  this.$awn.success(response.data.message)
                }
            }).catch(err => {
                console.log(err)
            })
        },
        envoyer(event) {
            if (this.list.length > 0) {
                let url = null
                let attributionPassage = null
                let attributionSejour = null
                // let urlRedirect = null

                if (this.usingby === 'destockage') {
                    url = '/ajax/destockage/save'
                    // urlRedirect = '/home/sejour'
                } else if (this.usingby === 'appro') {
                    url = '/ajax/approvisionnement/save'
                    // urlRedirect = '/home/approvisionnement'
                }

                if (this.from === 'sejour') {
                    attributionSejour = this.attribution
                } else if (this.from === 'passage') {
                    attributionPassage = this.attribution
                }

                axios.post(url, {
                    items: this.list,
                    passage: attributionPassage,
                    sejour: attributionSejour
                }).then(response => {
                    if(response.data.warning){
                      this.$awn.warning(response.data.warning) ;
                    }else{
                      location.reload()
                    }
                }).catch(err => {
                    console.log(err);
                })
            } else {
                this.$awn.warning('Aucun produit sélectionné')
            }
        }
    }
}
</script>
