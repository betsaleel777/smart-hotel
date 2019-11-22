<template>
<div class="modal fade" id="modal-small-attribution">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Temps de passage</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="heures">Nombre d'Heures</label>
                        <input id="heures" class="form-control" type="text" v-model="heure">
                    </div>
                    <div class="form-group">
                        <label for="passage">Passage</label>
                        <input v-model="kind" id="passage" type="radio" class="form-group" name="kind" value="passage">
                        <label for="repos">Repos</label>
                        <input v-model="kind" id="repos" type="radio" class="form-group" name="kind" value="repos">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        }
    },
    methods: {
        attribuer: function(event) {
            event.preventDefault()
            let current = this
            //const csrf = document.querySelector('head meta[name="csrf-token"]').getAttribute('content')
            axios.post('/api/attribution/passage', {
                    batiment: current.batiment,
                    chambre: current.chambre,
                    heure: current.heure,
                    kind: current.kind
                })
                .then(function(response) {
                    location.href = '/home/attributions';
                })
                .catch((error) => {
                    console.log(error);
                })
        }

    }
}
</script>
