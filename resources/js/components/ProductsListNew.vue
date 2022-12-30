<template>
    <div class="row">
<!--        {{ showMoreArr }}-->
<!--        {{ cacheUrls }}-->
        <div class="col col-sm-4 mb-3 mt-3"
            v-for="product in products"
             :key="product.id"
        >
            <div class="card">
                <div class="card-body">
                    <h3>{{ product.title }}</h3>
                    <img class="img-fluid" :src="product.img" alt=""/>
                    <div>{{ product.price }}</div>
                    <router-link :to="`/${product.slug}`">Read more</router-link>
                    <count-items :count-from-cart="getCountFromCart(product.id)" @set-cnt="setNewCnt(product.id, $event)"></count-items>
                    <button v-if="inCart(product.id)" class="btn btn-danger" @click="removeFromCart(product.id)">
                        Remove
                    </button>
                    <button v-else class="btn btn-success" @click="addToCartNew(product.id)">
                        Add to cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <br>
    <pre>
        {{ hasNewItemsForButtonPagination }}
    </pre>
    <button
        v-if="hasNewItemsForButtonPagination"
        @click="showMore(this.slug)"
    >Показать еще
    </button>
    <p v-else>hasNewItemsForPagination Новый товаров для пагинации нет</p>
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
            metaInfro: 'metaInfo',
            showMoreArr: 'showMoreArr'
        }),
        slug() {
            return this.$route.params.slug;
        },
        hasNewItemsForButtonPagination() {
            console.log('>>>1', this.hasNewItemsForPagination(this.slug));
            return this.hasNewItemsForPagination(this.slug);
        }
    },
    methods: {
        ...mapActions('cart', { addToCartNew: 'addNew', addToCart: 'add', removeFromCart: 'remove', setCnt: 'setCnt', setTempCnt: 'setTempCnt' }),
        ...mapActions('products', {
            showMore: 'showMore'
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
        // showMore() {
        //     console.log(this.$route);
        // }
    }
}
</script>

<style scoped>
    .row {
        padding-left: 15px;
    }
</style>
