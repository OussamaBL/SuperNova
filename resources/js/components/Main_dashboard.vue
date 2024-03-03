<template>
    <div class="page-wrapper">
        <Header_mobile></Header_mobile>
        <Sidebar></Sidebar>
        <div class="page-container">
            <Header></Header>
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
    import Header from './Layouts/Back_office/Header_desktop.vue';
    import Header_mobile from './Layouts/Back_office/Header_mobile.vue';
    import Sidebar from './Layouts/Back_office/Sidebar.vue';
    import { onMounted } from "vue";
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();

    onMounted(() => {
        store.setUser();
    });

</script>
