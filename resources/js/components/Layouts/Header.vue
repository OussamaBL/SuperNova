
<style>
		.btn_header{
			color:white !important;
			background-color:#F28123 !important;
			padding: 10px 23px !important;
    		border-radius: 11px;
			font-size: 11px !important;
			margin-right: 10px !important;
		}
	</style>
<template>
	
    <!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<router-link to="/">
								<h3><strong style="color: #F28123;">Super<span style="color: white;">Nova</span> </strong></h3>
							</router-link>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item">
									<router-link to="/">Home</router-link>
								</li>
								<li><a href="about.html">About</a></li>
								<li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="404.html">404 page</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="cart.html">Cart</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="contact.html">Contact</a></li>
										<li><a href="news.html">News</a></li>
										<li><a href="shop.html">Shop</a></li>
									</ul>
								</li>
								<li><a href="news.html">News</a>
									<ul class="sub-menu">
										<li><a href="news.html">News</a></li>
										<li><a href="single-news.html">Single News</a></li>
									</ul>
								</li>
								<li><a href="contact.html">Contact</a></li>
								<li><a href="shop.html">Shop</a>
									<ul class="sub-menu">
										<li><a href="shop.html">Shop</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="single-product.html">Single Product</a></li>
										<li><a href="cart.html">Cart</a></li>
									</ul>
								</li>
								<li>
									<div v-if="!store.getUser" class="header-icons" > 
										<router-link class="btn btn-primary btn_header" to="login">Sign in</router-link>
										<router-link class="btn btn-primary btn_header" to="register">Sign up</router-link>
									</div>
									<div v-else class="header-icons">
										<a class="shopping-cart" href="cart.html"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
										<button @click="userLogout" class="btn btn-primary btn_header">Log out</button>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search arewa -->
	

</template>



<script setup>
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import Swal from 'sweetalert2';
    import router from '@/router';

    const store = useAuthStore();

    const userLogout = async () => {
        
        try {
            const response = await axios.get('/api/logout', store.getHeaderConfig);
			if(response.data.success){
				store.clearStoredData();
				Swal.fire({
					icon: 'success',
					text: response.data.message,
				});
				router.push('/login');
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

<style>
</style>