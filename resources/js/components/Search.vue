<template>
    <div class="row justify-content-center">
        <div class="col-10 search_bar pl-0 pr-0">
            <input type="search" v-model="search" placeholder="Поиск товаров..." />
            <div class="search-items-wrap" v-if="search.length >= 2 && (filteredProducts.length || filteredCategories.length)">
                <div class="products">
                    <p class="mb-2" v-if="filteredCategories.length">Категории товаров</p>
                    <router-link
                        v-for="category in filteredCategories" :key="category.route"
                        :to="`/category/${category.slug}`"
                        v-slot="{ route, isExactActive, navigate }"
                        :custom="true"
                    >
                        <a :href="route.fullPath" @click="navigate" class="item fruit">
                            <img :src="getImg(category)" class="img-thumbnail" :alt="`${category.title}`">
                            <div class="ml-3">{{ category.title }}</div>
                        </a>
                    </router-link>
                    <p v-if="filteredProducts.length">Товары</p>
                    <router-link
                         v-for="product in filteredProducts" :key="product.route"
                        :to="`/product/${product.slug}`"
                        v-slot="{ route, isExactActive, navigate }"
                        :custom="true"
                    >
                        <a :href="route.fullPath" @click="navigate" class="item fruit">
                                <img :src="`${product.img}`" class="img-thumbnail" :alt="`${product.title}`">
                                <div class="ml-3">{{ product.title }}</div>
                        </a>
                    </router-link>
                </div>
            </div>
            <div v-if="search.length >= 2 && (!filteredProducts.length && !filteredCategories.length)" class="item error">
                Результатов не найдено!
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    export default {
        name: "Search",
        data: () => ({
            search: '',
            icon: '\uf002'
        }),
        computed: {
            ...mapGetters('products', { products: 'all' }),
            ...mapGetters('categories', { allCategories: 'allCategories' }),
            filteredProducts() {
                return this.products.filter(p => {
                    if (this.search.length >= 2) {
                        return p.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
                    }
                });
            },
            filteredCategories() {
                return this.allCategories.filter(p => {
                    if (this.search.length >= 2) {
                        return p.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
                    }
                });
            },
        },
        methods: {
            getImg(category) {
                return category.img === null ? '/assets/no-image.png' : category.img;
            }
        }
    }
</script>

<style lang="scss">
    .search_bar {
        .search-items-wrap {
            border: solid 1px #e8e8e8;
            box-shadow: 0 1px 5px rgb(0 0 0 / 10%);
            background-color: #fff;
            width: 100%;
            position: absolute;
            z-index: 9999;
            //width: 97%;
            //@include media-breakpoint-down(xs) {
            //    width: 92%;
            //}

            .products {
                border-top: 1px solid #dce1e6;
                border-bottom: 1px solid #dce1e6;
                p {
                    font-weight: bold;
                    margin: 20px 0 0 20px;
                }
            }
        }
        a {
            display: block;
            &:hover {
                text-decoration: none;
                background-color: rgb(247, 247, 247);
            }
        }
        input {
            display: block;
            width: 100%;
            //margin: 20px auto;
            //margin-bottom: 13px;
            padding: 8px 15px 8px 45px;
            background: white url("/assets/search-icon.png") no-repeat 15px center;
            background-size: 20px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            box-shadow: rgba(50, 50, 93, 0.4) 0px 2px 5px -1px,
            rgba(0, 0, 0, 0.5) 0px 1px 3px -1px;
        }
        .item {
            display: flex;
            align-items: center;
            //margin: 0 auto 2px auto;
            padding: 10px 20px 10px 15px;
            color: #000000;
            //border-radius: 5px;
            //box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px,
            //rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
            img {
                border-radius: 50%;
                width: 100px;
                height: 100px;
                flex: 0 0 auto;
                //max-width: 100px;
            }
        }

        .fruit {
            //background-color: rgb(97, 62, 252);
            cursor: pointer;
        }

        .error {
            width: 100%;
            position: absolute;
            z-index: 9999;
            background-color: tomato;
        }
    }
</style>
