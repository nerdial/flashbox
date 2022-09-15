// app.js
import './bootstrap';

import {createApp} from 'vue'

import {createWebHistory, createRouter} from "vue-router";

import SellerList from './Components/Seller/List.vue';
import AddSeller from './Components/Seller/Add.vue';

import ProductList from './Components/Product/List.vue';
import AddProduct from './Components/Product/Add.vue';

import CustomerProduct from './Components/Customer/ProductList.vue';

import Home from './Components/Main/Home.vue'
import App from './Components/App.vue'

const routes = [
    {path: '/app', component: Home, name: 'home'},

    {path: '/admin/sellers', component: SellerList, name: 'admin.sellers'},
    {path: '/admin/sellers/add', component: AddSeller, name: 'admin.sellers.add'},

    {path: '/seller/products', component: ProductList, name: 'seller.products'},
    {path: '/seller/products/add', component: AddProduct, name: 'seller.products.add'},

    {path: '/customer/products', component: CustomerProduct, name: 'customer.productList'},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

createApp(App).use(router).mount('#app')


