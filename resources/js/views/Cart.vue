<template>
<!--    <div v-if="hasProductsInCart">-->
    <div>
        <h1>Cart</h1>
        <hr>
        <table v-if="hasProductsInCart" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Cnt</th>
                    <th>Total</th>
                    <th>Actions</th>
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
                            class="btn btn-warning"
                            @click="setCnt({ id: product.id, cnt: product.cnt - 1 })"
                        >-</button>
                        <button
                            class="btn btn-success"
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
        <p v-else>Cart is empty</p>

        <router-link  v-if="cartCnt" :to="{ name: 'checkout' }" class="btn btn-success">
<!--            <span @click="setInvoiceNumber">Итого - {{  cartTotal }} ₽</span>-->
            <span>Итого - {{ cartTotal }} ₽</span>
        </router-link>
<!--        {{ products }}-->
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
        ...mapGetters('cart', { products: 'productsDetailed', cartTotal: 'total', cartCnt: 'length' }),
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
