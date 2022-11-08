<template>
    <div>
        <h1>Products</h1>
<!--        {{ cartAll }}-->
        <div class="row">
            <div class="col col-sm-4 mb-3 mt-3"
                v-for="product in products"
                 :key="product.id"
            >
                <div class="card">
                    <div class="card-body">
                        <h3>{{ product.title }}</h3>
                        <img class="img-fluid" :src="product.img" alt=""/>
                        <div>{{ product.price1 }}</div>
                        <div>{{ product.price2 }}</div>
                        <div>{{ product.price3 }}</div>
                        <router-link :to="`/product/${product.id}`">Read more</router-link>
                        <button v-if="inCart(product.id)" class="btn btn-danger" @click="removeFromCart(product.id)">
                            Remove
                        </button>
                        <button v-else class="btn btn-success" @click="addToCart(product.id)">
                            Add to cart
                        </button>
                    </div>
                </div>

            </div>
<!--            {{ map }}-->
        </div>

<!--        {{ products }}-->
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name: "ProductsList",
    computed: {
        // ...mapGetters({ products: 'products/all' })
        // или 2 вариант записи
        ...mapGetters('products', { products: 'all' }),
        ...mapGetters('cart', { cartAll: 'all', inCart: 'has' }),
    },
    methods: {
        ...mapActions('cart', { addToCart: 'add', removeFromCart: 'remove' })
    }
}
</script>

<style scoped>
    .row {
        padding-left: 15px;
    }
</style>
