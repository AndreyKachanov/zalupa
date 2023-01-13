<template>
    <div class="container">
        <div class="row">
            <div class="col-12 text-right">
                <h5 class="mt-2 mb-2">
                    <span>Кол-во: <strong>{{ cartCnt }}</strong>; Сумма: <strong>{{ cartTotal }}</strong> &#8381</span>
                </h5>
            </div>
<!--            <div class="col col-sm-3">-->
<!--                <div class="alert alert-default d-flex">-->
<!--                    <router-link-->
<!--                        v-if="this.cartCnt > 0"-->
<!--                        :to="{ name: 'cart' }"-->
<!--                        style="display: flex; margin-right: 15px; text-decoration: none;"-->
<!--                    >-->
<!--                        <i style="color:#ff0000" class="fa-solid fa-cart-plus fa-2x" aria-hidden="true"></i>-->
<!--                    </router-link>-->
<!--                    <div>-->

<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
    <nav class="mobile-bottom-nav">
        <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
            <div class="mobile-bottom-nav__item-content">
                <router-link :to="{ name: 'products' }">
                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                    Главная
                </router-link>
            </div>
        </div>

        <div class="mobile-bottom-nav__item cart-block">
            <div class="mobile-bottom-nav__item-content">
                <router-link :to="{ name: 'cart' }">
                    <i class="fa-solid fa-cart-plus fa-2x" aria-hidden="true">
                        <span v-if="this.cartCnt > 0" class="cnt">{{ cartCnt }}</span>
                    </i>
                    <span>Корзина</span>
                </router-link>
            </div>
        </div>

        <div class="mobile-bottom-nav__item">
            <div class="mobile-bottom-nav__item-content">
                <router-link :to="{ name: 'contacts' }">
                    <i class="fa fa-address-book fa-2x" aria-hidden="true"></i>
                    Контакты
                </router-link>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex';

// import { library } from '@fortawesome/fontawesome-svg-core'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// import { faUserSecret, faScroll } from '@fortawesome/free-solid-svg-icons'
// import { faFacebook, faTiktok, faStackOverflow, faSquareGit } from '@fortawesome/free-brands-svg-icons'
// library.add(faUserSecret, faScroll, faFacebook, faTiktok, faStackOverflow, faSquareGit)

export default {
    components: {
        // FontAwesomeIcon
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
    .mobile-bottom-nav {
        @include media-breakpoint-down(xs) {
            i {
                font-size: 1.7em;
            }
        }
        span.cnt {
            font-family: TTNormsRegular, sans-serif;
            font-size: 15px;
            font-weight: bold;
            position: absolute;
            border: 1px solid #ccc;
            padding: 1px 5px;
            border-radius: 50%;
            background: #000;
            color: #ffffff;
            top: -10px;
            text-align: center;
            min-height: 20px;
            @include media-breakpoint-down(xs) {
                top: -7px;
                font-size: 11px;
                min-height: 17px;
            }
            //min-width: 24px;
            //max-width: 24px;
        }

        //@include media-breakpoint-up(md) {
            //display: none;
        //}

        .cart-block {
            //.mobile-bottom-nav__item-content {
            //    display: block;
            //}
            a {
                i {
                    position: relative;
                }
                //border: 1px solid red;

            }

        }

        position:fixed;
        bottom:0;
        left:0;
        right:0;
        z-index:1000;

        //give nav it's own compsite layer
        will-change:transform;
        transform: translateZ(0);
        display:flex;
        height: 65px;
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

            a {
                display: flex;
                flex-direction: column;
                &:hover {
                    text-decoration: none;
                }
            }
        }
    }
</style>
