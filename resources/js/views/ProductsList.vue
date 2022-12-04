<template>
    <div>
        <h1>Products</h1>
        {{ cartAll }}
        <br>
        {{ productsTemp }}
        <div class="row">
            <div class="col col-sm-4 mb-3 mt-3"
                v-for="product in products"
                 :key="product.id"
            >
                <div class="card">
                    <div class="card-body">
                        <h3>{{ product.title }}</h3>
                        <img class="img-fluid" :src="product.img" alt=""/>
                        <div>{{ product.price }}</div>
                        <router-link :to="`/product/${product.id}`">Read more</router-link>
<!--                        {{ inCart(product.id) }}-->
<!--                        {{ product.id }}-->
<!--                        <count-cart-items  :test="getCntFromCart(product.id)" @updated-cnt="updateCartItemCnt(product.id, $event)"></count-cart-items>-->
                        {{ test }}
<!--                        <count-cart-items  v-model="test" @updated-cnt="updateCartItemCnt(product.id, $event)"></count-cart-items>-->
                        <count-items :count-from-cart="getCountFromCart(product.id)"  @set-cnt="setNewCnt(product.id, $event)"></count-items>
                        <button v-if="inCart(product.id)" class="btn btn-danger" @click="removeFromCart(product.id)">
                            Remove
                        </button>
                        <button v-else class="btn btn-success" @click="addToCartNew(product.id)">
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
import CountItems from '../components/CountItems';

export default {
    name: "ProductsList",
    data: () => ({
        test: 1
    }),
    components: {
        CountItems
    },
    computed: {
        // ...mapGetters({ products: 'products/all' })
        // или 2 вариант записи
        ...mapGetters('products', { products: 'all' }),
        ...mapGetters('cart', { cartAll: 'all', inCart: 'has', productsTemp: 'productsTemp', getCountFromCart: 'getCountFromCart' }),
    },
    methods: {
        ...mapActions('cart', { addToCartNew: 'addNew', addToCart: 'add', removeFromCart: 'remove', setCnt: 'setCnt', setTempCnt: 'setTempCnt' }),
        setNewCnt(id, cnt) {
            // console.log(arguments)
            if (this.inCart(id)) {
                console.log('В корзине есть такой товар');
                console.log('id =' + id, 'cnt=' + cnt);
                if (cnt > 0) {
                    this.setCnt({id, cnt})
                }
            }
            else {
                console.log('В корзине нет такого товара');
                console.log('cnt = ' + cnt);
                if (cnt > 0) {
                    console.log(1);
                    this.setTempCnt({id, cnt})
                }
            }
            // записывать в localstorage
            // else {
            //     console.log('В корзине нет такого товара');
            //     // console.log('cnt = ' + cnt);
            //     if (cnt > 0) {
            //         // console.log(1);
            //         // localStorage.setItem("CART_TEMP", JSON.stringify({id, cnt}));
            //         let items = JSON.parse(localStorage.getItem("CART_TEMP") || "[]");
            //         // console.log(items)
            //         items.push({id, cnt});
            //         localStorage.setItem("CART_TEMP", JSON.stringify(items));
            //         // console.log(items)
            //         this.setTempCnt({ id, cnt })
            //     }
            // }
        }
    }
}
</script>

<style scoped>
    .row {
        padding-left: 15px;
    }
</style>
