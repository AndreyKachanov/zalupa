<template>
        <hr>
        <div v-if="hasProductsInCart" class="container mb-4">
            <div class="row">
                <div v-for="product in products" :key="product.id" class="main-row col-12">
                    <div class="row ml-0 mr-0">
                        <div class="col-3 col-sm-2 pl-0 pr-0">
                            <img class="img-fluid img-thumbnail" :src="`${product.img}`" :alt="`${product.title}`">
                        </div>
                        <div class="col-9 col-sm-10 pl-3 pr-0 pt-3">
                            <div class="row ml-0 mr-0">
                                <div class="col-12 pl-0 pr-0 mb-3">
                                    {{ product.title }}
                                </div>
                                <div class="col-5 pl-0 pr-0">
                                    <div class="row ml-0 mr-0" style="text-align: right">
                                        <div class="col-12 pl-0 pr-0">
                                            {{ product.cnt }} x {{ product.price }} руб
                                        </div>
                                        <div class="col-12 pl-0 pr-0">
                                            <strong>
                                                {{ product.price * product.cnt }} руб
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5 cart-items pl-3 pr-0">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button
                                                @click="setNewCnt({ id: product.id, cnt: product.cnt - 1 })"
                                                type="button"
                                                class="btn btn-outline-secondary btn-number"
                                            >
                                                <span class="fa fa-minus"></span>
                                            </button>
                                        </span>
                                        <input type="text" class="pt-0 pb-0 form-control input-number" disabled="disabled" :value="`${product.cnt}`" style="text-align: center; height: auto">
                                        <span class="input-group-append">
                                             <button
                                                 @click="setCnt({ id: product.id, cnt: product.cnt + 1 })"
                                                 type="button"
                                                 class="btn btn-outline-secondary btn-number"
                                             >
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button
                                        class="btn btn-danger"
                                        @click="remove(product.id)"
                                    ><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center mb-0" style="font-size: 17px; color: red;">Минимальный заказ 5 000 руб</p>
                </div>
                <div class="col-12 text-center mt-3">
                    <router-link  v-if="cartCnt" :to="{ name: 'checkout' }" class="btn btn-success">
                        <span>Оформить - {{ cartTotal }} ₽</span>
                    </router-link>
                </div>
            </div>
        </div>
        <p class="text-center" v-else>Корзина пустая</p>
</template>

<script>
import AppE404 from '../components/E404';
import {mapGetters, mapActions} from "vuex";
export default {
    name: "Cart",
    components: {
        AppE404
    },
    computed: {
        ...mapGetters('cart', {
            products: 'productsDetailed',
            cartTotal: 'total',
            cartCnt: 'length',
            all: 'all',
            inCart: 'has'
        }),
        hasProductsInCart() {
            return this.cartCnt > 0;
        }
    },
    methods: {
        ...mapActions('cart', ['setCnt', 'remove']),
        setNewCnt({id, cnt}) {
            // console.log('id=', id);
            if (this.inCart(id)) {
                // console.log('В корзине есть такой товар');
                // console.log('id =' + id, 'cnt=' + cnt);
                if (cnt > 0) {
                    this.setCnt({id, cnt})
                } else {
                    // console.log('cnt < 0, ничего не делаем');
                }
            }
            else {
                // console.log('В корзине нет такого товара');
            }
        },
    }
}
</script>

<style lang="scss">
    .main-row {
        border-bottom: 1px solid #eeeeee;
        padding-top: 15px;
        padding-bottom: 15px;
        &:first-child {
            padding-top: 0;
        }
        &:last-child {
            //border-bottom: none;
        }

        .cart-items {
            @include media-breakpoint-down(xs) {
                span.input-group-prepend, span.input-group-append, input[type='text'] {
                    //border: 1px solid red;
                    button {
                        padding: 0.25rem 0.35rem
                    }
                }
                input[type='text'] {
                    padding-left: 0;
                    padding-right: 0;
                    //padding: 0.3rem 0.6rem
                }
            }
        }
    }
</style>
