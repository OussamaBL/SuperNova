<template>
    <Header></Header>
    <router-view></router-view>
    <Footer></Footer>
</template>

<script setup>
    import Header from './Layouts/Header.vue';
    import Footer from './Layouts/Footer.vue';
    import { onMounted } from "vue";
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();

    onMounted(() => {
        store.setUser();
    });

</script>

<style>
</style>