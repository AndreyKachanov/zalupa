<template>

    <main-menu
        :categories="subCategories(idCurrentCategory)"
        :parent-title="parentTitle"
    >
    </main-menu>

    <products-list :products="itemsWithPagination"></products-list>
    <div v-if="startItems < countAll" class="row">
        <div class="col-12 text-center">
            <button
                class="btn btn-success mt-2 mb-3"
                @click="startItems += countLoadItems"
            >Показать еще
            </button>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import CategoriesMenu from "../components/CategoriesMenu.vue";
    import ProductsList from "../components/ProductsList.vue";
    import MainMenu from "../components/MainMenu.vue"

    export default {
        name: "CategoryPage",
        data: () => ({
            startItems: 16,
            countLoadItems: 16,
            parentTitle1: ''
        }),
        components: {
            MainMenu,
            CategoriesMenu,
            ProductsList
        },
        computed: {
            ...mapGetters('products', {
                getItemsByIdsCategories: 'getItemsByIdsCategories',
                lengthItemsByIdsCategories: 'lengthItemsByIdsCategories'
            }),
            ...mapGetters('categories', {
                allCategories: 'allCategories',
                subCategories: 'subCategories',
            }),
            // айдишники текущей категории +  дочерних категорий
            getCategoriesIds() {
                // ид категории, в которую зашли
                let idCat = this.idCurrentCategory;
                let arrIdsCat = [idCat];
                // ids дочерних категорий
                if (this.hasSubCategories) {
                    let idsChilds = this.allCategories.map((element) => {
                        if (element.parent_id === this.idCurrentCategory) {
                            return element.id;
                        }
                    }).filter(element => element >= 0);
                    // объединяем айдишники в массив
                    arrIdsCat.push(...idsChilds);
                }
                return arrIdsCat;
            },
            // извлекаем товары с учетом постраничной загрузки
            itemsWithPagination() {
                return this.getItemsByIdsCategories(this.getCategoriesIds, this.startItems);
            },
            // общее кол-во товаров в категории + подкатегории
            countAll() {
                return this.lengthItemsByIdsCategories(this.getCategoriesIds);
            },

            // itemsOnlyCategory() {
            //     // console.log(111);
            //     // ид категории, в которую зашли
            //     let idCat = this.idCurrentCategory;
            //     // console.log('idCat = ', idCat);
            //     let arr = [idCat];
            //     // console.log(this.itemsFromCategories(arr));
            //     return this.itemsFromCategories(arr);
            // },
            idCurrentCategory() {
                // try {
                //     setTimeout(() => console.log('setTimeout test'), 1000);
                //     console.log('assCategories', this.allCategories);
                //     if (this.allCategories.length > 0) {
                        return this.allCategories[this.allCategories.findIndex(pr => pr.slug === this.slug)].id;
                    // }

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
            parentTitle() {
                // if (this.allCategories.length > 0) {
                    return this.allCategories[this.allCategories.findIndex(pr => pr.slug === this.slug)].title;
                // }
            }
        },
        methods: {
        }
    }
</script>

<style scoped>
</style>
