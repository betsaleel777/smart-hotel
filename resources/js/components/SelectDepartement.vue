<template>
    <select class="form-control" name="departement">
        <option v-if="selected" :key="2000" selected :value="selected">
            {{ selectedName }}
        </option>
        <option v-else selected></option>
        <option
            v-for="departement in departements"
            :key="departement.id"
            :value="departement.id"
        >
            {{ departement.nom }}
        </option>
    </select>
</template>

<script>
export default {
    props: {
        list: Array,
        selected: Number,
    },
    data() {
        return {
            departements: [],
            selectedName: String,
        };
    },
    mounted() {
        this.departements = this.list;
        this.list.forEach((departement) => {
            if (departement.id === this.selected) {
                this.selectedName = departement.nom;
            }
        });
        this.$root.$on("new_add", () => {
            axios
                .get("/ajax/departements")
                .then((result) => {
                    this.departements = result.data.departements;
                })
                .catch((err) => {});
        });
    },
};
</script>

<style scoped></style>
