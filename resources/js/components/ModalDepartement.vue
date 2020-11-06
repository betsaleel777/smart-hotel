<template>
    <div>
        <button
            type="button"
            class="btn btn-outline-primary pretty"
            @click="runModal"
        >
            créer departement
        </button>
        <b-modal
            id="departement"
            title="ajouter un departement"
            @show="reset"
            @cancel="reset"
            @ok="send"
        >
            <form class="form-group">
                <input
                    v-model="nom"
                    class="form-control"
                    :class="invalid"
                    type="text"
                />
                <div class="text-danger">{{ message }}</div>
            </form>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: {
        reload: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            nom: "",
            message: "",
            invalid: "",
        };
    },
    methods: {
        runModal() {
            this.$bvModal.show("departement");
        },
        send(event) {
            event.preventDefault();
            axios
                .post("/ajax/departement/store", { nom: this.nom })
                .then((result) => {
                    this.$root.$emit("new_add"); //listen by SelectDepartement
                    this.nom = "";
                    this.$nextTick(() => {
                        if (this.reload) {
                            location.reload();
                        } else {
                            this.$awn.success(result.data.message);
                            this.$bvModal.hide("departement");
                        }
                    });
                })
                .catch((err) => {
                    this.invalid = "is-invalid";
                    this.message = err.response.data.errors.nom[0];
                });
        },
        reset() {
            this.message = "";
            this.invalid = "";
            this.nom = "";
        },
    },
};
</script>

<style scoped>
.pretty {
    width: 100%;
}
</style>
