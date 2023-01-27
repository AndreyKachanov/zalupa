<template>
<!--    <VueAwesomeSideBar-->
<!--        :miniMenu="miniMenu"-->
<!--        :collapsed="collapsed"-->
<!--        :menu="testMenu"-->
<!--    ></VueAwesomeSideBar>-->

<!--    <pre>-->
<!--        {{ allCategories }}-->
<!--    </pre>-->
<!--    <div class="search_bar">-->
<!--        <input type="text" v-model="search" placeholder="Search fruits..." />-->

<!--        <div class="item fruit" v-for="product in filteredProducts" :key="product.id">-->
<!--            <router-link-->
<!--                :key="product.route"-->
<!--                :to="`/category/${product.slug}`"> {{ product.title }}-->
<!--            </router-link>-->
<!--        </div>-->
<!--        <div class="item error" v-if="search&&!filteredProducts.length">-->
<!--            <p>No results found!</p>-->
<!--        </div>-->

<!--    </div>-->

    <div v-if="this.$route.name === 'cart'" class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="mt-2 mb-2">
                    <span>Количество: <strong>{{ cartCnt }}</strong>; Сумма: <strong>{{ cartTotal }}</strong> &#8381</span>
                </h5>
            </div>
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

        <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
            <div class="mobile-bottom-nav__item-content">
                <router-link :to="{ name: 'products' }">
                    <i class="fa-solid fa-chart-simple fa-2x" aria-hidden="true"></i>
                    Категории
                </router-link>
            </div>
        </div>

        <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
            <div class="mobile-bottom-nav__item-content">
                <router-link :to="{ name: 'search' }">
                    <i class="fa fa-search fa-2x" aria-hidden="true"></i>
                    Поиск
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
        ],
        // fruits: ["apple", "banana", "orange"],
        // input: '',
        testMenu: [
            {
                children: [
                    {
                        name: 'level 1.1',
                        href: '/a',
                        children: [
                            {
                                href: '/b',
                                name: 'level 1.1.1',
                            },
                        ]
                    },
                    {
                        name: 'level 1.2'
                    }
                ],
            }
        ],
        testData: [
            { key: 'test-data-1', value: 'test data 1' },
            { key: 'test-data-2', value: 'test data 2' },
            { key: 'test-data-3', value: 'test data 3' }
        ],
        collapsed: false,
        miniMenu: false,
        value: '',
        selected: '',
        products: [
            {id: 1, name: "Foo"},
            {id: 2, name: "Bar"},
            {id: 3, name: "Baz"},
            {id: 4, name: "Foobar"}
        ],
        search: ""
    }),
    computed: {
        ...mapGetters('cart', { cartCnt: 'length', cartTotal: 'total' }),
        ...mapGetters('categories', { allCategories: 'allCategories' }),
        filteredProducts() {
            return this.allCategories.filter(p => {
                // return true if the product should be visible

                // in this example we just check if the search string
                // is a substring of the product name (case insensitive)
                return p.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
            });
        }
    },
    methods: {

    },
    created() {
    }
}
</script>

<style lang="scss">

    .search_bar {
        input {
            display: block;
            width: 350px;
            margin: 20px auto;
            padding: 10px 45px;
            //background: white url("assets/search-icon.svg") no-repeat 15px center;
            background-size: 15px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px,
            rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .item {
            width: 350px;
            margin: 0 auto 10px auto;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px,
            rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        }

        .fruit {
            background-color: rgb(97, 62, 252);
            cursor: pointer;
        }

        .error {
            background-color: tomato;
        }
    }

    .mobile-bottom-nav {

        i.fa {
            color: red;
        }

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
                color: red;
                display: flex;
                flex-direction: column;
                &:hover {
                    text-decoration: none;
                }
            }
        }
    }
</style>
