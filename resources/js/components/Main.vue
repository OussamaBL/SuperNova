<template>
    <Header></Header>
    <router-view></router-view>
    <Footer></Footer>
</template>

<script setup>
    import Header from './Layouts/Front_office/Header.vue';
    import Footer from './Layouts/Front_office/Footer.vue';
    import { onMounted } from "vue";
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();

    onMounted(() => {
        store.setUser();
    });

</script>

<style>
</style>