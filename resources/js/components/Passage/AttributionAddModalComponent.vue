<template>
<div class="modal fade" id="modal-small-attribution">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Temps de passage</h4>
                <button @click="resetModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="heures">Nombre d'Heures</label>
                        <input name="heure" id="heures" class="form-control" type="text" v-model="heure">
                        <span style="color:red" v-if="messages.heure.exist">{{messages.heure.value}}</span>
                    </div>
                    <div class="form-group">
                        <label for="passage">Passage</label>
                        <input v-model="kind" id="passage" type="radio" class="form-group" name="kind" value="passage">
                        <label for="repos">Repos</label>
                        <input v-model="kind" id="repos" type="radio" class="form-group" name="kind" value="repos">
                        <br><span style="color:red" v-if="messages.kind.exist">{{messages.kind.value}}</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button @click="resetModal" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button @click="attribuer" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</template>

<script>
export default {
    props: ['chambre', 'batiment'],
    data() {
        return {
            kind: null,
            heure: null,
            messages: {
                heure: {
                    exist: false,
                    value: ''
                },
                kind: {
                    exist: false,
                    value: ''
                }
            }
        }
    },
    methods: {
        attribuer: function(event) {
            event.preventDefault()
            let current = this
            //const csrf = document.querySelector('head meta[name="csrf-token"]').getAttribute('content')
            axios.post('/ajax/attribution/passage', {
                    batiment: current.batiment,
                    chambre: current.chambre,
                    heure: current.heure,
                    kind: current.kind
                })
                .then(response => location.href = '/home/attributions/passage').catch((error) => {
                    const errors = error.response.data.errors

                    if (errors.heure) {
                        this.messages.heure.value = errors.heure[0]
                        this.messages.heure.exist = true
                    }
                    if (errors.kind) {
                        this.messages.kind.value = errors.kind[0]
                        this.messages.kind.exist = true
                    }
                })
        },
        resetModal() {
            this.messages.heure.value = ''
            this.messages.heure.exist = false
            this.messages.kind.value = ''
            this.messages.kind.exist = false
            this.heure = null
            this.kind = null
        }

    }
}
</script>
