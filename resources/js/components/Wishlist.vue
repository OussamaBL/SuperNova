<template>
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section " :style="{ backgroundImage: `url('/images/back_wishlist.jpg')` }">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<h1>Wishlist</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- Wishlist -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12" style="margin: 0 auto;">
					<div class="cart-table-wrap">
                        <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
						<table v-if="!data.loading" class="cart-table">
							<thead class="cart-table-head" >
								<tr class="table-head-row" style="background-color: #051922;color: white;">
									<th class="product-remove"></th>
									<th class="product-image">Product Image</th>
									<th class="product-name" style="width: 18%;">Title</th>
									<th class="product-name">Sub Category</th>
									<th class="product-name">Category</th>
									<th class="product-price" style="width: 12%;">Price</th>
									<th class="product-price" style="width: 18%;"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="wishlist in data.data_wishlist.data" :key="wishlist.id" class="table-body-row">
									<td class="product-remove">
										<a @click="removeWishlist(wishlist.id,wishlist.product.title)" href="javascript:void(0);">
											<i class="fas fa-trash" style="font-size: 20px;color: red;"></i>
										</a>
									</td>
									<td class="product-image">
										<router-link :to="{ path: '/Product', query: { product_id: wishlist.product.id } }">
											<img :src="`/images/products/${wishlist.product.image}`" style="max-width: 48%;">
										</router-link>
                                    </td>
									<td class="product-name">{{ wishlist.product.title }}</td>
									<td class="product-name">{{ wishlist.product.sub_category.name }}</td>
									<td class="product-name">{{ wishlist.product.sub_category.category.name }}</td>
									<td class="product-price">${{ wishlist.product.price }}</td>
									<td class="product-name">
										<!-- cart -->
										<a v-if="wishlist.cart_id==null" @click="addCart(wishlist.product.id,wishlist.product.title)" href="javascript:void(0);" class="cart-btn">
											<i class="fas fa-shopping-cart"></i> Add to Cart
										</a>
										<a v-else href="javascript:void(0);" @click="removeCart(wishlist.cart_id,wishlist.product.title)" class="cart-btn">
											<i class="fas fa-shopping-cart"></i> Added
										</a>
									</td>
								</tr>
							</tbody>
						</table>
						<Bootstrap5Pagination :data="data.data_wishlist"
							@pagination-change-page="fetch_products" style="margin: 16px;justify-content: center !important;"
						/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end Wishlist -->

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
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    import { useAuthStore } from '@/stores/useAuthStore.js';
	import { addProduct_Wishlist, removeProduct_Wishlist } from '../files_script/wishlistFunctions.js';
	import { addProduct_Cart, removeProduct_Cart } from '../files_script/cartFunctions.js';

    const store = useAuthStore();

    const data = reactive({
		data_wishlist:[],
		loading:true,
	});

	const fetch_products = async (page=1) =>{
        data.data_wishlist=[];
        data.loading = true;
        try {
            const response = await axios.get('/api/products/wishlist/'+store.getID+'?page='+page);
            if(response.data.exist){
				data.data_wishlist=response.data.wishlists;
				console.log(data.data_wishlist);
			}
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Wishlist...',
                    text: response.data.message,
                    });
            }
        } catch (error) {
            Swal.fire({
                    icon: 'error',
                    title: 'Wishlist...',
                    text: error,
                });
        }
        finally{
            data.loading=false;
        }
    }
	
	const removeWishlist = async (wishlist_id,title) =>{
        await removeProduct_Wishlist(wishlist_id,title,store);
		fetch_products();
    }

	const addCart = async (product_id,title) =>{
        addProduct_Cart(product_id,title,store);
    }
    const removeCart = async (cart_id,title) =>{
        removeProduct_Cart(cart_id,title,store);
    }

	onMounted(fetch_products);
</script>
<style scoped>

</style>