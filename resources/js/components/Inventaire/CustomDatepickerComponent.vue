<template>
<div class="form-group">
    <div v-if="interval" class="row">
        <div class="col-md-5">
            <label for="start">Debut</label>
            <b-form-datepicker @context="onSelect" :disabled="desactiverFirst" placeholder="Choix de la date de debut" id="start" v-model="debut" locale="fr" :date-disabled-fn="dateDisabled"></b-form-datepicker>
        </div>
        <div class="col-md-5">
            <label for="fin">Fin</label>
            <b-form-datepicker @context="onSelectSecond" :min="minDate" :max="maxDate" :disabled="desactiverSecond" placeholder="Choix de la date de fin" id="fin" v-model="fin" locale="fr" :date-disabled-fn="dateDisabled"></b-form-datepicker>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <label for="date">Date</label>
            <b-form-datepicker @context="onSelectUnique" :disabled="desactiverThree" placeholder="Choix de la date unique" id="date" v-model="oneDate" locale="fr" :date-disabled-fn="dateDisabled"></b-form-datepicker>
        </div>
        <div class="col-md-2">
            <label class="invisible">invisible</label>
            <button @click="clear" type="button" class="reset btn btn-outline-primary">reset</button>
        </div>
    </div>
    <center>
        <div class="col-md-6">
            <button style="width:100%" @click="send" type="button" class="btn btn-outline-success">Envoyer</button>
        </div>
    </center>
</div>
</template>

<script>
import {
    BFormDatepicker
} from 'bootstrap-vue'
// import {Moment} from 'moment'
export default {
    components: {
        BFormDatepicker
    },
    props: ['interval'],
    data() {
        return {
            oneDate: null,
            debut: null,
            fin: null,
            desactiverFirst: false,
            desactiverSecond: true,
            desactiverThree: false,
            minDate: null,
            maxDate: null,
            famille: null,
            type: null
        }
    },
    mounted() {
        this.$root.$on('famille_set', (famille, type) => {
            this.famille = famille
            this.type = type
        })
    },
    methods: {
        dateDisabled(ymd, date) {
            const someDate = date.getTime()
            const now = new Date()
            return now < someDate
        },
        onSelect(context) {
            if (context.selectedDate) {
                const now = new Date()
                if (context.selectedDate.getDate() === now.getDate()) {
                    this.$awn.warning('Attention la date d\'aujourd\'hui ne peut être choisie comme date de debut')
                } else {
                    this.desactiverSecond = null
                    this.desactiverThree = 'disabled'
                    this.minDate = context.selectedDate
                    this.maxDate = now
                }
            }
        },
        onSelectSecond(context) {
            if (context.selectedDate) {
                if (context.selectedDate.getDate() === this.minDate.getDate()) {
                    this.clear()
                    this.$awn.warning('Attention la date d\'aujourd\'hui ne peut être choisie comme date de debut')
                }
            }
        },
        onSelectUnique(context) {
            if (context.selectedDate) {
                this.desactiverFirst = true
                this.desactiverSecond = true
                this.minDate = null
                this.minDate = null
                this.debut = null
                this.fin = null
            }
        },
        clear() {
            this.desactiverSecond = true
            this.desactiverFirst = false
            this.desactiverThree = false
        },
        send() {
            console.log(this.debut, this.fin, this.oneDate, this.famille, this.type)
        }
    }
}
</script>
<style>
.invisible {
    visibility: hidden
}

.reset {
    width: 100%
}
</style>
