<template>
    <div>
        <top-menu :categories="parentsCategories"></top-menu>

<!--        {{ cartAll }}-->

<!--        <h1>Products</h1>-->
<!--        <products-list-new :products="products"></products-list-new>-->
<!--        {{ products }}-->
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
// import ProductsListNew from "../components/ProductsListNew";
import TopMenu from "../components/TopMenu";

export default {
    name: "ProductsListMain",
    data: () => ({
    }),
    components: {
        // ProductsListNew,
        TopMenu
    },
    created() {
    },
    computed: {
        // ...mapGetters({ products: 'products/all' })
        // или 2 вариант записи
        ...mapGetters('products', {
            // products: 'all'
        }),
        ...mapGetters('categories', {
            // allCategories: 'allCategories',
            parentsCategories: 'parentsCategories'
        }),
    },
    methods: {
        ...mapActions('products', {
            // showMoreAct: 'showMoreAct',
            // getProductsFromParentCategoryAndSubcategories: 'getProductsFromParentCategoryAndSubcategories'
        }),

    }
}
</script>

<style scoped>
    .row {
        padding-left: 15px;
    }
</style>
