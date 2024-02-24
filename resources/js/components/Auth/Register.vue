<template>

    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <div class="breadcrumb-text">
                            <h1>Sign up</h1>
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
                  Register
                </h4>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <input 
                    type="text" 
                    v-model="data.user.name"
                    placeholder="Name*" class="form-control" required>
                    <span style="color: red;" v-text="data.invalid_name"></span>
                </div>
                <div class="form-group mb-3">
                  <input 
                    type="text" 
                    v-model="data.user.email"
                    placeholder="Email*" class="form-control" required>
                    <span style="color: red;" v-text="data.invalid_email"></span>
                </div>
                <div class="form-group mb-3">
                  <input 
                    type="password" 
                    v-model="data.user.password"
                    placeholder="Password*" class="form-control" required>
                    <span style="color: red;" v-text="data.invalid_password"></span>
                </div>
                <div class="form-group mb-3 text-center">
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
        },
        invalid_name:'',
        invalid_email:'',
        invalid_password:'',
        namePattern: /^[A-Za-z\s'-]+$/,
        emailPattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        passwordPattern: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/,
      });
    

    const validateRegister = () => {
      let etat=true;
      if (!data.namePattern.test(data.user.name)) {
        data.invalid_name='Invalid Name';
        etat =false;
      } 
      if (!data.emailPattern.test(data.user.email)) {
        data.invalid_email='Invalid Email';
        etat =false;
      } 
      if (!data.passwordPattern.test(data.user.password)) {
        data.invalid_password='Invalid Password';
        etat= false;
      } 
      return etat;
    };
    
      const userAuth = async () => {
        store.clearErrors();
        data.invalid_name="";
        data.invalid_email="";
        data.invalid_password="";
        if(!validateRegister()) return;
        try {
          const response = await axios.post('/api/register', data.user);
          if(response.data.success){
            let user_auth=response.data.user;
            store.storeUser(user_auth);
            Swal.fire({
              icon: 'success',
              title: 'Sign up success',
              text: "Welcome to supernova "+ response.data.user.data.name,
            });
            router.push('/');
          }
          else{
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