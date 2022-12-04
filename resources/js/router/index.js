import { createRouter, createWebHistory } from 'vue-router';

import Cart from '../views/Cart';
import Checkout from '../views/Checkout';
import ProductsList from '../views/ProductsList';
import Product from "../views/Product";
import CheckoutStep1 from '../views/checkout/Step1';
import CheckoutStep2 from '../views/checkout/Step2';
import E404 from '../views/E404';

// массив, который описывает пути доступные на нашем сайте
let routes = [
    {
        name: 'products',
        path: '/',
        component: ProductsList
    },
    {
        name: 'cart',
        path: '/cart',
        component: Cart
    },
    {
        name: 'checkout',
        path: '/order',
        component: Checkout,
        meta: { hidden: true }
        // children: [
        //     {
        //         path: '/',
        //         component: CheckoutStep1
        //     },
        //     {
        //         path: 'step-2',
        //         component: CheckoutStep2
        //     }
        // ]
    },

    {
        name: 'products-item',
        path: '/product/:id',
        component: Product
    },
    {
        name: 'E404',
        path: '/:pathMatch(.*)',
        component: E404
    }
];

export default createRouter({
    routes,
    history: createWebHistory('/')
    // history: createWebHistory()

});
