import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/components/Home.vue";
import Login from "@/components/Login.vue";
import { useAuthStore } from '@/stores/useAuthStore.js';


    function checkIfLogged() {
        const store = useAuthStore();
        if (!store.getUser) return '/login';
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
            // beforeEnter: [checkIfLogged],
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            // beforeEnter: [checkIfNotLogged],
        },
    ],
});

export default router;