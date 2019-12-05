<template>
  <div v-show="afficher" class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn  btn-sm" :class="type">{{'J:' + jours}}</button>
      <button type="button" class="btn  btn-sm" :class="type">{{'H:' + heures}}</button>
      <button type="button" class="btn  btn-sm" :class="type">{{'M:' + minutes}}</button>
      <button type="button" class="btn  btn-sm" :class="type">{{'S:' + secondes}}</button>
  </div>
</template>

<script>
import Moment from "moment"
export default {
    props: ['end', 'chambre'],
    data() {
      return {
         type: 'btn-success',
         afficher: false,
         timer: null,
         temps: null,
         jours: null,
         heures: null,
         minutes: null,
         secondes: null,
     }
    },
    created() {

    },
    beforeUpdate(){
      if(this.temps <= 0){
        const audio = new Audio('http://soundbible.com/mp3/analog-watch-alarm_daniel-simion.mp3')
        audio.play()
        clearInterval(this.timer)
        this.$awn.info('la chmabre '+this.chambre+' doit être libérée !!')
      }
    },
    mounted() {
        this.timer = setInterval(() => {
            let fin = new Date(this.end).getTime()
            let now = new Date()
            this.temps = fin - now.getTime()

            if( this.temps > 0 && this.temps <= 5*60*1000){
               this.type = 'btn-danger'
            }else if (this.temps > 5*60*1000 && this.temps <= 15*60*1000) {
               this.type = 'btn-warning'
            }

            if (this.temps >= 0) {
                this.afficher = true
                this.jours = ('0' + Math.floor(this.temps / (1000 * 60 * 60 * 24))).slice(-2)
                this.heures = ('0' + Math.floor((this.temps % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).slice(-2)
                this.minutes = ('0' + Math.floor((this.temps % (1000 * 60 * 60)) / (1000 * 60))).slice(-2)
                this.secondes = ('0' + Math.floor((this.temps % (1000 * 60)) / 1000)).slice(-2)
            } else {
                this.afficherTimer = false
            }
        }, 1000)
    },
    methods: {
    }
}
</script>

<style lang="css" scoped>
</style>
