<template>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<!-- <p>Get 24/7 Support</p> -->
						<h1>Login</h1>
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
              Login
            </h4>
            <div style="display: grid;">
                <button @click="authSocial('linkdin')" class="button button--social-login button--linkedin mb-3"><i class="icon fa fa-linkedin"></i>Login With Linkedin</button>
                <button @click="authSocial('google')" class="button button--social-login button--google mb-3"><i class="icon fa fa-google"></i>Login With Google</button>
                <button @click="authSocial('github')" class="button button--social-login button--github mb-3"><i class="icon fa fa-github"></i>Login With Github</button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group mb-3">
              <input 
                type="text" 
                v-model="data.user.email"
                placeholder="Email*" class="form-control">
                <span style="color: red;" v-text="data.invalid_email"></span>
            </div>
            <div class="form-group mb-3">
              <input 
                type="password" 
                v-model="data.user.password"
                placeholder="Password*" class="form-control">
                <span style="color: red;" v-text="data.invalid_password"></span>
            </div>
            <div class="form-group mb-3">
              <router-link to="/forget_password">Forget password ?</router-link>
              
            </div>
            <div class="form-group mb-3 text-center">
              <button @click="userAuth" class="btn btn-primary btn-xl">
                Login
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
        email: '',
        password: ''
      },
      invalid_email:'',
      invalid_password:'',
      emailPattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      passwordPattern: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/,
    });

    const authSocial = async (social) => {
      const response = await axios.get('/api/auth/redirect/'+social);
      if(response.data.success){
        Swal.fire({
            icon: 'success',
            title: 'Authenticate',
            text: response.data.message,
          });
          
        window.location.href = response.data.redirect_url;
        // console.log(response.data.redirect_url);
        // useAuthStore.storeUser(response.data.user);
        // router.push('/home');
      }
      else Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.data.message,
          });
    };

    const validateLogin = () => {
      let etat=true;
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
      data.invalid_email="";
      data.invalid_password="";
      if(!validateLogin()) return;
      try {
        const response = await axios.post('/api/login', data.user);
        if(response.data.success){
          let user_auth=response.data.user;
          store.storeUser(user_auth);
          Swal.fire({
            icon: 'success',
            title: 'Login success',
            text: "Welcome to supernova "+ response.data.user.data.name,
          });
          if(response.data.user.role=='admin') window.location.href = '/dashboard/#/dashboard';
          else router.push('/');

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
@import url("https://fonts.googleapis.com/css?family=Roboto+Slab:400,700");
.breadcrumb-bg {
    background-image: url('../images/back_auth.webp');
}

.button {
  width: auto;
  display: inline-block;
  padding: 0 18px 0 6px;
  border: 0 none;
  border-radius: 5px;
  text-decoration: none;
  transition: all 250ms linear;
}
.button:hover {
  text-decoration: none;
}

.button--social-login {
  width: 50%;
  margin: 0 auto;
  margin-bottom: 12px;
  /* margin-right: 12px; */
  color: white;
  height: 50px;
  line-height: 46px;
  position: relative;
  text-align: left;
}
.button--social-login .icon {
  margin-right: 12px;
  font-size: 24px;
  line-height: 24px;
  width: 42px;
  height: 24px;
  text-align: center;
  display: inline-block;
  position: relative;
  top: 4px;
}
.button--social-login .icon:before {
  display: inline-block;
  width: 40px;
}
.button--social-login .icon:after {
  content: "";
}

.button--facebook {
  background-color: #4b70ab;
  border: 1px solid #3b5988;
}
.button--facebook .icon {
  border-right: 1px solid #3b5988;
}
.button--facebook .icon:after {
  border-right: 1px solid #6b8bbe;
}
.button--facebook:hover {
  background-color: #436499;
}

.button--linkedin {
 
  background-color: #0087be;
  border: 1px solid #00638b;
}
.button--linkedin .icon {
  border-right: 1px solid #00638b;
}
.button--linkedin .icon:after {
  border-right: 1px solid #00abf1;
}
.button--linkedin:hover {
  background-color: #0075a5;
}

.button--google {
   background-color: #e34133;
    border: 1px solid #e34133;
}
.button--google .icon {
  border-right: 1px solid #0f66f1;
}
.button--google .icon:after {
  border-right: 1px solid #6fa4f7;
}
.button--google:hover {
  background-color: #e34133;
}

.button--github {
  background-color: #333;
  border: 1px solid #1a1a1a;
}
.button--github .icon {
  border-right: 1px solid #1a1a1a;
}
.button--github .icon:after {
  border-right: 1px solid #4d4d4d;
}
.button--github:hover {
  background-color: #262626;
}
</style>