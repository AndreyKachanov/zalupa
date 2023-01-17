<template>
    <div v-if="hasProductsInCart || flagOrderSent" class="row pb-4">
        <div v-if="flagOrderSent && !hasProductsInCart">
            <div class="col-10 offset-1 text-center mt-3 mb-2">
                <h2>Ваш заказ удачно отправлен. Ожидайте звонка менеджера.</h2>
            </div>
<!--            <router-link class="text-center mt-5"-->
<!--                :to="{ name: 'products' }"-->
<!--            >На главную</router-link>-->
        </div>
        <div v-else class="row">
            <div class="col-10 offset-1 text-center mt-3 mb-2">
                <h2>Заполните форму:</h2>
            </div>
            <div class="col-10 offset-1 pl-0 pr-0">
                <form @submit.prevent="sendForm">
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" :style="progressStyles"></div>
                    </div>
                    <app-field
                        v-for="(field, i) in info"
                        :value="field.value"
                        :label="field.label"
                        :valid="field.valid"
                        :activated="field.activated"
                        :name="field.name"
                        :key="i"
                        @input="onInput(i, $event)"
                    >
                    </app-field>
                    <div>
                        <h2 class="text-center mb-2">Ваш заказ:</h2>
                        <div class="mb-3 pl-2">
                            <span class="font-weight-bold">№ заказа: </span><span class="ml-1">{{ billNumber }}</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Кол-во</th>
                                <th>Цена</th>
                                <th>Всего</th>
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
                                <td>Всего</td>
                                <td>{{ cartTotal }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-around">
                        <router-link :to="{ name: 'cart' }" class="btn mr-5 btn-danger pl-3 pr-3">
                            Отменить
                        </router-link>
                        <button class="btn btn-success pl-3 pr-3" :disabled="!formReady">
                            Заказать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <app-e404 v-else title="Page not found"></app-e404>
</template>

<script>
import AppE404 from '../components/E404';
import {mapActions, mapGetters} from "vuex";
import AppField from "../components/AppField.vue";

export default {
    components: {
        AppField,
        AppE404
    },
    data: () => ({
        info: [
            {
                label: 'ФИО:',
                value: '',
                pattern: /^[а-яА-Я \-]{2,50}$/,
                name: 'name'
            },
            {
                label: 'Номер телефона:',
                value: '',
                // pattern: /^[0-9]{7,14}$/,
                pattern: /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/,
                name: 'phone'
            },
            {
                label: 'Город:',
                value: '',
                // pattern: /^[a-zA-Z ]{2,30}$/,
                // любой буквенный символ или дефис или пробел
                pattern: /^[а-яА-Я \-]{2,50}$/,
                name: 'city'
            },
            {
                label: 'Улица:',
                value: '',
                pattern: /^[а-яА-Я \-]{2,50}$/,
                name: 'street'
            },
            {
                label: 'Номер дома:',
                value: '',
                pattern: /^[0-9а-яА-Я \-]{1,50}$/,
                name: 'house_number'
            },
            {
                label: 'Транспортная компания:',
                value: '',
                pattern: /^[а-яА-Я \-]{2,50}$/,
                name: 'transport_company'
            }
        ],
        formDone: false,
        // showConfirm: false,

    }),
    computed: {
        ...mapGetters('cart', { products: 'productsDetailed', cartTotal: 'total', billNumber: 'billNumber', cartCnt: 'length', flagOrderSent: 'flagOrderSent'}),
        hasProductsInCart() {
            return this.cartCnt > 0;
        },
        fieldsDone() {
            return this.info.reduce((t, f) => t + (f.valid ? 1 : 0), 0);
        },
        formReady() {
            return this.fieldsDone === this.info.length;
        },
        progressStyles() {
            return {
                // кол-во процентов заполненных полей
                width: (this.fieldsDone / this.info.length * 100) + '%'
            }
        }
    },
    methods: {
        ...mapActions('cart', ['sendOrderToStore', 'sendOrderToStore']),
        sendOrder() {
            // console.log(1);

            // this.sendOrderToStore({
            //     name: this.name,
            //     contact: this.contact,
            //     city: this.city,
            //     street: this.street,
            //     house_number: this.house_number,
            //     transport_company: this.transport_company
            // });
        },
        onInput(i, e) {
            let field = this.info[i];
            field.value = e.target.value.trim();
            field.valid = field.pattern.test(field.value);
            field.activated = true;
        },
        sendForm(e) {
            if (this.formReady) {
                    // console.log(e);
                    // console.log(e.target.elements);
                this.sendOrderToStore({
                    name: e.target.elements.name.value,
                    phone: e.target.elements.phone.value,
                    city: e.target.elements.city.value,
                    street: e.target.elements.street.value,
                    house_number: e.target.elements.house_number.value,
                    transport_company: e.target.elements.transport_company.value,

                });

                // this.showConfirm = true;
                this.formDone = true;

                // this.sendOrderToStore({
                //     name: this.name,
                //     contact: this.contact,
                //     city: this.city,
                //     street: this.street,
                //     house_number: this.house_number,
                //     transport_company: this.transport_company
                // });
            } else {
                console.log('Форма не готова');
            }
        },
    },
    created() {
        return this.info.forEach(field => {
            field.activated = field.value !== '';
            field.valid = field.pattern.test(field.value);
        });
    }
}
</script>


<style scoped>
</style>
