<template>
    <div>
        <button class="btn btn-success float-right" @click="runModal">
            <i class="far fa-credit-card"></i> Faire Payer
        </button>
        <b-modal id="payer" title="PAYEMENT TABLE" @ok="send">
            <form class="form-group">
                <label for="heures">Nombre de Personne</label>
                <input v-model="nombre" class="form-control" type="text" />
            </form>
        </b-modal>
    </div>
</template>

<script>
import axios from "axios";
import { BModal } from "bootstrap-vue";
export default {
    components: {
        BModal,
    },
    props: ["facture"],
    data() {
        return { nombre: 0 };
    },
    methods: {
        runModal() {
            this.$bvModal.show("payer");
            console.log("modal is running, facture:" + this.facture);
        },
        send() {
            axios
                .post("/ajax/solder", {
                    encaissement: this.facture,
                    nombre: this.nombre,
                })
                .then(() => {
                    location.href = "/home/facture";
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>

<style></style>
