<template>
    <div v-if="hasProductsInCart || flagOrderSent" class="container test123">
        <div v-if="flagOrderSent && !hasProductsInCart">
            <h1>Ваш заказ удачно отправлен. Ожидайте звонка менеджера.</h1>
            <router-link
                :to="{ name: 'products' }"
            >На главную</router-link>
        </div>
        <div v-else class="d-flex justify-content-center row">
            <div class="col-md-12">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="" method="post">
                                <h2>Введите контакты для связи с Вами:</h2>
                                <input type="text" v-model="name" placeholder="Введите Ваше имя" required class="input-group mb-2">
                                <input type="text" v-model="contact" placeholder="Введите Ваш телефон или email" required class="input-group">
                            </form>
                            <h1 class="text-uppercase">Заказ</h1>
                            <div class="billed"><span class="font-weight-bold text-uppercase">№ заказа:</span><span class="ml-1">{{ billNumber }}</span></div>
                            <div class="billed"><span class="font-weight-bold text-uppercase">Дата:</span><span class="ml-1">{{currentDate()}}</span></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Unit</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.title }}</td>
                                    <td>{{ product.cnt }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>{{ product.price * product.cnt }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ cartTotal }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-right mb-3">
                            <button class="btn btn-danger btn-sm mr-5" type="button">Отменить</button>
                            <button @click="sendOrder" class="btn btn-success btn-sm mr-5" type="button">Заказать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <app-e404 v-else title="Page not found"></app-e404>
</template>

<script>
import AppE404 from '../components/E404';
import {mapActions, mapGetters} from "vuex";

export default {
    components: {
        AppE404
    },
    data: () => ({
        name: '',
        contact: ''
    }),
    computed: {
        ...mapGetters('cart', { products: 'productsDetailed', cartTotal: 'total', billNumber: 'billNumber', cartCnt: 'length', flagOrderSent: 'flagOrderSent'}),
        hasProductsInCart() {
            return this.cartCnt > 0;
        }
    },
    methods: {
        ...mapActions('cart', ['sendOrderToStore', 'sendOrderToStore']),
        currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth()+1}.${current.getFullYear()}`;
        },
        sendOrder() {
            // let name = this.name;
            // let contact = this.contact;
            this.sendOrderToStore({ name: this.name, contact: this.contact });
        }

    },
    created() {
        // console.log(this.$route);
        // console.log(this.billNumber);
        // console.log(this.currentDate());
    },

}
</script>


<style scoped>
    .checkout-table {
        display: flex;
    }
</style>
