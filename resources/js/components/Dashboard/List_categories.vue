<template>
    <!-- Content -->
<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Category</h3>
                      </div>
                      <form id="editUserForm" class="row g-3" onsubmit="return false">
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Category</label>
                          <input type="text" id="modalEditUserFirstName" v-model="data.category.name" class="form-control" placeholder="Category name" />
                        </div>
                        <div class="col-12 text-center">
                          <button v-if="data.action=='add'" type="submit" @click="addCategory()" class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button v-if="data.action=='edit'" type="submit" @click="updateCategory()" class="btn btn-primary me-sm-3 me-1">Submit</button>
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
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Category List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                  <button class="btn btn-primary" style="width: 143px;margin: 12px;" data-bs-toggle="modal" @click="data.action='add';data.category.name='';data.category.id='';" data-bs-target="#editUser">Add category</button>
                  <div class="table-responsive text-nowrap">
                   <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                      
                      <tr v-for="category in data.data_categories" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" data-bs-toggle="modal" @click="data.action='edit';data.category.name=category.name;data.category.id=category.id;" data-bs-target="#editUser" href="javascript:void(0);">
                                <i class="ti ti-pencil me-1"></i> Edit
                              </a>
                              <a class="dropdown-item" @click="deleteCategory(category)" href="javascript:void(0);"
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
      data_categories: [],
      category: {
        id: '',
        name: ''
      },
      loading:true,
      action:'',
    });

    const fetch_data = async () => {
      data.data_categories=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/category/index');
        if(response.data.exist){
          data.data_categories=response.data.categories;
        } 
        else {
          Swal.fire({
              icon: 'error',
              title: 'Categories...',
              text: response.data.message,
            });
        }
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Categories...',
                text: error,
              });
      }
      finally{
        data.loading=false;
      }
      
    };
    

    const addCategory = async () => {
      store.clearErrors();
      try {
        const response = await axios.post('/api/category/store', data.category);
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Category added',
            text: "Category '"+ response.data.category+"' added",
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Category...',
            text: response.data.message,
          });
        }
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const deleteCategory = async (category) => {
      try {
          Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the category '${category.name}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
          })
          .then(async (result) => {
            if (result.isConfirmed) {
                const response = await axios.delete("/api/category/destroy/"+category.id);
                if(response.data.success){
                  fetch_data();
                  Swal.fire({
                    icon: 'success',
                    title: 'Category...',
                    text: response.data.message,
                  });
                }
                else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Category...',
                    text: response.data.message,
                  });
                }
            }
          });
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const updateCategory = async () => {
      try {
        const response = await axios.put("/api/category/update/"+data.category.id,{'name':data.category.name});
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Category...',
            text: response.data.message,
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Category...',
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