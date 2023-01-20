<template>
<!--    <pre>-->
<!--        {{ all }}-->
<!--        {{ subCategories(idCurrentCategory) }}-->
<!--    </pre>-->
    <top-menu-childs :categories="subCategories(idCurrentCategory)" :parentTitle="getParentTitle"></top-menu-childs>
<!--    <top-menu-childs :categories="subCategories(idCurrentCategory)"></top-menu-childs>-->
    <products-list-new :products="itemsOnlyCategory"></products-list-new>
</template>

<script>

import { mapGetters, mapActions } from 'vuex';
import ProductsListNew from "../components/ProductsListNew";
// import TopMenu from "../components/TopMenu";
import TopMenuChilds from "../components/TopMenuChilds.vue";
import categories from "../store/categories";

export default {
    name: "ProductsListMainParentCategory",
    data: () => ({
    }),
    components: {
        ProductsListNew,
        // TopMenu,
        TopMenuChilds
    },
    mounted() {
        // console.log('mounted');

        // let parentSlug = this.$route.params.slug;
        // this.getProductsFromParentCategoryAndSubcategories(this.$route.params.slug);
    },
    created() {
        // console.log('created');
        // let slug = this.slug;
        // if (!this.cacheUrls.includes(slug)) {
        //     this.getProductsFromParentCategoryAndSubcategories(slug);
        //     this.setCacheUrls(slug);
        // }
    },
    // beforeRouteEnter(to, from, next) {


        // this.getProductsFromParentCategoryAndSubcategories(to.params.slug);
        // next(vm => {
            // access to component public instance via `vm`
            // console.log('beforeRouteEnter');
        // })
        // next(function(vm) {
        //     this.getProductsFromParentCategoryAndSubcategories(this.$route.params.slug)
        // })
    // },
    // beforeRouteUpdate(to, from) {
    //     console.log(to.params.name);
    // },
    // beforeEach() {
    //     console.log('beforeEach')
    // },

    // async beforeRouteUpdate(to, from) {
    //     console.log('beforeRouteUpdate');
    // },
    computed: {
        // ...mapGetters({ products: 'products/all' })
        // или 2 вариант записи
        ...mapGetters('products', {
            itemsFromCategories: 'itemsFromCategories',
            all: 'all'
        }),
        ...mapGetters('categories', {
            allCategories: 'allCategories',
            subCategories: 'subCategories',
            // cacheUrls: 'cacheUrls'
        }),
        items() {
            // ид категории, в которую зашли
            let idCat = this.idCurrentCategory;
            let arr = [idCat];
            // ids дочерних категорий
            if (this.hasSubCategories) {
                let idsChild = this.allCategories.map((element) => {
                    if (element.parent_id === this.idCurrentCategory) {
                        return element.id;
                    }
                }).filter(element => element >= 0);
                arr.push(...idsChild);
            }
            return this.itemsFromCategories(arr);
        },
        itemsOnlyCategory() {
            // console.log(111);
            // ид категории, в которую зашли
            let idCat = this.idCurrentCategory;
            // console.log('idCat = ', idCat);
            let arr = [idCat];
            // console.log(this.itemsFromCategories(arr));
            return this.itemsFromCategories(arr);
        },
        idCurrentCategory() {
            // try {
            //     setTimeout(() => console.log('setTimeout test'), 1000);
            //     console.log('assCategories', this.allCategories);
                if (this.allCategories.length > 0) {
                    return this.allCategories[this.allCategories.findIndex(pr => pr.slug === this.slug)].id;
                }

            // } catch(err) {
            //     console.log(err);
            // }
        },
        slug() {
            return this.$route.params.slug;
        },
        hasSubCategories() {
            // хотя бы 1 элемент с таким parent_id нашелся
            return this.allCategories.some(cat => cat.parent_id === this.idCurrentCategory);
        },
        getParentTitle() {
            if (this.allCategories.length > 0) {
                return this.allCategories[this.allCategories.findIndex(pr => pr.slug === this.slug)].title;
            }
        }
    },
    methods: {
        ...mapActions('products', {
            // showMoreAct: 'showMoreAct',
            // getProductsFromParentCategoryAndSubcategories: 'getProductsFromParentCategoryAndSubcategories'
        }),
        ...mapActions('categories', {
            // setCacheUrls: 'setCacheUrls'
        }),
        currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth()+1}.${current.getFullYear()}.${current.getMinutes()}.${current.getSeconds()}.${current.getMilliseconds()}`;
        },
    }
}
</script>

<style scoped>
</style>
