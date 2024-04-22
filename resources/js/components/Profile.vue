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

			<div class="form-title mt-5">
				<h2>Your Payment</h2>
			</div>
			<img v-if="data.loading" src="@/images/loading.gif" style="width: 40px;margin: 20px auto;display: block;" alt="Loading">

			<div v-if="!data.loading" class="row">
				<div class="ag-format-container">
					<div class="ag-courses_box">
						<div v-for="payment in data.data_payments" :key="payment.id" class="ag-courses_item">
							<router-link :to="{ path: '/Order', query: { num_order: payment.num_order,amount:payment.amount } }" class="ag-courses-item_link">
								<div class="ag-courses-item_bg"></div>
								<div class="ag-courses-item_title">
									<p style="font-size: 17px;width: 286px;overflow: hidden;">{{ payment.num_order }}</p>
									<p style="font-weight: 900;font-size: 21px;">${{ payment.amount }}</p>
									<p>{{ payment.payment_method }}</p>
								</div>
								<div class="ag-courses-item_date-box">
									Date:
									<span class="ag-courses-item_date">
										{{ payment.created_at_formatted }}
									</span>
								</div>
							</router-link>
						</div>
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
                data.data_payments=response.data.payments.map(payment => ({...payment,
        				created_at_formatted: new Date(payment.created_at).toISOString().split('T')[0]
      				}));
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

.ag-format-container {
  width: 1142px;
  margin: 0 auto;
}


.ag-courses_box {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;

  padding: 0px 0;
}
.ag-courses_item {
  -ms-flex-preferred-size: calc(33.33333% - 30px);
  flex-basis: calc(33.33333% - 30px);

  margin: 0 15px 30px;

  overflow: hidden;

  border-radius: 28px;
}
.ag-courses-item_link {
  display: block;
  padding: 30px 20px;
  background-color: #121212;

  overflow: hidden;

  position: relative;
}
.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
  text-decoration: none;
  color: #FFF;
}
.ag-courses-item_link:hover .ag-courses-item_bg {
  -webkit-transform: scale(10);
  -ms-transform: scale(10);
  transform: scale(10);
}
.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_title p{
	color: white;
}
.ag-courses-item_date-box {
  font-size: 18px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date {
  font-weight: bold;
  color: #f9b234;

  -webkit-transition: color .5s ease;
  -o-transition: color .5s ease;
  transition: color .5s ease
}
.ag-courses-item_bg {
  height: 128px;
  width: 128px;
  background-color: #f9b234;

  z-index: 1;
  position: absolute;
  top: -75px;
  right: -75px;

  border-radius: 50%;

  -webkit-transition: all .5s ease;
  -o-transition: all .5s ease;
  transition: all .5s ease;
}
.ag-courses_item:nth-child(2n) .ag-courses-item_bg {
  background-color: #3ecd5e;
}
.ag-courses_item:nth-child(3n) .ag-courses-item_bg {
  background-color: #e44002;
}
.ag-courses_item:nth-child(4n) .ag-courses-item_bg {
  background-color: #952aff;
}
.ag-courses_item:nth-child(5n) .ag-courses-item_bg {
  background-color: #cd3e94;
}
.ag-courses_item:nth-child(6n) .ag-courses-item_bg {
  background-color: #4c49ea;
}



@media only screen and (max-width: 979px) {
  .ag-courses_item {
    -ms-flex-preferred-size: calc(50% - 30px);
    flex-basis: calc(50% - 30px);
  }
  .ag-courses-item_title {
    font-size: 24px;
  }
}

@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}
@media only screen and (max-width: 639px) {
  .ag-courses_item {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
  }
  .ag-courses-item_title {
    min-height: 72px;
    line-height: 1;

    font-size: 24px;
  }
  .ag-courses-item_link {
    padding: 22px 40px;
  }
  .ag-courses-item_date-box {
    font-size: 16px;
  }
}
</style>