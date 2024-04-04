<template>
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section" :style="{ backgroundImage: `url('/images/${data.product.sub_category.image}')` }">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>See more Details</p>
						<h1>{{ data.product.sub_category.category.name }}</h1>
						<!-- <h1>{{ data.product.sub_category.id }}</h1> -->
                        
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- single product -->
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="single-product-img">
						<img :src="`/images/products/${data.product.image}`" style="width: 445px;height: 445px;">
					</div>
				</div>
				<div class="col-md-7">
					<div class="single-product-content">
						<h3>{{ data.product.title }}</h3>
						<p class="single-product-pricing"><span>{{ data.product.sub_category.name}}</span> ${{ data.product.price}}</p>
						<p>{{ data.product.description}}</p>
						<div class="single-product-form">
							<a href="cart.html" class="cart-btn mr-3"><i class="fas fa-heart"></i> Add to Wishlist</a> 
							<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
							<p><strong>Category: </strong>{{ data.product.sub_category.category.name }}</p>
						</div>
						<h4>Share:</h4>
						<ul class="product-share">
							<li><a href=""><i class="fab fa-facebook-f"></i></a></li>
							<li><a href=""><i class="fab fa-twitter"></i></a></li>
							<li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href=""><i class="fab fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end single product -->

	<!-- more products -->
	<div class="more-products mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Related</span> Products</h3>
						<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p> -->
					</div>
				</div>
			</div>
			<div class="row">
				<div v-for="product in data.data_products" :key="product.id" class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
						<div class="product-image">
                            <router-link :to="{ path: '/Product', query: { product_id: product.id } }">
                                <img :src="`/images/products/${product.image}`">
                            </router-link>
						</div>
						<h3>{{ product.title }}</h3>
						<p class="product-price"><span>{{ product.sub_category.name}}</span> {{ product.price }}$ </p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- end more products -->
</template>

<script setup>
   import { reactive,onMounted } from "vue";
    import Swal from 'sweetalert2';
    import { useRoute } from 'vue-router';
    // import router from '@/router';
    // import { useAuthStore } from '@/stores/useAuthStore.js';

    const route = useRoute(); 
    // const store = useAuthStore();

    const data = reactive({
      product: {
        id: '',
        title: '',
        description: '',
        price: 0,
        discounted_price: 0,
        reference: '',
        image: '',
        qte: 0,
        qte_order: 0,
        sub_category: {
            id:'',
            name:'',
            image:'',
            category:{
                id:'',
                name:'',
            }
        },
        in_stock: true,
      },
      data_products: [],
    });

    const fetch_product = async () =>{
        try {
            const response = await axios.get('/api/product/show/'+data.product.id);
            if(response.data.exist){
                data.product=response.data.product;
                console.log(data.product);
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
    }

    const fetch_related_products = async () =>{
        data.data_products=[];
        try {
            const response = await axios.get('/api/products/related/'+data.product.sub_category.id+'/'+data.product.id);
            if(response.data.exist){
                data.data_products=response.data.products;
                console.log(data.data_products);
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
    }


onMounted(() => {
    data.product.id=route.query.product_id;
});
onMounted( async()=>{
   await fetch_product();
   fetch_related_products();
});
// onMounted();
</script>
<style scoped></style>