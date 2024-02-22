<template>

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="breadcrumb-text">
                            <p>Get 24/7 Support</p>
                            <h1>Contact us</h1>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- end breadcrumb section -->
    
    
    <div class="container">
        <div class="row my-5">
          <div class="col-md-6 mx-auto">
            <ul class="list-group my-2" v-for="(errorArray, index) in store.getErrors" :key="index">
                <li class="list-group-item bg-danger text-white mb-1" v-for="(error, index) in errorArray" :key="index">
                    {{error}}
                </li>
            </ul>
            <div class="card">
              <div class="card-header bg-white">
                <h4 class="text-center">
                  Sign up
                </h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <input 
                    type="text" 
                    v-model="data.user.name"
                    placeholder="Name*" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                  <input 
                    type="text" 
                    v-model="data.user.email"
                    placeholder="Email*" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                  <input 
                    type="password" 
                    v-model="data.user.password"
                    placeholder="Password*" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                  <button @click="userAuth" class="btn btn-primary btn-xl">
                    Sign up
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    
    </template>
    
    <script setup>
      import { reactive } from "vue";
      import Swal from 'sweetalert2';
      import router from '@/router';
      import { useAuthStore } from '@/stores/useAuthStore.js';
      
    
      const store = useAuthStore();
      
      const data = reactive({
        user: {
          name:'',
          email: '',
          password: ''
        }
      });
    
      const userAuth = async () => {
        store.clearErrors();
        try {
          const response = await axios.post('/api/register', data.user);
          if(response.data.success){
            user_auth=response.data.user;
            store.storeUser(user_auth);
            router.push('/');
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: response.data.message,
            });
          }
        } catch (error) {
          store.setErrors(error.response.data.errors);
        }
      }
    </script>
    
    <style>
    </style>