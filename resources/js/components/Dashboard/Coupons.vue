<template>
    <!-- Content -->
<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Coupon</h3>
                      </div>
                      <form id="editUserForm" class="row g-3" onsubmit="return false">
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Code</label>
                          <input type="text" id="modalEditUserFirstName" v-model="data.coupon.code" class="form-control" placeholder="Coupon code" />
                        </div>
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Percentage</label>
                          <input type="number" id="modalEditUserFirstName" v-model="data.coupon.percentage" class="form-control" placeholder="Coupon percentage" />
                        </div>
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Expire</label>
                          <input type="date" id="modalEditUserFirstName" v-model="data.coupon.expire" class="form-control" placeholder="Coupon date expire" />
                        </div>
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Number of uses</label>
                          <input type="number" id="modalEditUserFirstName" v-model="data.coupon.count_use" class="form-control" placeholder="Number of uses" />
                        </div>
                        <div class="col-12 text-center">
                          <button v-if="data.action=='add'" type="submit" @click="addCoupon()" class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button v-if="data.action=='edit'" type="submit" @click="updateCoupon()" class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button
                            type="button"
                            class="btn btn-label-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Edit User Modal -->
    <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Coupon List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                  <button class="btn btn-primary" style="width: 143px;margin: 12px;" data-bs-toggle="modal" @click="data.action='add';data.coupon.code='';data.coupon.id='';data.coupon.percentage='';data.coupon.count_use='';data.coupon.expire=''" data-bs-target="#editUser">Add coupon</button>
                  <div class="table-responsive text-nowrap">
                   <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Code</th>
                        <th>Percentage</th>
                        <th>Expire</th>
                        <th>Number of uses</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                      
                      <tr v-for="coupon in data.data_coupons" :key="coupon.id">
                        <td>{{ coupon.id }}</td>
                        <td>{{ coupon.code }}</td>
                        <td>{{ coupon.percentage }}%</td>
                        <td>{{ coupon.expire }}</td>
                        <td>{{ coupon.count_use }}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" data-bs-toggle="modal" @click="data.action='edit';data.coupon.code=coupon.code;data.coupon.id=coupon.id;data.coupon.percentage=coupon.percentage;data.coupon.expire=coupon.expire;data.coupon.count_use=coupon.count_use;" data-bs-target="#editUser" href="javascript:void(0);">
                                <i class="ti ti-pencil me-1"></i> Edit
                              </a>
                              <a class="dropdown-item" @click="deleteCoupon(coupon)" href="javascript:void(0);"
                                ><i class="ti ti-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                </div>
                <!-- Offcanvas to add new customer -->
                
              </div>
    </div>
            <!-- / Content -->
</template>
<script setup>
    import { reactive,onMounted,ref } from "vue";
    import Swal from 'sweetalert2';
    import router from '@/router';
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();
    
    const data = reactive({
      data_coupons: [],
      coupon: {
        id: '',
        code: '',
        percentage: '',
        expire: '',
        count_use: '',
      },
      loading:true,
      action:'',
    });

    const fetch_data = async () => {
      data.data_coupons=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/coupon/index');
        if(response.data.exist){
          data.data_coupons=response.data.coupons;
        } 
        else {
          Swal.fire({
              icon: 'error',
              title: 'Coupons...',
              text: response.data.message,
            });
        }
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Coupons...',
                text: error,
              });
      }
      finally{
        data.loading=false;
      }
      
    };
    

    const addCoupon = async () => {
      store.clearErrors();
      try {
        const response = await axios.post('/api/coupon/store', data.coupon);
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Coupon added',
            text: "Coupon '"+ response.data.coupon+"' added",
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Coupon...',
            text: response.data.message,
          });
        }
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const deleteCoupon = async (coupon) => {
      try {
          Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the coupon '${coupon.name}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
          })
          .then(async (result) => {
            if (result.isConfirmed) {
                const response = await axios.delete("/api/coupon/destroy/"+coupon.id);
                if(response.data.success){
                  fetch_data();
                  Swal.fire({
                    icon: 'success',
                    title: 'Coupon...',
                    text: response.data.message,
                  });
                }
                else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Coupon...',
                    text: response.data.message,
                  });
                }
            }
          });
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const updateCoupon = async () => {
      try {
        const response = await axios.put("/api/coupon/update/"+data.coupon.id,data.coupon);
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Coupon...',
            text: response.data.message,
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Coupon...',
            text: response.data.message,
          });
        }
      } 
      catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }
    onMounted(fetch_data); 
</script>
<style>
div:where(.swal2-container) {
z-index: 2000;
}
</style>