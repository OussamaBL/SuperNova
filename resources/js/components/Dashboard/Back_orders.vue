<template>

    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span>Order Products List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
            
                  <div class="table-responsive text-nowrap">
                    <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Sub-category</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                        <tr v-for="order in data.data_orders" :key="order.id">
                            <td>
                                <img :src="`/images/products/${order.product.image}`" style="width: 137px;height: 85px;" alt="">
                            </td>
                            <td>{{ order.product.title }}</td>
                            <td>{{ order.product.sub_category.name }}</td>
                            <td>{{ order.product.sub_category.category.name }}</td>
                            <td>${{ order.product.price }}</td>
                            <td>{{ order.qte }}</td>
                            <td>${{ order.qte*order.product.price }}</td>
                        </tr>
                    </tbody>
                  </table>
                  
                </div>
                <!-- Offcanvas to add new customer -->
                
              </div>
    </div>
    </div>
            <!-- / Content -->
</template>

<script setup>
    import { reactive,onMounted } from "vue";
    import Swal from 'sweetalert2';
    import { useRoute } from 'vue-router';

    const route = useRoute(); 

    const data = reactive({
      data_orders: [],
      num_order: '',
      loading:true,
    });

    const fetch_data = async () => {
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
        fetch_data();
    }); 

</script>
<style>
div:where(.swal2-container) {
z-index: 2000;
}
</style>