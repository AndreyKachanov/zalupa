<template>
    <div class="container">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="text-uppercase">Заказ</h1>
<!--                            <div class="billed"><span class="font-weight-bold text-uppercase">#</span><span class="ml-1">{{ invoiceNumber }}</span></div>-->
                            <div class="billed"><span class="font-weight-bold text-uppercase">#</span><span class="ml-1">{{ billNumber }}</span></div>
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
                            <button class="btn btn-success btn-sm mr-5" type="button">Заказать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    // data: () => ({
    //     billNumber: localStorage.getItem('CART_BILL_NUMBER'),
    // }),
    computed: {
        ...mapGetters('cart', { products: 'productsDetailed', cartTotal: 'total', billNumber: 'billNumber' })
    },
    methods: {
        currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth()+1}.${current.getFullYear()}.${current.getMinutes()}.${current.getSeconds()}.${current.getMilliseconds()}`;
        }
    },
    // created() {
    //     console.log(this.billNumber);
    //     console.log(this.currentDate());
    // },

}
</script>


<style scoped>
    .checkout-table {
        display: flex;
    }
</style>
