<template>
    <div>
<!--        <h1>Корзина</h1>-->
        <hr>
        <table v-if="hasProductsInCart" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.title }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.cnt }}</td>
                    <td>{{ product.price * product.cnt }}</td>
                    <td>
                        <button
                            class="btn btn-warning mr-2"
                            @click="setCnt({ id: product.id, cnt: product.cnt - 1 })"
                        >-</button>
                        <button
                            class="btn btn-success mr-2"
                            @click="setCnt({ id: product.id, cnt: product.cnt + 1 })"
                        >+</button>
                        <button
                            class="btn btn-danger"
                            @click="remove(product.id)"
                        >x</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <p v-else>Корзина пустая</p>

        <router-link  v-if="cartCnt" :to="{ name: 'checkout' }" class="btn btn-success">
            <span>Итого - {{ cartTotal }} ₽</span>
        </router-link>
    </div>
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

<style scoped>

</style>
