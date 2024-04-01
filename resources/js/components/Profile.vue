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
								<input type="text" class="ml-3" placeholder="Enter the Full Name">
							</p>
                            <p>
                                <label class="label_form" for="name">Sexe :</label>
								<input type="radio" class="ml-5" value="male"> Male
								<input type="radio" class="ml-5" value="female"> Female
							</p>
                            <p>
                                <label class="label_form" for="email">Email :</label>
								<input type="text" class="ml-3" placeholder="Enter the Email">
							</p>
                            <p>
                                <label class="label_form" for="email">Current password :</label>
								<input type="password" class="ml-3" placeholder="Enter the Current password">
							</p>
                            <p>
                                <label class="label_form" for="email">New password :</label>
								<input type="password" class="ml-3" placeholder="Enter the New password">
							</p>
                            <p>
                                <label class="label_form" for="email">Confirmation password :</label>
								<input type="password" class="ml-3" placeholder="Enter the Confirmation of password">
							</p>
                            <!-- <p>
                                <input type="submit" value="Submit">
                            </p>
							 -->
							<!-- <input type="hidden" name="token" value="FsWga4&@f6aw" /> -->
							
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
                                <textarea name="address" cols="30" rows="10" placeholder="Enter the Address"></textarea>
                            </p>
                            <p>
                                <label class="label_form" for="city">City :</label>
								<input type="text" class="ml-3" placeholder="Enter the City">
							</p>
                            <p>
                                <label class="label_form" for="country">Country :</label>
								<input type="text" class="ml-3" placeholder="Enter the Country" value="Morocco">
							</p>
                            <p>
                                <label class="label_form" for="tele">Telephone :</label>
								<input type="text" class="ml-3" placeholder="Enter the Number of Telephone (exp:+212 000000000)" value="+212">
							</p>
                            <p>
                                <input type="submit" value="Save">
                            </p>
						</form>
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

const data = reactive({
    //   data_orders: [],
    //   loading:true,
      action:'',
    });

</script>

<style scoped>
.label_form{
margin-left: 10px;
}
</style>