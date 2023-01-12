<template>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 mb-3 mt-3"
            v-for="product in products"
             :key="product.id"
        >
            <div class="card h-100">
                <img class="card-img-top img-fluid" :src="product.img" alt=""/>
                <div class="card-body">
                    <div class="card-title">{{ product.title }}</div>
                    <div>{{ product.price }} &#8381</div>
<!--                    <router-link :to="`/${product.slug}`">Read more</router-link>-->
                    <div style="margin-top: 15px; display: flex; justify-content: space-around;min-width:91px">
                        <count-items :count-from-cart="getCountFromCart(product.id)" @set-cnt="setNewCnt(product.id, $event)"></count-items>
                        <button v-if="inCart(product.id)" class="btn btn-danger" @click="removeFromCart(product.id)">
                            Убрать
                        </button>
                        <button v-else class="btn btn-success" @click="addToCartNew(product.id)">
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

<style scoped>
    /*.row {*/
    /*    padding-left: 15px;*/
    /*}*/
</style>
