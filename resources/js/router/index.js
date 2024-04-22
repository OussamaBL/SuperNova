import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/components/Home.vue";
import Login from "@/components/Auth/Login.vue";
import Register from "@/components/Auth/Register.vue";
import Forget_password from "@/components/Auth/Forget_password.vue";
import New_password from "@/components/Auth/New_password.vue";
import Dashboard from "@/components/Dashboard/Dashboard.vue";
import Categories from "@/components/Dashboard/List_categories.vue";
import Sub_categories from "@/components/Dashboard/List_sub_categories.vue";
import Products from "@/components/Dashboard/List_Products.vue";
import Add_Edit_product from "@/components/Dashboard/Add_Edit_product.vue";
import Coupons from "@/components/Dashboard/Coupons.vue";
import Back_Payments from "@/components/Dashboard/Back_Payments.vue";
import Back_orders from "@/components/Dashboard/Back_orders.vue";

import Product from "@/components/Product.vue";
import Profile from "@/components/Profile.vue";
import List_products from "@/components/List_products.vue";
import Wishlist from "@/components/Wishlist.vue";
import Cart from "@/components/Cart.vue";
import Order from "@/components/Order.vue";

import { useAuthStore } from '@/stores/useAuthStore.js';


    function checkIfLogged() {
        const store = useAuthStore();
        if (!store.getUser) return '/login';
        if(store.getUser.role=="admin") return true;
        if(store.getUser.role=="client") return false;
    }

    function checkIfNotLogged() {
        const store = useAuthStore();
        if (store.getUser) return '/';
    }


const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/login",
            name: "login",
            component: Login,
        },
        {
            path: "/register",
            name: "register",
            component: Register,
        },
        {
            path: "/forget_password",
            name: "forget_password",
            component: Forget_password,
        },
        {
            path: "/New_password/:token",
            name: "New_password",
            component: New_password,
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/categories",
            name: "categories",
            component: Categories,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/sub_categories",
            name: "sub_categories",
            component: Sub_categories,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/products",
            name: "products",
            component: Products,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/cu_product",
            name: "cu_product",
            component: Add_Edit_product,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Product",
            name: "Product",
            component: Product,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Profile",
            name: "Profile",
            component: Profile,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/List_products",
            name: "List_products",
            component: List_products,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Wishlist",
            name: "Wishlist",
            component: Wishlist,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Cart",
            name: "Cart",
            component: Cart,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Order",
            name: "Order",
            component: Order,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Coupons",
            name: "Coupons",
            component: Coupons,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Back/payments",
            name: "Back_Payments",
            component: Back_Payments,
            // beforeEnter: [checkIfLogged],
           
        },
        {
            path: "/Back/orders",
            name: "Back_orders",
            component: Back_orders,
            // beforeEnter: [checkIfLogged],
           
        },
        
        
        
    ],
});

export default router;