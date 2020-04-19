<template>
<div class="">
    <div class="form-group">
        <div class="form-row">
            <div class="col">
                <label for="">Famille</label>
                <b-form-select @change="getSousFamilles" v-model="famille" :options="familles"></b-form-select>
            </div>
            <div class="col">
                <label for="">Sous Famille</label>
                <b-form-select v-model="sous_famille" :options="sous_familles"></b-form-select>
            </div>
        </div>
    </div>
    <div class="form-group">
      <label for="">Type</label>
      <b-form-select v-model="type" :options="types"></b-form-select>
    </div>
</div>
</template>
<script>
import {
    BFormSelect,
    BFormRadio
} from 'bootstrap-vue'
export default {
    components: {
        BFormSelect,
        BFormRadio
    },
    data() {
        return {
            famille: '',
            familles: [],
            sous_famille: '',
            sous_familles: [],
            type: null,
            types:[{text:'tout',value:'all'},{text:'accéssoires',value:'acessoire'},{text:'consommables',value:'consommable'}]
        }
    },
    mounted() {
        this.getFamilles()
    },
    watch: {
        type(value) {
            this.$root.$emit('famille_set', value, this.famille,this.sous_famille)
        }
    },
    methods: {
        getFamilles() {
            axios.get('/parametre/famille/ajax/all').then(response => {
                const data = response.data.familles
                this.familles = data.map(famille => {
                    return {
                        text: famille.libelle,
                        value: famille.id
                    }
                })
            }).catch(err => {
                console.log(err)
            })
        },
        getSousFamilles() {
            axios.get('/parametre/sous_famille/ajax/' + this.famille).then(response => {
                const data = response.data.sous_familles
                this.sous_familles = data.map(sous_famille => {
                    return {
                        text: sous_famille.libelle,
                        value: sous_famille.id
                    }
                })
            }).catch(err => {
                console.log(err)
            })
        }
    }
}
</script>
