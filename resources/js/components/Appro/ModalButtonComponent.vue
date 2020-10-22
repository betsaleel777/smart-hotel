<template>
    <div>
        <b-button @click="runModal(id)" variant="primary"
            ><i class="fas fa-edit"></i
        ></b-button>
        <b-modal @ok="send" :id="id" :title="produit">
            <p class="my-4">
                <label for="quantite">Quantité:</label>
                <input
                    id="quantite"
                    v-model="quantite"
                    type="text"
                    class="form-control"
                />
            </p>
        </b-modal>
    </div>
</template>
<script>
import { BButton, VBModal } from "bootstrap-vue";
export default {
    components: {
        BButton,
        VBModal,
    },
    props: ["id", "produit", "valeur"],
    data() {
        return {
            quantite: null,
        };
    },
    mounted() {
        this.quantite = this.valeur;
    },
    methods: {
        runModal(id) {
            this.$bvModal.show(id);
        },
        send() {
            if (Number(this.quantite) === 0) {
                this.$awn.warning("Aucune quantité renseignée !!");
            } else {
                axios
                    .post("/ajax/approvisionnement/edit", {
                        quantite: Number(this.quantite),
                        id: Number(this.id),
                    })
                    .then((response) => {
                        location.reload();
                    })
                    .catch((err) => {
                        // console.log(err)
                    });
            }
        },
    },
};
</script>

<style></style>
