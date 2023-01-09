<template>
    <div class="container">
        <div class="row">
            <div class="col col-sm-9">
<!--                <h1>Site</h1>-->
            </div>
            <div class="col col-sm-3">
                <div class="alert alert-default d-flex">
                    <router-link
                        v-if="this.cartCnt > 0"
                        :to="{ name: 'cart' }"
                        style="display: flex; margin-right: 15px; text-decoration: none;"
                    >
                        <i style="color:#ff0000" class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                    </router-link>
                    <div>
                        <div>Кол-во: {{ cartCnt }}</div>
                        <div>Сумма: {{ cartTotal }} &#8381</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
<!--            <div class="col col-sm-2 menu">-->
<!--                <ul class="list-group">-->
<!--                    <router-link-->
<!--                        v-for="item in menu"-->
<!--                        :key="item.route"-->
<!--                        :to="{ name: item.route }"-->
<!--                        v-slot="{ route, isExactActive, navigate }"-->
<!--                        :custom="true">-->
<!--                        <li class="list-group-item" :class="isExactActive ? 'active' : ''">-->
<!--                            <a :href="route.fullPath" @click="navigate">{{ item.title }}</a>-->
<!--                        </li>-->
<!--                    </router-link>-->
<!--                </ul>-->
<!--            </div>-->
            <div class="col col-sm-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
    <div class="container">
        <nav class="mobile-bottom-nav">
            <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
                <div class="mobile-bottom-nav__item-content">
                    <i class="material-icons">home</i>
                    one
                </div>
            </div>
            <div class="mobile-bottom-nav__item">
                <div class="mobile-bottom-nav__item-content">
                    <i class="material-icons">mail</i>
                    two
                </div>
            </div>
            <div class="mobile-bottom-nav__item">
                <div class="mobile-bottom-nav__item-content">
                    <i class="material-icons">person</i>
                    three
                </div>
            </div>

            <div class="mobile-bottom-nav__item">
                <div class="mobile-bottom-nav__item-content">
                    <i class="material-icons">phone</i>
                    four
                </div>
            </div>
        </nav>
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

<style lang="scss">
$fa-font-path : "~@fortawesome/fontawesome-free-webfonts/webfonts";
@import "~@fortawesome/fontawesome-free-webfonts/scss/fontawesome.scss";
@import "~@fortawesome/fontawesome-free-webfonts/scss/fa-solid.scss";
@import "~@fortawesome/fontawesome-free-webfonts/scss/fa-regular.scss";
@import "~@fortawesome/fontawesome-free-webfonts/scss/fa-brands.scss";

.mobile-bottom-nav{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    z-index:1000;

    //give nav it's own compsite layer
    will-change:transform;
    transform: translateZ(0);

    display:flex;

    height:50px;

    box-shadow: 0 -2px 5px -2px #333;
    background-color:#fff;

    &__item{
        flex-grow:1;
        text-align:center;
        font-size:12px;

        display:flex;
        flex-direction:column;
        justify-content:center;
    }
    &__item--active{
        //dev
        color:red;
    }
    &__item-content{
        display:flex;
        flex-direction:column;
    }
}
</style>
