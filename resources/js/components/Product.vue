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
                        <span>{{ data.product.sub_category.name}}</span> 
						<p v-if="data.product.discounted_price==0" class="single-product-pricing">
                            ${{ data.product.price}}
                        </p>
                        <p v-else class="single-product-pricing">
                                ${{ data.product.discounted_price}}
                                <span style="text-decoration: line-through;color: orange;">${{ data.product.price}}</span>
                        </p>
						<p>{{ data.product.description}}</p>
						<div class="single-product-form">
                            <a v-if="data.product.wishlist_id==null" @click="addWishlist(data.product.id,data.product.title)" href="javascript:void(0);" class="mt-2 mr-3" style="float: right;">
                                <i class="fa fa-heart-o" style="color: orange;font-size: 26px;"></i>
                            </a>
                            <a v-else href="javascript:void(0);" @click="removeWishlist(data.product.wishlist_id,data.product.title)" class="mt-2 mr-3" style="float: right;">
                                <i class="fas fa-heart" style="color: orange;font-size: 26px;"></i>
                            </a> 

							<!-- cart -->
                            <a v-if="data.product.cart_id==null" @click="addCart(data.product.id,data.product.title)" href="javascript:void(0);" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </a>
                            <a v-else href="javascript:void(0);" @click="removeCart(data.product.cart_id,data.product.title)" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> Added
                            </a>

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
                        <span>{{ product.sub_category.name}}</span>
						<p v-if="product.discounted_price==0" class="product-price">
                            ${{ product.price}}
                        </p>
                        <p v-else class="product-price">
                                ${{ product.discounted_price}}
                                <span style="text-decoration: line-through;color: orange;font-size: 20px;">${{ product.price}}</span>
                        </p>
						
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
	<!-- end more products -->
</template>

<script setup>
    import { reactive,onMounted,watch } from "vue";
    import Swal from 'sweetalert2';
    import { useRoute } from 'vue-router';
    import router from '@/router';
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import { addProduct_Wishlist, removeProduct_Wishlist } from '../files_script/wishlistFunctions.js';
    import { addProduct_Cart, removeProduct_Cart } from '../files_script/cartFunctions.js';

    const route = useRoute(); 
    const store = useAuthStore();

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
        wishlist_id:null,
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
            if(!store.getUser){
                var response = await axios.get('/api/product/show/'+data.product.id+'/'+null);
            }
            else{
                var response = await axios.get('/api/product/show/'+data.product.id+'/'+store.getID);
            } 
            if(response.data.exist){
                data.product=response.data.product;
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
            if(!store.getUser){
                var response = await axios.get('/api/products/related/'+data.product.sub_category.id+'/'+data.product.id+'/'+null);
            }
            else{
                var response = await axios.get('/api/products/related/'+data.product.sub_category.id+'/'+data.product.id+'/'+store.getID);
            } 
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
    }

    const addWishlist = async (product_id,title) =>{
        if(!store.getUser) {
			router.push('/login');
			Swal.fire({
                icon: 'error',
                title: 'User...',
                text: 'You need to authenticate !',
              });
		}
		else
        addProduct_Wishlist(product_id,title,store);
    }
    const removeWishlist = async (wishlist_id,title) =>{
        if(!store.getUser) {
			router.push('/login');
			Swal.fire({
                icon: 'error',
                title: 'User...',
                text: 'You need to authenticate !',
              });
		}
		else
        removeProduct_Wishlist(wishlist_id,title,store);
    }

    const addCart = async (product_id,title) =>{
        if(!store.getUser) {
			router.push('/login');
			Swal.fire({
                icon: 'error',
                title: 'User...',
                text: 'You need to authenticate !',
              });
		}
		else
        addProduct_Cart(product_id,title,store);
    }
    const removeCart = async (cart_id,title) =>{
        if(!store.getUser) {
			router.push('/login');
			Swal.fire({
                icon: 'error',
                title: 'User...',
                text: 'You need to authenticate !',
              });
		}
		else
        removeProduct_Cart(cart_id,title,store);
    }

    watch(() => route.query.product_id, async (newValue, oldValue) => {
        if (newValue !== oldValue) {
            data.product.id = newValue;
            await fetch_product();
            fetch_related_products();
        }
    });

onMounted( async()=>{
    data.product.id=route.query.product_id;
   await fetch_product();
   fetch_related_products();
});
</script>

<style scoped></style>