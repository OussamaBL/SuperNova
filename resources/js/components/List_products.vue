<template>

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
						<h3>The sub-categories of<span class="orange-text">&nbsp; {{ route.query.category_name }}</span> </h3>
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
        alert(data.sub_category.id);
        try {
            const response = await axios.get('/api/sub_category/show/'+data.sub_category.id);
            if(response.data.exist){
                data.sub_category=response.data.subCategory;
                console.log(data.sub_category);
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
            const response = await axios.get('/api/products/subCategory/'+data.sub_category.id+'?page='+page);
            if(response.data.exist)
                data.data_products=response.data.products;
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
            const response = await axios.get('/api/products/filter/'+data.sub_category.id+'/'+selectedValue+'?page='+page);
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

    onMounted(async() => {
      data.sub_category.id = route.query.subCategory;
      await fetch_subCategory();
      fetch_products();
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