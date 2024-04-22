<template>
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Payments List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
        
                  <div class="table-responsive text-nowrap">
                   <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Num order</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Payment status</th>
                        <th>Payment method</th>
                        <th>User</th>
                        <th></th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                      
                      <tr v-for="payment in data.data_payments.data" :key="payment.id">
                        <td>{{ payment.id }}</td>
                        <td>{{ payment.num_order }}</td>
                        <td>${{ payment.amount }}</td>
                        <td>{{ payment.currency }}</td>
                        <td>{{ payment.payment_status }}</td>
                        <td>{{ payment.payment_method }}</td>
                        <td>{{ payment.user.name }}</td>
                        <td>
                          <router-link :to="{ path: '/Back/orders', query: { num_order: payment.num_order } }">
                            <i class="fas fa-shopping-cart"></i>
                          </router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Bootstrap5Pagination
                        :data="data.data_payments"
                        @pagination-change-page="fetch_data" style="margin: 16px;justify-content: center !important;"
                    />
                </div>
                <!-- Offcanvas to add new customer -->
                
              </div>
    </div>
            <!-- / Content -->
</template>
<script setup>
    import { reactive,onMounted } from "vue";
    import Swal from 'sweetalert2';
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    // import router from '@/router';
    // import { useAuthStore } from '@/stores/useAuthStore.js';

    // const store = useAuthStore();
    
    const data = reactive({
      data_payments: [],
      loading:true,
    });

    const fetch_data = async (page = 1) => {
      data.data_payments=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/payments?page='+page);
        if(response.data.exist){
            
          data.data_payments=response.data.payments;
        } 
        else {
          Swal.fire({
              icon: 'error',
              title: 'Payments...',
              text: response.data.message,
            });
        }
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Payments...',
                text: error,
              });
      }
      finally{
        data.loading=false;
      }
      
    };
    
    onMounted(fetch_data); 
</script>
<style>
div:where(.swal2-container) {
z-index: 2000;
}
</style>