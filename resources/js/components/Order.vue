<template>
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section " :style="{ backgroundImage: `url('/images/back_wishlist.jpg')` }">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<h1>Orders</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

<!-- Order -->
<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12" style="margin: 0 auto;">
					<div class="cart-table-wrap">
                        <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
						<table v-if="!data.loading" class="cart-table">
							<thead class="cart-table-head" >
								<tr class="table-head-row" style="background-color: #051922;color: white;">
									<th class="product-image">Product Image</th>
									<th class="product-name" style="width: 18%;">Title</th>
									<th class="product-name">Sub Category</th>
									<th class="product-name">Category</th>
									<th class="product-price" style="width: 12%;">Price</th>
									<th class="product-price" style="width: 12%;">Quantity</th>
									<th class="product-price" style="width: 18%;">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="order in data.data_orders" :key="order.id" class="table-body-row">
									<td class="product-image">
										<router-link :to="{ path: '/Product', query: { product_id: order.product.id } }">
											<img :src="`/images/products/${order.product.image}`" style="max-width: 48%;">
										</router-link>
                                    </td>
									<td class="product-name">{{ order.product.title }}</td>
									<td class="product-name">{{ order.product.sub_category.name }}</td>
									<td class="product-name">{{ order.product.sub_category.category.name }}</td>
									<td class="product-price">${{ order.product.price }}</td>
									<td class="product-price">${{ order.qte }}</td>
									<td class="product-price">${{ order.qte*order.product.price }}</td>
									
								</tr>
							</tbody>
						</table>
					</div>
					<div class="total-section">
								<table class="total-table">
									<thead class="total-table-head">
										<tr class="table-total-row" style="background-color: rgb(5, 25, 34);color: white;">
											<th>Total</th>
											<th>${{ data.amount }}</th>
										</tr>
									</thead>
								</table>
							</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end Order -->

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
	import { useRoute } from 'vue-router';

    const store = useAuthStore();
	const route = useRoute(); 

    const data = reactive({
		data_orders:[],
		loading:true,
		num_order:'',
		amount:'',
	});

	const fetch_products = async () =>{
        data.data_orders=[];
        data.loading = true;
        try {
            const response = await axios.get('/api/order/products/'+data.num_order);
            if(response.data.exist){
				data.data_orders=response.data.orders;
				console.log(data.data_orders);
			}
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Orders...',
                    text: response.data.message,
                    });
            }
        } catch (error) {
            Swal.fire({
                    icon: 'error',
                    title: 'Orders...',
                    text: error,
                });
        }
        finally{
            data.loading=false;
        }
    };

	onMounted(()=>{
        data.num_order=route.query.num_order;
        data.amount=route.query.amount;
        fetch_products();
    });
       
</script>
<style scoped>

</style>