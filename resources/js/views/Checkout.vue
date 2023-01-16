<template>
    <div v-if="hasProductsInCart || flagOrderSent" class="row">

        <div class="col-12 text-center" v-if="flagOrderSent && !hasProductsInCart">
            <h1>Ваш заказ удачно отправлен. Ожидайте звонка менеджера.</h1>
            <router-link
                :to="{ name: 'products' }"
            >На главную</router-link>
        </div>

        <div v-else class="col-12 pb-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Заполните форму:</h2>
                </div>
                <div class="col-12 pl-0 pr-0">
                    <div class="card">
                        <form v-if="!formDone" @submit.prevent="sendForm" class="col-12 pl-0 pr-0">
                            <div class="progress">
                                <div class="progress-bar bg-success" :style="progressStyles"></div>
                            </div>
                            <!--                                    <div>-->
                            <app-field
                                v-for="(field, i) in info"
                                :value="field.value"
                                :name="field.name"
                                :valid="field.valid"
                                :activated="field.activated"
                                :test="field.for"
                                successclasses="fa-bath text-primary"
                                :key="i"
                                @input="onInput(i, $event)"
                            >
                            </app-field>
                            <!--                                    </div>-->

                        </form>
                        <div v-else>
                            <h2>All done</h2>
                        </div>
                        {{ showConfirm }}
                    </div>
                </div>
                <div class="col-12">
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
                        <router-link :to="{ name: 'cart' }" class="btn btn-sm mr-5 btn-danger">
                            Отменить
                        </router-link>
                        <button class="btn btn-success btn-sm" :disabled="!formReady">
                            Заказать
                        </button>
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
import AppField from "../components/AppField.vue";

export default {
    components: {
        AppField,
        AppE404
    },
    data: () => ({
        // name: 'Grishka',
        // contact: '+79496593257',
        // city: 'Шахтарськ',
        // street: 'ул. Назаре',
        // house_number: '11а',
        // transport_company: 'Нова Пошта',
        info: [
            {
                name: 'Имя:',
                value: '',
                pattern: /^[a-zA-Z ]{2,30}$/,
                for: 'name'
            },
            {
                name: 'Номер телефона:',
                value: '',
                pattern: /^[0-9]{7,14}$/,
                for: 'phone'
            },
            {
                name: 'Город:',
                value: '',
                pattern: /^[a-zA-Z ]{2,30}$/,
                for: 'city'
            },
            {
                name: 'Улица:',
                value: '',
                pattern: /^[a-zA-Z ]{2,30}$/,
                for: 'street'
            },
            {
                name: 'Номер дома:',
                value: '',
                pattern: /^[a-zA-Z ]{2,30}$/,
                for: 'house_number'
            },
            {
                name: 'Транспортная компания:',
                value: '',
                pattern: /^[a-zA-Z ]{2,30}$/,
                for: 'transport_company'
            }
        ],
        formDone: false,
        showConfirm: false,

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
        currentDate() {
            const current = new Date();
            return `${current.getDate()}.${current.getMonth()+1}.${current.getFullYear()}`;
        },
        sendOrder() {
            // let name = this.name;
            // let contact = this.contact;
            this.sendOrderToStore({
                name: this.name,
                contact: this.contact,
                city: this.city,
                street: this.street,
                house_number: this.house_number,
                transport_company: this.transport_company
            });
        },
        onInput(i, e) {
            let field = this.info[i];
            field.value = e.target.value.trim();
            field.valid = field.pattern.test(field.value);
            field.activated = true;
        },
        sendForm() {
            if (this.formReady) {
                this.showConfirm = true;
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
