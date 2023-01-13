<template>
    <div class="row">
        <div class="col-6 col-md-4 col-lg-3 mb-3 mt-3 pl-sm-1 pr-sm-1 my_cart"
            v-for="product in products"
             :key="product.id"
        >
            <div class="card h-100">
                <img class="card-img-top img-fluid" :src="product.img" alt=""/>
                <div class="card-body">
                    <h3 class="card-title text-center">{{ product.title }}</h3>
                    <p v-if="product.note" class="text-muted" style="color: red">
                        <span style="color: red">Важно:</span> {{ product.note }}
                    </p>
                    <div class="budgets" v-if="product.is_new || product.is_hit || product.is_bestseller">
                        <span v-if="product.is_new" class="badge badge-pill badge-primary">Новый</span>
                        <span  v-if="product.is_hit" class="badge badge-pill badge-warning">Хит</span>
                        <span  v-if="product.is_bestseller" class="badge badge-pill badge-success">Бестселлер</span>
                    </div>
                    <p class="d-flex justify-content-between mb-2">
                        <span>Артикул:</span>
                        <span >{{ product.article_number }}</span>
                    </p>
                    <h3 class="text-center mb-0">{{ product.price }} &#8381</h3>
<!--                    <router-link :to="`/${product.slug}`">Read more</router-link>-->
                </div>
                <div class="card-footer d-flex justify-content-around">
                    <count-items class="mb-2 mb-sm-0" :count-from-cart="getCountFromCart(product.id)" @set-cnt="setNewCnt(product.id, $event)"></count-items>
                    <div class="cart-buttons">
                        <button v-if="inCart(product.id)" class="btn btn-danger" @click="removeFromCart(product.id)">
                            Убрать
                        </button>
                        <button v-else class="btn btn-success" @click="addToCartNew(product.id)">
<!--                            <i class="fa-solid fa-cart-plus" aria-hidden="true"></i>-->
                            В корзину
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <button
                class="btn btn-success mt-2 mb-3"
                v-if="hasNewItemsForButtonPagination"
                @click="getProductsFromCategory(this.slug)"
            >Показать еще
            </button>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import CountItems from '../components/CountItems';

export default {
    name: "ProductsListNew",
    props: ['products'],
    data: () => ({
    }),
    components: {
        CountItems
    },
    computed: {
        // ...mapGetters({ products: 'products/all' })
        // или 2 вариант записи

        // ...mapGetters('products', { products: 'all' }),
        ...mapGetters('categories', { cacheUrls: 'cacheUrls' }),
        ...mapGetters('cart', { cartAll: 'all', inCart: 'has', productsTemp: 'productsTemp', getCountFromCart: 'getCountFromCart' }),
        ...mapGetters('products', {
            hasNewItemsForPagination: 'hasNewItemsForPagination',
        }),
        slug() {
            return this.$route.params.slug;
        },
        hasNewItemsForButtonPagination() {
            // console.log('>>>1', this.hasNewItemsForPagination(this.slug));
            return this.hasNewItemsForPagination(this.slug);
        }
    },
    methods: {
        ...mapActions('cart', {
            addToCartNew: 'addNew',
            addToCart: 'add',
            removeFromCart: 'remove',
            setCnt: 'setCnt',
            setTempCnt: 'setTempCnt'
        }),
        ...mapActions('products', {
            getProductsFromCategory: 'getProductsFromCategory',
            showMore: 'showMore',
        }),
        setNewCnt(id, cnt) {
            // console.log(arguments)
            if (this.inCart(id)) {
                // console.log('В корзине есть такой товар');
                // console.log('id =' + id, 'cnt=' + cnt);
                if (cnt > 0) {
                    this.setCnt({id, cnt})
                }
            }
            else {
                // console.log('В корзине нет такого товара');
                // console.log('cnt = ' + cnt);
                if (cnt > 0) {
                    // console.log(1);
                    this.setTempCnt({id, cnt})
                }
            }
        },
    }
}
</script>

<style lang="scss">
    .my_cart {
        .card-footer {
            max-height: 60px;
            .cart-buttons {
                width: 100%
                button {
                    width: 100%;
                    //width: calc(90% - 80px);
                }

                //border: 1px solid red;
            }
        }
        .text-muted {
            margin-bottom: 8px;
        }
        .budgets {
            .badge {
                padding: 0.7em 1.3em;
                //@include media-breakpoint-up(xs) {
                //    padding-right: 1rem;
                //    padding-left: 1rem;
                //}
                //padding-top: 1em;
                //padding-bottom: 1em;
            }
            //border: 1px solid red;
            display: flex;
            justify-content: space-around;
            margin-bottom: 10px;
        }

        @include media-breakpoint-down(xs) {

            &:nth-child(odd) {
                padding-right: 0.25rem !important;
            }

            &:nth-child(even) {
                padding-left: 0.25rem !important;
            }


            .card-body {
                padding: 0.6rem;
                .card-title {
                    font-size: 1.1rem;
                    //word-break: break-all;
                }
                .text-muted {
                    margin-bottom: 8px;
                    font-size: 0.9rem;
                    word-break: break-all;
                }
                .budgets {
                    //justify-content: space-between;
                    //flex-direction: column;
                    //justify-content: space-around;
                    span {
                        font-size: 9px;
                        margin-left: 0.2em;
                        margin-right: 0.2em;
                        padding-right: 0.5rem;
                        padding-left: 0.5rem;
                    }
                }
            }

        }
    }

</style>
