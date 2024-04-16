<template>

    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<h1>Profile</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

    <!-- contact form -->
	<div class="contact-from-section mt-80 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb-5 mb-lg-0">
					<div class="form-title">
						<h2>Your Personal Informations</h2>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
						<form type="POST" id="fruitkha-contact" onSubmit="return valid_datas( this );">
							<p>
                                <label class="label_form" for="name">Full Name :</label>
								<input type="text" class="ml-3" placeholder="Enter the Full Name" v-model="data.user.name">
							</p>
                            <p>
                                <label class="label_form" for="name">Sexe :</label>
								<input type="radio" class="ml-5" value="male" v-model="data.user.sexe"> Male
								<input type="radio" class="ml-5" value="female" v-model="data.user.sexe"> Female
							</p>
                            <p>
                                <label class="label_form" for="email">Email :</label>
								<input type="text" class="ml-3" placeholder="Enter the Email" v-model="data.user.email">
							</p>
                            <p>
                                <label class="label_form" for="email">Current password :</label>
								<input type="password" class="ml-3" placeholder="Enter the Current password" v-model="data.user.password">
							</p>
                            <p>
                                <label class="label_form" for="email">New password :</label>
								<input type="password" class="ml-3" placeholder="Enter the New password" v-model="data.user.new_password">
							</p>
                            <p>
                                <label class="label_form" for="email">Confirmation password :</label>
								<input type="password" class="ml-3" placeholder="Enter the Confirmation of password" v-model="data.user.confirmation_password">
							</p>
						</form>
					</div>
				</div>
                <div class="col-lg-4">
					<div class="contact-form-wrap">
						<div class="contact-form-box">
							<h4><i class="fas fa-map"></i> Shop Address</h4>
							<p>34/8, East Hukupara <br> Gifirtok, Sadan. <br> Country Name</p>
						</div>
						<div class="contact-form-box">
							<h4><i class="far fa-clock"></i> Shop Hours</h4>
							<p>MON - FRIDAY: 8 to 9 PM <br> SAT - SUN: 10 to 8 PM </p>
						</div>
						<div class="contact-form-box">
							<h4><i class="fas fa-address-book"></i> Contact</h4>
							<p>Phone: +00 111 222 3333 <br> Email: support@fruitkha.com</p>
						</div>
					</div>
				</div>
                <div class="col-lg-8 mb-5 mb-lg-0 mt-5">
					<div class="form-title">
						<h2>Update your address</h2>
					</div>
				 	<div id="form_status"></div>
					<div class="contact-form">
						<form type="POST" id="fruitkha-contact" onSubmit="return valid_datas( this );">
							<p>
                                <label class="label_form" for="address">Address :</label>
                                <textarea name="address" cols="30" rows="10" placeholder="Enter the Address" v-model="data.user.adress"></textarea>
                            </p>
                            <p>
                                <label class="label_form" for="city">City :</label>
								<input type="text" class="ml-3" placeholder="Enter the City" v-model="data.user.city">
							</p>
                            <p>
                                <label class="label_form" for="country">Country :</label>
								<input type="text" class="ml-3" placeholder="Enter the Country" value="Morocco" v-model="data.user.country">
							</p>
                            <p>
                                <label class="label_form" for="tele">Telephone :</label>
								<input type="text" class="ml-3" placeholder="Enter the Number of Telephone (exp:+212 000000000)" value="+212" v-model="data.user.tele">
							</p>
                            <p>
                                <input type="button" class="btn_valider" value="Save" @click="MiseAjour()">
                            </p>
						</form>
					</div>
				</div>
				
			</div>
			<div class="form-title">
				<h2>Your Payment</h2>
			</div>

			<img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">

			<div v-if="!data.loading" class="row">
				<div v-for="payment in data.data_payments" :key="payment.id" class="card" style="width: 18rem;">
					<!-- <img src="..." class="card-img-top" alt="..."> -->
					
					{{ payment.num_order }}
					<div class="card-body">
						<h5 class="card-title">{{ payment.amount }}</h5>
						<p class="card-text"># {{ payment.currency }}</p>
						<router-link :to="{ path: '/Order', query: { num_order: payment.num_order } }">View More</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end contact form -->
</template>

<script setup>
import { reactive,onMounted } from "vue";
import Swal from 'sweetalert2';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { useAuthStore } from '@/stores/useAuthStore.js';

const store = useAuthStore();

const data = reactive({
      user:{
		id:'',
		name:'',
		email:'',
		nickname:'',
		sexe:'',
		adress:'',
		city:'',
		country:'',
		tele:'',
		password:'',
		new_password:'',
	  	confirmation_password:'',
	  },
	  data_payments:[],
	  loading:true,
    });

	const fetch_payments = async () =>{
        data.data_payments=[];
        data.loading = true;
        try {
            const response = await axios.get('/api/payments/'+store.getID);
            if(response.data.exist){
                data.data_payments=response.data.payments;
				console.log(data.data_payments);
            }
                
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Payment...',
                    text: response.data.message,
                    });
            }
        } catch (error) {
            Swal.fire({
                    icon: 'error',
                    title: 'Payment...',
                    text: error,
                });
        }
        finally{
            data.loading=false;
        }
    }

const MiseAjour = async () =>{
	try {
		if(data.user.new_password!=data.user.confirmation_password) {
			Swal.fire({
            icon: 'error',
            title: 'New Password...',
            text: 'Error in Confirmation of password',
          });
		  return;
		}
        const response = await axios.put("/api/profile/update/"+data.user.id,data.user);
        if(response.data.success){
			store.updateUser(response.data.user);
			Swal.fire({
				icon: 'success',
				title: 'Profile...',
				text: response.data.message,
			});
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Profile...',
            text: response.data.message,
          });
        }
      } 
      catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Profile...',
            text: error,
          });
      }
};

onMounted(() => {
	data.user=store.getUser.data;
	fetch_payments();
});

</script>

<style scoped>
.label_form{
margin-left: 10px;
}
</style>