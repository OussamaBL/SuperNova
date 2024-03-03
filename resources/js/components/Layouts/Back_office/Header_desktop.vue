<template>
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <!-- <img :src="`/images/users/{{ store.getUser.data.avatar }}`" alt="{{ store.getUser.data.name }}" /> -->
                                            <img style="border-radius: 28px;height: 45px;" :src="`/images/users/${store.getUser.data ? store.getUser.data.avatar : 'Loading...'}`" alt="{{ store.getUser.data.name }}" />
                                        </div>
                                        <div class="content">
                                            <!-- <a class="js-acc-btn" href="#" v-text="data.user.data.name"></a> -->
                                            <a class="js-acc-btn" href="#">{{ store.getUser.data ? store.getUser.data.name : 'Loading...' }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="./dashboard_img/icon/avatar-01.jpg" alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <!-- <a href="#">{{ store.getUser.role }}</a> -->
                                                    </h5>
                                                    <span class="email">johndoe@example.com</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="#">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->
</template>

<script setup>
    import { reactive } from "vue";
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import Swal from 'sweetalert2';
    import router from '@/router';

    const store = useAuthStore();

    const data = reactive({
      user: store.getUser,
    });

    const userLogout = async () => {
        try{
            const response = await axios.get('/api/logout', store.getHeaderConfig);
			if(response.data.success){
				store.clearStoredData();
				Swal.fire({
					icon: 'success',
					text: response.data.message,
				});
				window.location.href = '/#/login';
			}
			else{
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Error in log out',
				});
			}
    	} catch (error) {
            Swal.fire({
                icon: 'error',
				title: 'Oops...',
				text: 'Error in log out',
            });
        }
    }

</script>