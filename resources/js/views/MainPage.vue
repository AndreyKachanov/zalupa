<template>
    <main-menu
        :categories="parentsCategories"
        :parent-title="parentTitle"
    >
    </main-menu>

    <h2  v-if="getNewItems.length > 0" class="text-center mt-3">Новинки</h2>
    <items-list
        v-if="getNewItems.length > 0"
        :items="getNewItems"
    ></items-list>

    <h2  v-if="getHitItems.length > 0" class="text-center mt-1">Хиты</h2>
    <items-list
        v-if="getHitItems.length > 0"
        :items="getHitItems"
    ></items-list>
</template>

<script>
    import { mapGetters } from 'vuex';
    import MainMenu from "../components/MainMenu.vue";
    import ProductsList from "../components/ProductsList.vue";
    import ItemsList from "../components/ItemsList.vue";

    export default {
        name: "MainPage",
        data: () => ({
            startItemsNew: 10,
            startItemsHit: 10,
            countLoadItems: 10,
            parentTitle: ''
        }),
        components: {
            MainMenu,
            ProductsList,
            ItemsList
        },
        computed: {
            ...mapGetters('categories', {
                parentsCategories: 'parentsCategories'
            }),
            ...mapGetters('products', {
                newItems: 'newItems',
                hitItems: 'hitItems',
                getHitItems: 'getHitItems',
                lengthNewItems: 'lengthNewItems',
                lengthHitItems: 'lengthHitItems'
            }),
            getParentsCategories() {
                return this.parentsCategories.sort((a, b) => a.sorting > b.sorting ? 1 : -1);
            },
            getNewItems() {
                return this.newItems;
            },
            getHitItems() {
                return this.hitItems;
            }
        },
        methods: {
        }
    }
</script>

<style scoped>
</style>
