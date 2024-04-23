<template>
<div :key="data.sub_category.id">
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg" :style="{ backgroundImage: `url('/images/${data.sub_category.image}')` }">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>{{ data.sub_category.category.name }}</p>
						<h1>{{ data.sub_category.name }}</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

    <!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
            <div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3>The sub-categories of<span class="orange-text">&nbsp; {{ data.sub_category.name }}</span> </h3>
						<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p> -->
					</div>
				</div>
			</div>

            <div class="container" style="margin-bottom: 20px;">
                <div style="margin: 0 auto;">
                    <label class="" for="select">Sort by :</label>
                    <div class="select" >
                        <select class="sl" @change="filter" value="">
                            <option value="filterByVente">Sales, descending order</option>
                            <option value="order_name_asc">Name, A to Z</option>
                            <option value="order_name_desc">Name, Z to A</option>    
                            <option value="price_asc">Ascending price</option>
                            <option value="price_desc">Price, decreasing</option>
                        </select>
                    </div>
                </div>
                
            </div>
            
            <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
            <div v-if="!data.loading" class="row product-lists">
				
				<div v-for="product in data.data_products.data" :key="product.id" class="col-lg-4 col-md-6 text-center strawberry">
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
            <Bootstrap5Pagination :data="data.data_products"
                    @pagination-change-page="fetch_products" style="margin: 16px;justify-content: center !important;"
            />
        </div>
	</div>
	<!-- end products -->

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
</div>  
</template>

<script setup>
    import { reactive,onMounted,watch } from "vue";
    import Swal from 'sweetalert2';
    import router from '@/router';
    import { useRoute } from 'vue-router';
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    import { useAuthStore } from '@/stores/useAuthStore.js';
    import { addProduct_Wishlist, removeProduct_Wishlist } from '../files_script/wishlistFunctions.js';
    import { addProduct_Cart, removeProduct_Cart } from '../files_script/cartFunctions.js';

    const route = useRoute(); 
    const store = useAuthStore();
    
    const data = reactive({
    //   routeKey:route.query.subCategory,
      data_products: [],
      sub_category:{
        id:'',
        name:'',
        image:'',
        category:{
            id:'',
            name:'',
        },
      },
      loading:true,
    });

    const fetch_subCategory = async () =>{
        try {
            const response = await axios.get('/api/sub_category/show/'+data.sub_category.id);
            if(response.data.exist){
                data.sub_category=response.data.subCategory;
            }
                
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'sub_category...',
                    text: response.data.message,
                    });
            }
        } catch (error) {
            Swal.fire({
                    icon: 'error',
                    title: 'sub_category...',
                    text: error,
                });
        }
    }

    const fetch_products = async (page=1) =>{
        data.data_products=[];
        data.loading = true;
        try {
            if(!store.getUser){
                var response = await axios.get('/api/products/subCategory/'+data.sub_category.id+'/'+null+' ?page='+page);
            }
            else{
                var response = await axios.get('/api/products/subCategory/'+data.sub_category.id+'/'+store.getID+' ?page='+page);
            } 
            if(response.data.exist){
                data.data_products=response.data.products;
                // alert(response.data.message);
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
    }

    const filter = async (event,page=1) => {
        const selectedValue = event.target.value;
        data.data_products=[];
        data.loading = true;
        try {
            if(!store.getUser){
                var response = await axios.get('/api/products/filter/'+data.sub_category.id+'/'+selectedValue+'/'+null+'page='+page);
            }
            else{
                var response = await axios.get('/api/products/filter/'+data.sub_category.id+'/'+selectedValue+'/'+store.getID+' ?page='+page);
            } 
            
            if(response.data.exist)
                data.data_products=response.data.products;
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Products...',
                    text: response.data.message,
                    });
            }
        } 
        catch (error) {
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
        if(!store.getUser) {
			router.push('/login');
			Swal.fire({
                icon: 'error',
                title: 'User...',
                text: 'You need to authenticate !',
              });
		}
		else addProduct_Wishlist(product_id,title,store);
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

    onMounted(async() => {
        const subCategory = route.query.subCategory;
        if (subCategory) {
            data.sub_category.id = subCategory;
            await fetch_subCategory();
            fetch_products();
        }
    });

    watch(() => route.query.subCategory, async (newValue, oldValue) => {
        if (newValue !== oldValue) {
            data.sub_category.id = newValue;
            await fetch_subCategory();
            fetch_products();
        }
    });

</script>

<style scoped>
/* :root {
  --gray: #34495e;
  --darkgray: #2c3e50;
} */

.sl {
  /* Reset Select */
  appearance: none;
  outline: 10px red;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: #fff;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
}
.sl option{
    color: black;
}
/* Remove IE arrow */
.sl::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  background-color: #051922;
  /* margin-bottom: 20px; */
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: -5px;
  right: 0;
  padding: 1em;
  background-color: #F28123;
  transition: .25s all ease;
  pointer-events: none;
}
/* Transition */
.select:hover::after {
  color: #f39c12;
}

/* Other styles*/


/* 가운데정렬 - position,transform*/




.down_note {
    display: flex;
    justify-content: center;

}
</style>