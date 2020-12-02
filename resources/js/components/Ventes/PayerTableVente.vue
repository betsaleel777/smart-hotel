<template>
    <div>
        <button class="btn btn-warning float-right" @click="runModal">
            <i class="far fa-credit-card"></i> reçu + statistique
        </button>
        <b-modal id="payer" title="PAYEMENT TABLE" @ok="send">
            <form class="form-group">
                <label for="nombre">Nombre de Personne</label>
                <input
                    id="nombre"
                    v-model="nombre"
                    class="form-control"
                    type="text"
                />
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
    props: {
        code: String,
        table: Number,
    },
    data() {
        return { nombre: 0 };
    },
    methods: {
        runModal() {
            this.$bvModal.show("payer");
        },
        send() {
            if (isNaN(parseInt(this.nombre))) {
                this.$awn.alert(
                    "le nombre de personne à la table doit être une valeure numérique"
                );
            } else {
                axios
                    .post("/ajax/ventes/stats", {
                        restauration: this.code,
                        table: this.table,
                        nombre: this.nombre,
                    })
                    .then(() => {
                        location.href = "/home/vente/ticket/" + this.code;
                    })
                    .catch((err) => {
                        this.$awn.alert(err.response.data.message);
                        //err.response.data.message
                    });
            }
        },
    },
};
</script>

<style></style>
