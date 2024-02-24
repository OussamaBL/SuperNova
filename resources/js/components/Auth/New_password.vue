<template>

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="breadcrumb-text">
                            <!-- <p>Get 24/7 Support</p> -->
                            <h1>Reset password</h1>
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
                    Reset password
                </h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <input 
                    type="password" 
                    v-model="data.user.password"
                    placeholder="New Password *" class="form-control">
                    <span style="color: red;" v-text="data.invalid_password"></span>
                </div>
                <div class="form-group mb-3">
                  <input 
                    type="password" 
                    v-model="data.user.confirm_password"
                    placeholder="Confirmation of Password *" class="form-control">
                    <span style="color: red;" v-text="data.invalid_confirm_password"></span>
                </div>
                
                <div class="form-group mb-3 text-center">
                  <button @click="userResetPass" class="btn btn-primary btn-xl">
                    Update
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
        import { useRoute } from 'vue-router';
        import router from '@/router';
        import { useAuthStore } from '@/stores/useAuthStore.js';
        
    
        const store = useAuthStore();
        const route = useRoute();
        
        const data = reactive({
          user: {
            password: '',
            confirm_password: '',
          },
          invalid_password:'',
          invalid_confirm_password:'',
          passwordPattern: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/,
        });


        const token = route.params.token;

        // Verify Expires of Token
        const VerifyToken= async () => {
            const response = await axios.post('/api/verify_token', {'token':token});
            if(!response.data.success){
                Swal.fire({
                icon: 'error',
                title: 'Verify token',
                text: response.data.message,
              });
              router.push('/login');
            }
            else Swal.fire({
                icon: 'success',
                title: 'Verify token',
                text: response.data.message,
              });
        };

        // Execute the function of verify token 
        VerifyToken();
    
        const validatePassword = () => {
          let etat=true;
          if (!data.passwordPattern.test(data.user.password)) {
            data.invalid_password='Invalid password';
            etat =false;
          }
          if (data.user.password!=data.user.confirm_password) {
            data.invalid_confirm_password='Invalid confirmation of password';
            etat =false;
          }
          return etat;
        };
    
        const userResetPass = async () => {
          store.clearErrors();
          data.invalid_password="";
          data.invalid_confirm_password="";
          if(!validatePassword()) return;
          try {
            const response = await axios.post('/api/reset_password', {
                'password':data.user.password,
                'confirm_password':data.user.confirm_password,
                'token':token,
            });
            if(response.data.success){
              Swal.fire({
                icon: 'success',
                title: 'Reset password',
                text: response.data.message,
              });
              router.push('/login');
            }
            else {
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