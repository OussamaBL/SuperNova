<template>

    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span>Products List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                  <router-link :to="{ path: '/cu_product', query: { action: 'create' } }" class="btn btn-primary" style="width: 190px;margin: 12px;">Add Product</router-link>
                  <div class="table-responsive text-nowrap">
                    <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Discounted price</th>
                        <th>Reference</th>
                        <th>Quantity in stock</th>
                        <th>Quantity in order</th>
                        <th>In stock</th>
                        <th>Sub-category</th>
                        <th>Category</th>
                        <th></th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                      
                      <tr v-for="product in data.data_products.data" :key="product.id">
                        <td>
                          <img :src="`/images/products/${product.image}`" style="width: 137px;height: 85px;" alt="">
                        </td>
                        <td>{{ product.title }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.discounted_price }}</td>
                        <td>{{ product.reference }}</td>
                        <td>{{ product.qte }}</td>
                        <td>{{ product.qte_order }}</td>
                        <td>
                          <span v-if="product.in_stock==true" class="badge bg-label-primary me-1">Active</span>
                          <span v-else class="badge bg-label-warning me-1">No Product</span>
                        </td>
                        <td>{{ product.sub_category.name }}</td>
                        <td>{{ product.sub_category.category.name }}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <router-link class="dropdown-item" :to="{ path: '/cu_product', query: { action: 'edit',product: JSON.stringify(product) } }" > <i class="ti ti-pencil me-1"></i> Edit</router-link>
                              <a class="dropdown-item" @click="deleteProduct(product)" href="javascript:void(0);"
                                ><i class="ti ti-trash me-1"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
                <Bootstrap5Pagination
                        :data="data.data_products"
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

    const data = reactive({
      data_products: [],
      loading:true,
      action:'',
    });

    const fetch_data = async (page = 1) => {
      data.data_products=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/product/index?page='+page);
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
      
    };
    
    const deleteProduct = async (product) => {
      try {
          Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the product '${product.title}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
          })
          .then(async (result) => {
            if (result.isConfirmed) {
                const response = await axios.delete("/api/product/destroy/"+product.id);
                if(response.data.success){
                  fetch_data();
                  Swal.fire({
                    icon: 'success',
                    title: 'Product...',
                    text: response.data.message,
                  });
                }
                else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Product...',
                    text: response.data.message,
                  });
                }
            }
          });
      } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Product...',
                    text: error,
                  });
      }
    }

    onMounted(fetch_data); 
</script>
<style>
div:where(.swal2-container) {
z-index: 2000;
}
</style>