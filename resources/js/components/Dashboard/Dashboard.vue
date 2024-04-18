<template>
    <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <!-- View sales -->
                <div class="col-xl-4 mb-4 col-lg-5 col-12">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-7">
                        <div class="card-body text-nowrap">
                          <h5 class="card-title mb-0">Congratulations SuperNova! 🎉</h5>
                          <p class="mb-2">The profit of the month</p>
                          <h4 class="text-primary mb-1">${{ data.statistics.profit_month }}</h4>
                          <a href="javascript:;" class="btn btn-primary">View Sales</a>
                        </div>
                      </div>
                      <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            :src="`/assets_dashboard/img/illustrations/card-advance-sale.png`"
                            height="140"
                            alt="view sales" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- View sales -->

                <!-- Statistics -->
                <div class="col-xl-8 mb-4 col-lg-7 col-12">
                  <div class="card h-100">
                    <div class="card-header">
                      <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">Statistics</h5>
                        <small class="text-muted">Updated 1 month ago</small>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row gy-3">
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-primary me-3 p-2">
                              <i class="ti ti-chart-pie-2 ti-sm"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">{{ data.statistics.sales }}</h5>
                              <small>Sales</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-info me-3 p-2">
                              <i class="ti ti-users ti-sm"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">{{ data.statistics.costumers }}</h5>
                              <small>Customers</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-danger me-3 p-2">
                              <i class="ti ti-shopping-cart ti-sm"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">1.423k</h5>
                              <small>Products</small>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3 col-6">
                          <div class="d-flex align-items-center">
                            <div class="badge rounded-pill bg-label-success me-3 p-2">
                              <i class="ti ti-currency-dollar ti-sm"></i>
                            </div>
                            <div class="card-info">
                              <h5 class="mb-0">${{ data.statistics.revenue }}</h5>
                              <small>Revenue</small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Statistics -->


                <!-- Popular Product -->
                <div class="col-md-6 col-xl-4 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Popular Products</h5>
                      </div>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                        <li v-for="product in data.propulars" :key="product.id" class="d-flex mb-4 pb-1">
                          <div class="me-3">
                            <img :src="`/images/products/${product.image}`" class="rounded" width="46">
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">{{ product.title }}</h6>
                              <small class="text-muted d-block">{{ product.sub_category.name }}</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <p class="mb-0 fw-medium">${{ product.price }}</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Popular Product -->

                <!-- Transactions -->
                <div class="col-md-6 col-xl-4 mb-4">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Transactions</h5>
                        <small class="text-muted">Total 58 Transactions done in this Month</small>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn p-0"
                          type="button"
                          id="transactionID"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                          <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                          <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-primary me-3 rounded p-2">
                            <i class="ti ti-wallet ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Wallet</h6>
                              <small class="text-muted d-block">Starbucks</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-danger">-$75</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-success rounded me-3 p-2">
                            <i class="ti ti-browser-check ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Bank Transfer</h6>
                              <small class="text-muted d-block">Add Money</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-success">+$480</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-danger rounded me-3 p-2">
                            <i class="ti ti-brand-paypal ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Paypal</h6>
                              <small class="text-muted d-block mb-1">Client Payment</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-success">+$268</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-secondary me-3 rounded p-2">
                            <i class="ti ti-credit-card ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Master Card</h6>
                              <small class="text-muted d-block mb-1">Ordered iPhone 13</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-danger">-$699</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-info me-3 rounded p-2">
                            <i class="ti ti-currency-dollar ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Bank Transactions</h6>
                              <small class="text-muted d-block mb-1">Refund</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-success">+$98</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex mb-3 pb-1 align-items-center">
                          <div class="badge bg-label-danger me-3 rounded p-2">
                            <i class="ti ti-brand-paypal ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Paypal</h6>
                              <small class="text-muted d-block mb-1">Client Payment</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-success">+$126</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center">
                          <div class="badge bg-label-success me-3 rounded p-2">
                            <i class="ti ti-browser-check ti-sm"></i>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Bank Transfer</h6>
                              <small class="text-muted d-block mb-1">Pay Office Rent</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                              <h6 class="mb-0 text-danger">-$1290</h6>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Transactions -->

              </div>
    </div>
 </template>
 
<script setup>
import { reactive,onMounted } from "vue";
import Swal from 'sweetalert2';
import { useAuthStore } from '@/stores/useAuthStore.js';
import axios from "axios";

const store = useAuthStore();

	const data = reactive({
		statistics: {
      profit_month:'',
      sales:'',
      costumers:'',
      count_products:'',
      revenue:'',
    },
    propulars:[],
    transactions:[],
	});

  const getStatistics= async () =>{
    try {
      const response = await axios.get('/api/statistics');
      if(response.data.success){
        data.statistics=response.data.statistics;
        data.propulars=response.data.propulars;
        data.transactions=response.data.transactions;
      }
      else {
        Swal.fire({
                icon: 'error',
                title: 'Statistics...',
                text: error,
              });
      }
    } catch (error) {
      Swal.fire({
                icon: 'error',
                title: 'Statistics...',
                text: error,
              });
    }
  }

  onMounted(getStatistics);

</script>

<style scoped>

</style>
 