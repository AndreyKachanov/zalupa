<template>
    <div class="container">
        <div class="row">
            <div class="col col-sm-9">
                <h1>Site</h1>
            </div>
            <div class="col col-sm-3">
                <div class="alert alert-default">
                    <div>Кол-во: {{ cartCnt }}</div>
                    <div>Сумма: {{ cartTotal }} &#8381</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-sm-2 menu">
                <ul class="list-group">
                    <router-link
                        v-for="item in menu"
                        :key="item.route"
                        :to="{ name: item.route }"
                        v-slot="{ route, isExactActive, navigate }"
                        :custom="true">
                        <li class="list-group-item" :class="isExactActive ? 'active' : ''">
                            <a :href="route.fullPath" @click="navigate">{{ item.title }}</a>
                        </li>
                    </router-link>
                </ul>
            </div>
            <div class="col col-sm-10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    components: {
    },
    data: () => ({
        menu: [
            { route: 'products', title: 'Продукты' },
            { route: 'cart', title: 'Корзина' },
            { route: 'checkout', title: 'Заказ' }
        ]
    }),
    computed: {
        ...mapGetters('cart', { cartCnt: 'length', cartTotal: 'total' }),
    },
    methods: {
    },
    created() {
    }
}
</script>

<style scoped>
</style>
