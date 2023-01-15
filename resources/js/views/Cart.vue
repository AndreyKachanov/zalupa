<template>
<!--    <div>-->
<!--        <h1>Корзина</h1>-->
        <hr>
<!--        <pre>{{ products }}</pre>-->
        <div v-if="hasProductsInCart" class="container">
            <div class="row">
                <div v-for="product in products" :key="product.id" class="main-row col-12">
<!--                    <div class="container">-->
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
                                                    @click="setCnt({ id: product.id, cnt: product.cnt - 1 })"
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
<!--                    </div>-->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <router-link  v-if="cartCnt" :to="{ name: 'checkout' }" class="btn btn-success">
                        <span>Итого - {{ cartTotal }} ₽</span>
                    </router-link>
                </div>
            </div>
        </div>
<!--        <table v-if="hasProductsInCart" class="table table-bordered table-hover">-->
<!--            <thead>-->
<!--                <tr>-->
<!--                    <th>Название</th>-->
<!--                    <th>Цена</th>-->
<!--                    <th>Количество</th>-->
<!--                    <th>Сумма</th>-->
<!--                    <th>Действия</th>-->
<!--                </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--                <tr v-for="product in products" :key="product.id">-->
<!--                    <td>{{ product.title }}</td>-->
<!--                    <td>{{ product.price }}</td>-->
<!--                    <td>{{ product.cnt }}</td>-->
<!--                    <td>{{ product.price * product.cnt }}</td>-->
<!--                    <td>-->
<!--                        <button-->
<!--                            class="btn btn-warning mr-2"-->
<!--                            @click="setCnt({ id: product.id, cnt: product.cnt - 1 })"-->
<!--                        >-</button>-->
<!--                        <button-->
<!--                            class="btn btn-success mr-2"-->
<!--                            @click="setCnt({ id: product.id, cnt: product.cnt + 1 })"-->
<!--                        >+</button>-->
<!--                        <button-->
<!--                            class="btn btn-danger"-->
<!--                            @click="remove(product.id)"-->
<!--                        >x</button>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="5">-->
<!--                        <router-link  v-if="cartCnt" :to="{ name: 'checkout' }" class="btn btn-success">-->
<!--                            <span>Итого - {{ cartTotal }} ₽</span>-->
<!--                        </router-link>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </tbody>-->
<!--        </table>-->
        <p v-else>Корзина пустая</p>


<!--    </div>-->
<!--    <app-e404 v-else title="Page not found"></app-e404>-->
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
            all: 'all'
        }),
        hasProductsInCart() {
            return this.cartCnt > 0;
        }
    },
    methods: {
        // ...mapActions('cart', ['setCnt', 'remove', 'setInvoiceNumber']),
        ...mapActions('cart', ['setCnt', 'remove']),
    }
}
</script>

<style lang="scss">
    .main-row {
        border-bottom: 1px solid #eeeeee;
        padding-top: 15px;
        padding-bottom: 15px;

        .cart-items {
            @include media-breakpoint-down(xs) {
                span.input-group-prepend, span.input-group-append, input[type='text'] {
                    //border: 1px solid red;
                    button {
                        padding: 0.25rem 0.35rem
                    }
                }
                input[type='text'] {
                    padding-left: 0px;
                    padding-right: 0px;
                    //padding: 0.3rem 0.6rem
                }
            }
        }
    }
</style>
