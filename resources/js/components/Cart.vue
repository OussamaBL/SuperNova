<template>
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section " :style="{ backgroundImage: `url('/images/back_cart.webp')` }">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<h1>Cart</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="cart-table-wrap">
						<img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
						<table v-if="!data.loading" class="cart-table">
							<thead class="cart-table-head">
								<tr class="table-head-row" style="background-color: #051922;color: white;">
									<th class="product-remove"></th>
									<th class="product-image">Product Image</th>
									<th class="product-name" style="width: 18%;">Title</th>
									<th class="product-name">Sub Category</th>
									<th class="product-name">Category</th>
									<th class="product-price" style="width: 12%;">Price</th>
									<th class="product-quantity">Quantity</th>
									<th class="product-total" style="width: 9%;">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="cart in data.data_carts" :key="cart.id" class="table-body-row">
									<td class="product-remove">
										<a @click="removeCart(cart.id,cart.product.title)" href="javascript:void(0);">
											<i class="fas fa-trash" style="font-size: 20px;color: red;"></i>
										</a>
									</td>
									<td class="product-image">
										<router-link :to="{ path: '/Product', query: { product_id: cart.product.id } }">
											<img :src="`/images/products/${cart.product.image}`" style="max-width: 48%;">
										</router-link>
										
									</td>
									<td class="product-name">{{ cart.product.title }}</td>
									<td class="product-name">{{ cart.product.sub_category.name }}</td>
									<td class="product-name">{{ cart.product.sub_category.category.name }}</td>
									<td class="product-price">
										<span v-if="cart.product.discounted_price==0">${{ cart.product.price }}</span> 
										<span v-else>${{ cart.product.discounted_price }}</span> 
									</td>
									<td class="product-quantity">
										<input type="number" min="1" :max="cart.product.qte-cart.product.qte_order" v-model="cart.quantity" @input="calculateTotal(cart)" style="text-align: center;">
									</td>
									<td class="product-total" style="font-weight: bold;font-size: larger;">${{ cart.total }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<form id="form_checkout" action="/checkout" method="POST" style="display: none;">
					<input type="hidden" name="_token" :value="csrfToken">
					<input type="hidden" name="products" v-model="productDetails">
					<input type="hidden" name="user_id" v-model="store.getID">
					<input type="hidden" name="subtotal" v-model="subtotal">
					<!-- <button type="submit" id="checkoutButton">Checkout</button> -->
				</form>

				<div class="col-lg-12 mt-3">
					<div class="row">
						<div class="col-lg-2"></div>
						<div class="col-lg-3">
							<div class="coupon-section">
								<h3>Apply Coupon</h3>
								<div class="coupon-form-wrap">
									<form onsubmit="return false">
										<p><input type="text" placeholder="Coupon code" v-model="data.coupon"></p>
										<p><input type="submit" value="Apply" @click="verifyCoupon"></p>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="total-section">
								<table class="total-table">
									<thead class="total-table-head">
										<tr class="table-total-row" style="background-color: rgb(5, 25, 34);color: white;">
											<th>Total</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										<tr class="total-data">
											<td><strong>Subtotal: </strong></td>
											<td style="font-weight: bold;font-size: larger;">${{ subtotal }}</td>
										</tr>
										<tr class="total-data">
											<td><strong>Shipping: </strong></td>
											<td style="font-weight: bold;font-size: larger;">Free Shipping</td>
										</tr>
										<tr class="total-data">
											<td><strong>Coupon: </strong></td>
											<td style="font-weight: bold;font-size: larger;">{{data.percentage_coupon}}</td>
										</tr>
										<tr class="total-data">
											<td><strong>Total: </strong></td>
											<td style="font-weight: bold;font-size: larger;">${{total}}</td>
										</tr>
									</tbody>
								</table>
								<div class="cart-buttons">
									<a href="#" @click="handleCheckout" class="boxed-btn black">Check Out</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end cart -->

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
 	import { reactive,onMounted,computed,ref } from "vue";
    import Swal from 'sweetalert2';
    import { useAuthStore } from '@/stores/useAuthStore.js';
	import { addProduct_Cart, removeProduct_Cart } from '../files_script/cartFunctions.js';
	import { loadStripe } from '@stripe/stripe-js';

	const store = useAuthStore();

    const data = reactive({
		data_carts:[],
		coupon:'',
		loading:true,
		total:0,
		percentage_coupon:0,
	});

	const fetch_products = async () =>{
        data.data_carts=[];
        data.loading = true;
        try {
            const response = await axios.get('/api/products/cart/'+store.getID);
            if(response.data.exist){
				data.data_carts=response.data.carts.map(cart => ({
                    ...cart,
                    quantity: 1,
                    total: cart.product.discounted_price !== 0 ? cart.product.discounted_price : cart.product.price,
                }));
				// console.log(data.data_carts);
			}
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart...',
                    text: response.data.message,
                    });
            }
        } catch (error) {
            Swal.fire({
                    icon: 'error',
                    title: 'Cart...',
                    text: error,
                });
        }
        finally{
            data.loading=false;
        }
    }

	const calculateTotal = (cart) => {
		var price=0;
		if(cart.product.discounted_price!=0) price= cart.product.discounted_price;
		else price= cart.product.price;
        cart.total = cart.quantity * price;
    };

	const subtotal = computed(() => {
		return data.data_carts.reduce((total, cart) => total + cart.total, 0);
	});

	const total = computed(()=>{
		return (subtotal*data.percentage_coupon)/100;
	});
	const removeCart = async (cart_id,title) =>{
        await removeProduct_Cart(cart_id,title,store);
		fetch_products();
    }

	const productDetails = computed(() => JSON.stringify(data.data_carts.map(cart => ({ id: cart.product.id, quantity: cart.quantity }))));

	onMounted(()=>{
		fetch_products();
	});

	const csrfToken = ref(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
	
	const handleCheckout = async () => {
		try {
			document.getElementById('form_checkout').submit();
		} catch (error) {
			Swal.fire({
                    icon: 'error',
                    title: 'Cart...',
                    text: error,
                });
		}
	};
	
	const verifyCoupon = async () =>{
		try {
			const response= await axios.post('api/coupon/verify',data.coupon);
			if(response.data.success){
				alert(response.data.percentage);
				data.percentage_coupon=response.data.percentage;
			}
			else{
				Swal.fire({
                    icon: 'error',
                    title: 'Coupon...',
                    text: response.data.message,
                });
			}
		} catch (error) {
			Swal.fire({
                    icon: 'error',
                    title: 'Coupon...',
                    text: error,
                });
		}
	}

</script>

<style scoped>

</style>