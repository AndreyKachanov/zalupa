import { createRouter, createWebHistory } from 'vue-router';

import Cart from '../views/Cart';
import Checkout from '../views/Checkout';
import ProductsList from '../views/ProductsList';
import ProductsListMain from "../views/ProductsListMain";
import ParentCategoryProductsList from '../views/ParentCategoryProductsList'
import Product from "../views/Product";
import Test from "../views/Test";
import CheckoutStep1 from '../views/checkout/Step1';
import CheckoutStep2 from '../views/checkout/Step2';
import E404 from '../views/E404';
import ProductsListMainParentCategory from "../views/ProductsListMainParentCategory";

// массив, который описывает пути доступные на нашем сайте
let routes = [
    {
        name: 'products',
        path: '/',
        component: ProductsListMain
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
    },
    {
        name: 'category',
        path: '/category/:slug',
        component: ProductsListMainParentCategory
    },
    {
        name: 'products-item',
        path: '/:slug',
        component: Product
    },
    // {
    //     name: 'test',
    //     path: '/test',
    //     component: Test
    // },
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
