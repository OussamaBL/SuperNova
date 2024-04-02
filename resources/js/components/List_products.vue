<template>

    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Shop</h1>
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
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li  v-for="sub_category in data.data_sub_categories" :key="sub_category.id" @click="changeSubCategory(sub_category.id)">{{ sub_category.name }}</li>
                            <!-- <li class="active" data-filter="*">All</li>
                            <li data-filter=".strawberry">Strawberry</li>
                            <li data-filter=".berry">Berry</li>
                            <li data-filter=".lemon">Lemon</li> -->
                        </ul>
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
						<p class="product-price"><span>{{ product.sub_category.name}}</span> {{ product.price }}$ </p>
						<a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
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
	<!-- <div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<!-- end logo carousel -->
</template>

<script setup>
    import { reactive,onMounted } from "vue";
    import Swal from 'sweetalert2';
    import { useRoute } from 'vue-router';
    import router from '@/router';
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const route = useRoute(); 
    const store = useAuthStore();
    
    const data = reactive({
      data_products: [],
      data_sub_categories: [],
      id_category:'',
      id_subCategory:'',
      loading:true,
    });

    const fetch_data = async () => {
      data.data_sub_categories=[];
      try {
        const response = await axios.get('/api/category/sub_categories/'+data.id_category);
        if(response.data.success){
            data.data_sub_categories=response.data.sub_categories;
        } 
        else {
          Swal.fire({
              icon: 'error',
              title: 'Sub Categories...',
              text: response.data.message,
            });
        }
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Sub Categories...',
                text: error,
              });
      }
      
    };

    const fetch_products = async (page=1) =>{
        data.data_products=[];
        data.loading = true;
        try {
            const response = await axios.get('/api/products/subCategory/'+data.id_subCategory+'?page='+page);
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
    }


    const changeSubCategory= async (subCategory) =>{
        data.data_products=[];
        data.id_subCategory=subCategory;
        fetch_products();
    }

    onMounted(() => {
      data.id_category = route.query.category;
      fetch_data();
    });
</script>

<style scoped>

</style>