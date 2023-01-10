<template>
    <div>
        <h1>Контактная информация:</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Номер телефона</th>
                    <th>Instagram</th>
                    <th>Whatsapp</th>
                    <th>Адрес сайта</th>
                    <th>Viber</th>
                    <th>Tiktok</th>
                    <th>Youtube</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
export default {
    name: "Contacts",
    components: {
    },
    computed: {
        // ...mapGetters('cart', {
        //     products: 'productsDetailed',
        //     cartTotal: 'total',
        //     cartCnt: 'length',
        //     all: 'all'
        // }),
        // hasProductsInCart() {
        //     return this.cartCnt > 0;
        // }
    },
    methods: {
        // ...mapActions('cart', ['setCnt', 'remove', 'setInvoiceNumber']),
        // ...mapActions('cart', ['setCnt', 'remove']),
    }
}
</script>

<style scoped>

</style>
