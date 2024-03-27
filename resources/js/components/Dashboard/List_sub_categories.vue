<template>
    <!-- Content -->
<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                  <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center mb-4">
                        <h3 class="mb-2">Sub category</h3>
                      </div>
                      <form id="editUserForm" class="row g-3" onsubmit="return false">
                        <div class="col-12 col-md-6 mb-4" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Sub Category</label>
                          <input type="text" id="modalEditUserFirstName" v-model="data.sub_category.name" class="form-control" placeholder="Sub-Category name" />
                        </div>
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                          <label class="form-label" for="modalEditUserFirstName">Category</label>
                            <select id="modalEditUserCountry" class="select2 form-select" v-model="data.sub_category.id_catg" data-allow-clear="true">
                                <option value="">Select</option>
                                <option v-for="category in data.data_categories" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6" style="margin: 0 auto;">
                            <label class="form-label" for="basic-default-upload-file">Sub-category image</label>
                            <input type="file" class="form-control" id="basic-default-upload-file" @change="handleFileChange" />
                        </div>
                       
                        <div class="col-12 text-center">
                          <button v-if="data.action=='add'" type="submit" @click="addSubCategory()" class="btn btn-primary me-sm-3 me-1">Submit</button>
                          <button v-if="data.action=='edit'" type="submit" @click="updateSubCategory()" class="btn btn-primary me-sm-3 me-1">Submit</button>
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
              <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span>Sub Category List</h4>
              <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                  <button class="btn btn-primary" style="width: 190px;margin: 12px;" data-bs-toggle="modal" @click="add()" data-bs-target="#editUser">Add sub-category</button>
                  <div class="table-responsive text-nowrap">
                   <img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">
                  <table v-if="!$data.loading" class="table">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Sub Category</th>
                        <th>Category</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                   
                    <tbody class="table-border-bottom-0">
                      
                      <tr v-for="sub_category in data.data_sub_categories" :key="sub_category.id">
                        <td>
                          <img :src="`/images/${sub_category.image}`" style="width: 137px;height: 85px;" alt="">
                        </td>
                        <td>{{ sub_category.name }}</td>
                        <td>{{ sub_category.category.name }}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" data-bs-toggle="modal" @click="edit(sub_category)" data-bs-target="#editUser" href="javascript:void(0);">
                                <i class="ti ti-pencil me-1"></i> Edit
                              </a>
                              <a class="dropdown-item" @click="deleteSubCategory(sub_category)" href="javascript:void(0);"
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
      data_sub_categories: [],
      data_categories: [],
      sub_category: {
        id: '',
        name: '',
        image: '',
        id_catg: '',
      },
      loading:true,
      action:'',
    });

    const edit = (sub_category) => {
      data.action='edit';
      data.sub_category.name=sub_category.name;
      data.sub_category.id=sub_category.id;
      data.sub_category.image=sub_category.image;
      data.sub_category.id_catg=sub_category.id_catg;
    }
    const add = () => {
      data.action='add';
      data.sub_category.name='';
      data.sub_category.id='';
      data.sub_category.image='';
      data.sub_category.id_catg='';
    }
    const fetch_data = async () => {
      data.data_sub_categories=[];
      data.loading = true;
      try {
        const response = await axios.get('/api/sub_category/index');
        if(response.data.exist){
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
      finally{
        data.loading=false;
      }
      
    };
    const fetch_data_categories = async () => {
      data.data_categories=[];
      try {
        const response = await axios.get('/api/category/index');
        if(response.data.exist){
          data.data_categories=response.data.categories;
        } 
      } catch (error) {
          Swal.fire({
                icon: 'error',
                title: 'Categories...',
                text: error,
              });
      }
    };

    const handleFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        data.sub_category.image = file;
        // event.target.value = null;
      }
    };
    
    const addSubCategory = async () => {
      store.clearErrors();
      try {
        const formData = new FormData();
        formData.append('name', data.sub_category.name);
        formData.append('id_catg', data.sub_category.id_catg);
        formData.append('image', data.sub_category.image);

        const response = await axios.post('/api/sub_category/store', formData,{
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Sub Category added',
            text: "Sub Category '"+ response.data.sub_category+"' added",
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Sub Category...',
            text: response.data.message,
          });
        }
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const deleteSubCategory = async (sub_category) => {
      try {
          Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the sub-category '${sub_category.name}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
          })
          .then(async (result) => {
            if (result.isConfirmed) {
                const response = await axios.delete("/api/sub_category/destroy/"+sub_category.id);
                if(response.data.success){
                  fetch_data();
                  Swal.fire({
                    icon: 'success',
                    title: 'Sub-Category...',
                    text: response.data.message,
                  });
                }
                else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Sub-Category...',
                    text: response.data.message,
                  });
                }
            }
          });
      } catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    const updateSubCategory = async () => {
      try {
        const formUpdate = new FormData();
        formUpdate.append('name', data.sub_category.name);
        formUpdate.append('id_catg', data.sub_category.id_catg);
        formUpdate.append('image', data.sub_category.image);
        const response = await axios.post("/api/sub_category/update/"+data.sub_category.id,formUpdate,{
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        if(response.data.success){
          fetch_data();
          Swal.fire({
            icon: 'success',
            title: 'Sub Category...',
            text: response.data.message,
          });
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Sub Category...',
            text: response.data.message,
          });
        }
      } 
      catch (error) {
        store.setErrors(error.response.data.errors);
      }
    }

    onMounted(fetch_data); 
    onMounted(fetch_data_categories); 

</script>
<style>
div:where(.swal2-container) {
z-index: 2000;
}
</style>