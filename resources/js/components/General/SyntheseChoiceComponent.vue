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
</div>
</template>

<script>
import {
    BCard,
    BCardText
} from 'bootstrap-vue'
export default {
    components: {
        BCard,
        BCardText
    },
    props: ['usingby', 'attribution', 'from', 'synchrone'],
    data() {
        return {
            total: '0',
            list: []
        }
    },
    mounted() {
        this.$root.$on('add', (produit, quantite) => {
            if (produit && quantite) {
                let elt = {}
                let found = false
                if (this.list.length > 0) {
                    let newTab = this.list.map((line) => {
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
            axios.get('/api/destockage/' + this.from + '/saved/' + this.attribution).then((response) => {
                this.list = response.data.produits.map((produit) => {
                    return {
                        id: produit.produit_linked.id,
                        quantite: produit.quantite,
                        libelle: produit.produit_linked.libelle
                    }
                })
            }).catch((err) => {
                console.log(err);
            });
        },
        envoyer() {
            if (this.list.length > 0) {
                let url = null
                let attributionPassage = null
                let attributionSejour = null
                let urlRedirect = null

                if (this.usingby === 'destockage') {
                    url = '/api/destockage/save'
                    urlRedirect = '/home/sejour'
                } else if (this.usingby === 'appro') {
                    url = '/api/approvisionnement/save'
                    urlRedirect = '/home/approvisionnement'
                }

                if (this.from === 'sejour') {
                    attributionSejour = this.attribution
                } else if (this.from === 'passage') {
                    attributionPassage = this.attribution
                }

                axios.post(url, {
                    accessoires: this.list,
                    passage: attributionPassage,
                    sejour: attributionSejour
                }).then((response) => {
                    location.href = urlRedirect
                }).catch((err) => {
                    console.log(err);
                })
            } else {
                this.$awn.warning('Aucun produit sélectionné')
            }
        }
    }
}
</script>
