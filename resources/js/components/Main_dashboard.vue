<template>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <Sidebar></Sidebar>
            <div class="layout-page">
                <Header></Header>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <router-view></router-view>
                    <Footer></Footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
</template>

<script setup>
    import Header from './Layouts/Back_office/Header_desktop.vue';
    import Footer from './Layouts/Back_office/Footer.vue';
    import Sidebar from './Layouts/Back_office/Sidebar.vue';
    import { onMounted } from "vue";
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();

    onMounted(() => {
        store.setUser();
    });

</script>
