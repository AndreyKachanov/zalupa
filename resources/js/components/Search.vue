<template>
    <div class="row justify-content-center">
        <div class="col-10 search_bar">
            <input type="search" v-model="search" placeholder="Поиск товаров..." />
            <div class="search-items-wrap">
                <router-link
                    @click="search=''"
                    class="item fruit" v-for="product in filteredProducts" :key="product.id"
                    :to="`/product/${product.slug}`"> {{ product.title }}
                </router-link>
                <div class="item error" v-if="search.length >= 2 && !filteredProducts.length">
                    Результатов не найдено!
                </div>
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
            filteredProducts() {
                return this.products.filter(p => {
                    if (this.search.length >= 2) {
                        return p.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
                    }
                });
            }
        }
    }
</script>

<style lang="scss">
    .search_bar {
        .search-items-wrap {
            position: absolute;
            z-index: 9999;
            width: 97%;
            @include media-breakpoint-down(xs) {
                width: 92%;
            }
        }
        a {
            display: block;
            &:hover {
                text-decoration: none;
                background-color: rgb(144, 124, 232);
            }
        }
        input {
            display: block;
            width: 100%;
            //margin: 20px auto;
            margin-bottom: 13px;
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
            margin: 0 auto 2px auto;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px,
            rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        }

        .fruit {
            background-color: rgb(97, 62, 252);
            cursor: pointer;
        }

        .error {
            background-color: tomato;
        }
    }
</style>
