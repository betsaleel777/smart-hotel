<template>
<div v-show="afficherTimer" class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn  btn-sm" :class="type">{{'J:' + jours}}</button>
    <button type="button" class="btn  btn-sm" :class="type">{{'H:' + heures}}</button>
    <button type="button" class="btn  btn-sm" :class="type">{{'M:' + minutes}}</button>
    <button type="button" class="btn  btn-sm" :class="type">{{'S:' + secondes}}</button>
</div>
</template>

<script>
export default {
    props: ['end'],
    data() {
        return {
            type: 'btn-success',
            afficherTimer: false,
            timer: null,
            temps: null,
            jours: null,
            heures: null,
            minutes: null,
            secondes: null,
        }
    },
    mounted() {
        this.timer = setInterval(() => {
            let fin = new Date(this.end).getTime()
            let now = new Date()
            this.temps = fin - now.getTime()
            //doit gerer le style d'affichage du timer rouge reste 5 min jaune reste 15 min et vert ailleur 
            if (this.temps >= 0) {
                this.afficherTimer = true
                this.jours = ('0' + Math.floor(this.temps / (1000 * 60 * 60 * 24))).slice(-2)
                this.heures = ('0' + Math.floor((this.temps % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2)
                this.minutes = ('0' + Math.floor((this.temps % (1000 * 60 * 60)) / (1000 * 60))).slice(-2)
                this.secondes = ('0' + Math.floor((this.temps % (1000 * 60)) / 1000)).slice(-2)
            } else {
                this.afficherTimer = false
            }
        }, 1000)
    },
    methods: {},
    beforeDestroy() {
        clearInterval(this.timer)
    }
}
</script>

<style lang="css" scoped>
</style>
