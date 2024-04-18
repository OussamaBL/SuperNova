<template>
	<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">SuperNova</p>
							<h1>E-commerce Gaming</h1>
							<div class="hero-btns">
								<a href="shop.html" class="boxed-btn">Collection</a>
								<a href="contact.html" class="bordered-btn">Contact Us</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

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
	<!-- end search area -->

    <!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-shipping-fast"></i>
						</div>
						<div class="content">
							<h3>Free Shipping</h3>
							<p>When order over $75</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>24/7 Support</h3>
							<p>Get support all day</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Refund</h3>
							<p>Get refund within 3 days!</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end features list section -->

    <!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Popular</span> Products</h3>
						<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p> -->
					</div>
				</div>
			</div>
            <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
			<div v-if="!$data.loading" class="row">
				<div v-for="product in data.data_products" :key="product.id" class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
							<router-link :to="{ path: '/Product', query: { product_id: product.id } }">
                                <img :src="`/images/products/${product.image}`">
                            </router-link>
						</div>
						<h3>{{ product.title }}</h3>
						<p class="product-price"><span>{{ product.sub_category.name}}</span> {{ product.price }}$ </p>
						<!-- cart -->
						<a v-if="product.cart_id==null" @click="addCart(product.id,product.title)" href="javascript:void(0);" class="cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </a>
                        <a v-else href="javascript:void(0);" @click="removeCart(product.cart_id,product.title)" class="cart-btn">
                            <i class="fas fa-shopping-cart"></i> Added
                        </a>
						<!-- wishlist -->
						<a v-if="product.wishlist_id==null" @click="addWishlist(product.id,product.title)" href="javascript:void(0);" class="mt-2 mr-3" style="float: right;">
                            <i class="fa fa-heart-o" style="color: orange;font-size: 26px;"></i>
                        </a>
                        <a v-else href="javascript:void(0);" @click="removeWishlist(product.wishlist_id,product.title)" class="mt-2 mr-3" style="float: right;">
                            <i class="fas fa-heart" style="color: orange;font-size: 26px;"></i>
                        </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end product section -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
                            <img :src="`/images/company-logos/1.png`">
						</div>
						<div class="single-logo-item">
							<img :src="`/images/company-logos/2.png`">
						</div>
						<div class="single-logo-item">
							<img :src="`/images/company-logos/3.png`">
						</div>
						<div class="single-logo-item">
							<img :src="`/images/company-logos/4.png`">
						</div>
						<div class="single-logo-item">
							<img :src="`/images/company-logos/5.png`">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->
	
</template>

<script setup>
import { reactive,onMounted } from "vue";
import Swal from 'sweetalert2';
import { useAuthStore } from '@/stores/useAuthStore.js';
import { addProduct_Wishlist, removeProduct_Wishlist } from '../files_script/wishlistFunctions.js';
import { addProduct_Cart, removeProduct_Cart } from '../files_script/cartFunctions.js';

const store = useAuthStore();

	const data = reactive({
		data_products: [],
		loading:true,
	});

	const fetch_data = async () => {
      data.data_products=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/product/popular');
        if(response.data.exist){
          data.data_products=response.data.products;
        } 
        else {
          Swal.fire({
              icon: 'error',
              title: 'Products...',
              text: response.data.message,
            });
        }
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Products...',
                text: error,
              });
      }
      finally{
        data.loading=false;
      }
      
    };

	const addWishlist = async (product_id,title) =>{
        addProduct_Wishlist(product_id,title,store);
    }
    const removeWishlist = async (wishlist_id,title) =>{
        removeProduct_Wishlist(wishlist_id,title,store);
    }

	const addCart = async (product_id,title) =>{
        addProduct_Cart(product_id,title,store);
    }
    const removeCart = async (cart_id,title) =>{
        removeProduct_Cart(cart_id,title,store);
    }

    onMounted(fetch_data);
</script>

<style>
#app{
    height: 100% !important;
}
</style>
<style scoped>

</style>