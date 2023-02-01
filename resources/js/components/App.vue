<template>
    <VueAwesomeSideBar
        v-if="categoriesForSidebar.length > 0"
        :width="width"
        :miniMenu="false"
        :menuType="menuType"
        :collapsed="collapsed"
        :menu="categoriesForSidebar"
        :closeOnClickOutSide="ismobile"
        :overLayerOnOpen="ismobile"
        :childrenOpenAnimation="true"
        :keepChildrenOpen="true"
        :BottomMiniMenuBtn="false"
        @item-click="itemClickHandel"
        vueRouterEnabel
    ></VueAwesomeSideBar>

<!--    <pre>-->
<!--        {{ categoriesForSidebar }}-->
<!--    </pre>-->

    <div v-if="this.$route.name === 'cart'" class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="mt-2 mb-2">
                    <span>Количество: <strong>{{ cartCnt }}</strong>; Сумма: <strong>{{ cartTotal }}</strong> &#8381</span>
                </h5>
            </div>
        </div>
    </div>

    <div
        v-if="this.$route.name === 'products' || this.$route.name === 'category' || this.$route.name === 'product-item'"
        class="container"
    >
        <search-component/>
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

        <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active" @click="collapsed = !collapsed">
            <div class="mobile-bottom-nav__item-content">
                <a href="#">
                    <i class="fa-solid fa-chart-simple fa-2x" aria-hidden="true"></i>
                    Категории
                </a>
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
import SearchComponent from "./Search.vue";

// import { library } from '@fortawesome/fontawesome-svg-core'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// import { faUserSecret, faScroll } from '@fortawesome/free-solid-svg-icons'
// import { faFacebook, faTiktok, faStackOverflow, faSquareGit } from '@fortawesome/free-brands-svg-icons'
// library.add(faUserSecret, faScroll, faFacebook, faTiktok, faStackOverflow, faSquareGit)

export default {
    components: {
        SearchComponent
    },
    data: () => ({
        menu: [
            { route: 'products', title: 'Продукты' },
            { route: 'cart', title: 'Корзина' },
            { route: 'checkout', title: 'Заказ' }
        ],
        // testMenu: [
        //     {
        //         name: 'Dashboard',
        //         href: '/category/3-2-shapki-s-ushami',
        //         children: [
        //             {
        //                 href: '/products',
        //                 name: 'level 2.1',
        //             },
        //         ]
        //     },
        //     {
        //         name: 'Dashboard',
        //         href: '/c',
        //         children: [
        //             {
        //                 href: '/c',
        //                 name: 'level 2.1',
        //             },
        //         ]
        //     },
        //
        // ],
        // testMenuBefore: [
        //     {
        //         "id": 4,
        //         "href": "/category/2-myagkie-igrushki",
        //         "name": "2. Мягкие игрушки",
        //         "parent_id": null
        //     },
        //     {
        //         "id": 5,
        //         "href": "/category/3-svetyashchiesya-igrushki",
        //         "name": "3. Светящиеся игрушки",
        //         "parent_id": null
        //     },
        //     {
        //         "id": 35,
        //         "href": "/category/3-1-mechi-svetyashchiesya",
        //         "name": "3.1 Мечи светящиеся",
        //         "parent_id": 5
        //     },
        //     {
        //         "id": 36,
        //         "href": "/category/3-2-shapki-s-ushami",
        //         "name": "3.2 Шапки с ушами",
        //         "parent_id": 5
        //     },
        //     {
        //         "id": 37,
        //         "href": "/category/3-3-obodki-svetyashchiesya",
        //         "name": "3.3 Ободки светящиеся",
        //         "parent_id": 5
        //     },
        //     {
        //         "id": 49,
        //         "href": "/category/2-1-top-prodazh-i-novinki",
        //         "name": "2.1 ТОП продаж и новинки",
        //         "parent_id": 4
        //     },
        //     {
        //         "id": 50,
        //         "href": "/category/2-2-iz-multikov-i-igr",
        //         "name": "2.2 Из мультиков и Игр",
        //         "parent_id": 4
        //     },
        // ],
        collapsed: true,
        menuType: 'simple',
        miniMenu: false,
        width: '320px',
        search: ''
    }),
    computed: {
        ...mapGetters('cart', { cartCnt: 'length', cartTotal: 'total' }),
        ...mapGetters('categories', { allCategories: 'allCategories' }),
        ismobile() {
            return this.screenWidth < 600;
        },
        filteredProducts() {
            return this.allCategories.filter(p => {
                return p.title.toLowerCase().indexOf(this.search.toLowerCase()) !== -1;
            });
        },
        categoriesForSidebar() {
            let unflatten = function( array, parent, tree ){
                tree = typeof tree !== 'undefined' ? tree : [];
                parent = typeof parent !== 'undefined' ? parent : { id: null };

                var children = _.filter( array, function(child){ return child.parent_id === parent.id; });

                if( !_.isEmpty( children )  ){
                    if( parent.id === null ){
                        tree = children;
                    }else{
                        parent['children'] = children
                    }
                    _.each( children, function( child ){ unflatten( array, child ) } );
                }
                return tree;
            }

            let arr = this.allCategories.map(item => ({
                id: item.id,
                name: item.title,
                href: '/category/' + item.slug,
                parent_id: item.parent_id,
                collapseOnClick: item.parent_id !== null,
            }));

            return unflatten(arr);
        }
    },
    methods: {
        itemClickHandel(item) {
            // console.log(this.$el.childNodes);
            if (this.ismobile && !item?.children) {
                setTimeout(() => {
                    this.collapsed = true;
                }, 200);
            }
        },
        test() {
            console.log('test');
        }
    },
    created() {
        this.screenWidth = innerWidth;
    },
}
</script>

<style lang="scss">
    .vas-menu {
        @include media-breakpoint-down(xs) {
            .labelName {
                font-size: 14px;
            }
        }
        padding-top: 10px !important;
        height: calc(100vh - 65px) !important;
        .menu-item-base {
            margin-top: 6px;
        }
    }

    .mobile-bottom-nav {

        i.fa {
            color: red;
        }

        @include media-breakpoint-down(xs) {
            i {
                font-size: 1.4em;
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
