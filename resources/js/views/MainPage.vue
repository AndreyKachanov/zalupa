<template>

    <div>
        <main-menu :categories="parentsCategories"></main-menu>
    </div>
</template>

<script>

import { mapGetters } from 'vuex';
import MainMenu from "../components/MainMenu.vue";

export default {
    name: "MainPage",
    data: () => ({
    }),
    components: {
        MainMenu
    },
    computed: {
        ...mapGetters('categories', {
            parentsCategories: 'parentsCategories'
        }),
    },
    methods: {
    }
}
</script>

<style scoped>
</style>
