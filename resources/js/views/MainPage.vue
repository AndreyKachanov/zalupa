<template>

    <div>
        <main-menu :categories="parentsCategories"></main-menu>
    </div>
    <pre>
        {{ countHitItems }}
    </pre>
<!--    <div class="container">-->
            <h2  v-if="newItems" class="text-center">Новинки</h2>
            <products-list v-if="newItems" :products="newItems"></products-list>
            <div v-if="startItemsNew < countNewItems" class="row">
                <div class="col-12 text-center">
                    <button
                        class="btn btn-success mt-2 mb-3"
                        @click="startItemsNew += countLoadItems"
                    >Показать еще
                    </button>
                </div>
            </div>
            <h2  v-if="hitItems" class="text-center">Хиты</h2>
            <products-list v-if="hitItems" :products="hitItems"></products-list>
            <div v-if="startItemsHit < countHitItems" class="row">
                <div class="col-12 text-center">
                    <button
                        class="btn btn-success mt-2 mb-3"
                        @click="startItemsHit += countLoadItems"
                    >Показать еще
                    </button>
                </div>
            </div>
<!--    </div>-->

</template>

<script>
    import { mapGetters } from 'vuex';
    import MainMenu from "../components/MainMenu.vue";
    import ProductsList from "../components/ProductsList.vue";

    export default {
        name: "MainPage",
        data: () => ({
            startItemsNew: 10,
            startItemsHit: 10,
            countLoadItems: 10,
        }),
        components: {
            MainMenu,
            ProductsList
        },
        computed: {
            ...mapGetters('categories', {
                parentsCategories: 'parentsCategories'
            }),
            ...mapGetters('products', {
                getNewItems: 'getNewItems',
                getHitItems: 'getHitItems',
                lengthNewItems: 'lengthNewItems',
                lengthHitItems: 'lengthHitItems'
            }),
            newItems() {
                return this.getNewItems(this.startItemsNew);
            },
            hitItems() {
                return this.getHitItems(this.startItemsHit);
            },
            countNewItems() {
                return this.lengthNewItems;
            },
            countHitItems() {
                return this.lengthHitItems;
            },
        },
        methods: {
        }
    }
</script>

<style scoped>
</style>
