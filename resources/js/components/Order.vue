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
    const store = useAuthStore();

    const data = reactive({
		data_orders:[],
		loading:true,
		num_order:'',
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
        fetch_products();
    });
       
</script>
<style scoped>

</style>