<template>
     <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-0">
                <span class="text-muted fw-light">eCommerce /</span><span class="fw-medium"> Add Product</span>
              </h4>

              <div class="app-ecommerce">
                <!-- Add Product -->
                <div
                  class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                  <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1 mt-3">Add a new Product</h4>
                    <p class="text-muted">Orders placed across your store</p>
                  </div>
                  <div class="d-flex align-content-center flex-wrap gap-3">
                    <div class="d-flex gap-3">
                      <button @click="discard()" class="btn btn-label-secondary">Discard</button>
                    </div>
                    <!-- <button v-if="data.action=='store'" @click="store()" type="submit" class="btn btn-primary">Publish product</button>
                    <button v-if="data.action=='update'" @click="update()" type="submit" class="btn btn-primary">Update product</button> -->
                  </div>
                </div>

                <div class="row">
                  <!-- First column-->
                  <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-tile mb-0">Product information</h5>
                      </div>
                      <div class="card-body">
                        <div class="mb-3">
                          <label class="form-label" for="ecommerce-product-name">Title</label>
                          <input
                            type="text"
                            class="form-control"
                            id="ecommerce-product-name"
                            placeholder="Product title"
                            aria-label="Product title" v-model="data.product.title" />
                        </div>
                        <div class="row mb-3">
                          <div class="col">
                            <label class="form-label" for="ecommerce-product-sku">Qte Stock</label>
                            <input
                              type="number"
                              class="form-control"
                              id="ecommerce-product-sku"
                              placeholder="SKU"
                              name="productSku"
                              aria-label="Product SKU" v-model="data.product.qte" />
                          </div>
                          <div class="col">
                            <label class="form-label" for="ecommerce-product-barcode">Reference</label>
                            <input
                              type="text"
                              class="form-control"
                              id="ecommerce-product-barcode"
                              placeholder="0123-4567"
                              name="productBarcode"
                              aria-label="Product barcode" v-model="data.product.reference" />
                          </div>
                        </div>
                        <!-- Description -->
                        <div>
                          <label class="form-label">Description (Optional)</label>
                          <div class="form-control p-0 pt-1">
                            <div class="comment-toolbar border-0 border-bottom">
                              <div class="d-flex justify-content-start">
                                <span class="ql-formats me-0">
                                  <button class="ql-bold"></button>
                                  <button class="ql-italic"></button>
                                  <button class="ql-underline"></button>
                                  <button class="ql-list" value="ordered"></button>
                                  <button class="ql-list" value="bullet"></button>
                                  <button class="ql-link"></button>
                                  <button class="ql-image"></button>
                                </span>
                              </div>
                            </div>
                            <div class="comment-editor border-0 pb-4" id="ecommerce-category-description"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /Product Information -->
                    <!-- Media -->
                    <div class="card mb-4">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 card-title">Media</h5>
                        <a href="javascript:void(0);" class="fw-medium">Add media from URL</a>
                      </div>
                      <div class="card-body">
                        <form action="/upload" class="dropzone needsclick" id="dropzone-basic">
                          <div class="dz-message needsclick">
                            <p class="fs-4 note needsclick pt-3 mb-1">Drag and drop your image here</p>
                            <p class="text-muted d-block fw-normal mb-2">or</p>
                            <span class="note needsclick btn bg-label-primary d-inline" id="btnBrowse"
                              >Browse image</span
                            >
                          </div>
                          <div class="fallback">
                            <input name="file" type="file" />
                          </div>
                        </form>
                      </div>
                    </div>
                    <!-- /Media -->
                    
                    <!-- Inventory -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Inventory</h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <!-- Navigation -->
                          <div class="col-12 col-md-4 mx-auto card-separator">
                            <div class="d-flex justify-content-between flex-column mb-3 mb-md-0 pe-md-3">
                              <ul class="nav nav-align-left nav-pills flex-column">
                                <li class="nav-item">
                                  <button class="nav-link py-2 active" data-bs-toggle="tab" data-bs-target="#restock">
                                    <i class="ti ti-box me-2"></i>
                                    <span class="align-middle">Restock</span>
                                  </button>
                                </li>
                                <li class="nav-item">
                                  <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#shipping">
                                    <i class="ti ti-car me-2"></i>
                                    <span class="align-middle">Shipping</span>
                                  </button>
                                </li>
                                <li class="nav-item">
                                  <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#global-delivery">
                                    <i class="ti ti-world me-2"></i>
                                    <span class="align-middle">Global Delivery</span>
                                  </button>
                                </li>
                                <li class="nav-item">
                                  <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#attributes">
                                    <i class="ti ti-link me-2"></i>
                                    <span class="align-middle">Attributes</span>
                                  </button>
                                </li>
                                <li class="nav-item">
                                  <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#advanced">
                                    <i class="ti ti-lock me-2"></i>
                                    <span class="align-middle">Advanced</span>
                                  </button>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <!-- /Navigation -->
                          <!-- Options -->
                          <div class="col-12 col-md-8 pt-4 pt-md-0">
                            <div class="tab-content p-0 ps-md-3">
                              <!-- Restock Tab -->
                              <div class="tab-pane fade show active" id="restock" role="tabpanel">
                                <h5>Options</h5>
                                <label class="form-label" for="ecommerce-product-stock">Add to Stock</label>
                                <div class="row mb-3 g-3 pe-md-5">
                                  <div class="col-12 col-sm-9">
                                    <input
                                      type="number"
                                      class="form-control"
                                      id="ecommerce-product-stock"
                                      placeholder="Quantity"
                                      name="quantity"
                                      aria-label="Quantity" />
                                  </div>
                                  <div class="col-12 col-sm-3">
                                    <button class="btn btn-primary align-items-center">
                                      <i class="ti ti-check me-2 ti-xs"></i>Confirm
                                    </button>
                                  </div>
                                </div>
                                <div>
                                  <p class="mb-1"><span class="h6">Product in stock now: </span> <span>54</span></p>
                                  <p class="mb-1"><span class="h6">Product in transit: </span> <span>390</span></p>
                                  <p class="mb-1">
                                    <span class="h6">Last time restocked: </span> <span>24th June, 2023</span>
                                  </p>
                                  <p class="mb-1">
                                    <span class="h6">Total stock over lifetime: </span> <span>2430</span>
                                  </p>
                                </div>
                              </div>
                              <!-- Shipping Tab -->
                              <div class="tab-pane fade" id="shipping" role="tabpanel">
                                <h5 class="mb-4">Shipping Type</h5>
                                <div>
                                  <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="shippingType" id="seller" />
                                    <label class="form-check-label" for="seller">
                                      <span class="fw-medium d-block mb-1">Fulfilled by Seller</span>
                                      <small
                                        >You'll be responsible for product delivery.<br />
                                        Any damage or delay during shipping may cost you a Damage fee.</small
                                      >
                                    </label>
                                  </div>
                                  <div class="form-check mb-5">
                                    <input
                                      class="form-check-input"
                                      type="radio"
                                      name="shippingType"
                                      id="companyName"
                                      checked />
                                    <label class="form-check-label" for="companyName">
                                      <span class="fw-medium d-block mb-1"
                                        >Fulfilled by Company name &nbsp;<span
                                          class="badge rounded-2 badge-warning bg-label-warning fs-tiny py-1 border border-warning"
                                          >RECOMMENDED</span
                                        ></span
                                      >
                                      <small
                                        >Your product, Our responsibility.<br />
                                        For a measly fee, we will handle the delivery process for you.</small
                                      >
                                    </label>
                                  </div>
                                  <p class="mb-0">
                                    See our <a href="javascript:void(0);">Delivery terms and conditions</a> for details
                                  </p>
                                </div>
                              </div>
                              <!-- Global Delivery Tab -->
                              <div class="tab-pane fade" id="global-delivery" role="tabpanel">
                                <h5 class="mb-4">Global Delivery</h5>
                                <!-- Worldwide delivery -->
                                <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="globalDel" id="worldwide" />
                                  <label class="form-check-label" for="worldwide">
                                    <span class="fw-medium mb-1 d-block">Worldwide delivery</span>
                                    <small
                                      >Only available with Shipping method:
                                      <a href="javascript:void(0);">Fulfilled by Company name</a></small
                                    >
                                  </label>
                                </div>
                                <!-- Global delivery -->
                                <div class="form-check mb-3">
                                  <input class="form-check-input" type="radio" name="globalDel" checked />
                                  <label class="form-check-label w-75 pe-5" for="country-selected">
                                    <span class="fw-medium d-block mb-1">Selected Countries</span>
                                    <input
                                      type="text"
                                      class="form-control"
                                      placeholder="Type Country name"
                                      id="country-selected" />
                                  </label>
                                </div>
                                <!-- Local delivery -->
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="globalDel" id="local" />
                                  <label class="form-check-label" for="local">
                                    <span class="fw-medium mb-1 d-block">Local delivery</span>
                                    <small
                                      >Deliver to your country of residence :
                                      <a href="javascript:void(0);">Change profile address</a></small
                                    >
                                  </label>
                                </div>
                              </div>
                              <!-- Attributes Tab -->
                              <div class="tab-pane fade" id="attributes" role="tabpanel">
                                <h5 class="mb-4">Attributes</h5>
                                <div>
                                  <!-- Fragile Product -->
                                  <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="fragile" id="fragile" />
                                    <label class="form-check-label" for="fragile">
                                      <span class="fw-medium">Fragile Product</span>
                                    </label>
                                  </div>
                                  <!-- Biodegradable -->
                                  <div class="form-check mb-3">
                                    <input
                                      class="form-check-input"
                                      type="checkbox"
                                      value="biodegradable"
                                      id="biodegradable" />
                                    <label class="form-check-label" for="biodegradable">
                                      <span class="fw-medium">Biodegradable</span>
                                    </label>
                                  </div>
                                  <!-- Frozen Product -->
                                  <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="frozen" checked />
                                    <label class="form-check-label w-75 pe-5" for="frozen">
                                      <span class="fw-medium mb-1 d-block">Frozen Product</span>
                                      <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Max. allowed Temperature"
                                        id="frozen" />
                                    </label>
                                  </div>
                                  <!-- Exp Date -->
                                  <div class="form-check mb-4">
                                    <input
                                      class="form-check-input"
                                      type="checkbox"
                                      value="expDate"
                                      id="expDate"
                                      checked />
                                    <label class="form-check-label w-75 pe-5" for="date-input">
                                      <span class="fw-medium mb-1 d-block">Expiry Date of Product</span>
                                      <input type="date" class="product-date form-control" id="date-input" />
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <!-- /Attributes Tab -->
                              <!-- Advanced Tab -->
                              <div class="tab-pane fade" id="advanced" role="tabpanel">
                                <h5 class="mb-4">Advanced</h5>
                                <div class="row">
                                  <!-- Product Id Type -->
                                  <div class="col">
                                    <label class="form-label" for="product-id">
                                      <span class="mb-1 h6">Product ID Type</span>
                                    </label>
                                    <select id="product-id" class="select2 form-select" data-placeholder="ISBN">
                                      <option value="">ISBN</option>
                                      <option value="ISBN">ISBN</option>
                                      <option value="UPC">UPC</option>
                                      <option value="EAN">EAN</option>
                                      <option value="JAN">JAN</option>
                                    </select>
                                  </div>
                                  <!-- Product Id -->
                                  <div class="col">
                                    <label class="form-label" for="product-id-1">
                                      <span class="mb-1 h6">Product ID</span>
                                    </label>
                                    <input
                                      type="number"
                                      id="product-id-1"
                                      class="form-control"
                                      placeholder="ISBN Number" />
                                  </div>
                                </div>
                              </div>
                              <!-- /Advanced Tab -->
                            </div>
                          </div>
                          <!-- /Options-->
                        </div>
                      </div>
                    </div>
                    <!-- /Inventory -->
                  </div>
                  <!-- /Second column -->

                  <!-- Second column -->
                  <div class="col-12 col-lg-4">
                    <!-- Pricing Card -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Pricing</h5>
                      </div>
                      <div class="card-body">
                        <!-- Base Price -->
                        <div class="mb-3">
                          <label class="form-label" for="ecommerce-product-price">Base Price</label>
                          <input
                            type="number"
                            class="form-control"
                            id="ecommerce-product-price"
                            placeholder="Price"
                            name="productPrice"
                            aria-label="Product price" v-model="data.product.price" />
                        </div>
                        <!-- Discounted Price -->
                        <div class="mb-3">
                          <label class="form-label" for="ecommerce-product-discount-price">Discounted Price</label>
                          <input
                            type="number"
                            class="form-control"
                            id="ecommerce-product-discount-price"
                            placeholder="Discounted Price"
                            name="productDiscountedPrice"
                            aria-label="Product discounted price" v-model="data.product.discounted_price" />
                        </div>
                      
                        <!-- Instock switch -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                          <h6 class="mb-0">In stock</h6>
                          <div class="w-25 d-flex justify-content-end">
                            <label class="switch switch-primary switch-sm me-4 pe-2">
                              <input type="checkbox" class="switch-input" checked="" v-model="data.product.status" />
                              <span class="switch-toggle-slider">
                                <span class="switch-on">
                                  <span class="switch-off"></span>
                                </span>
                              </span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /Pricing Card -->
                    <!-- Organize Card -->
                    <div class="card mb-4">
                      <div class="card-header">
                        <h5 class="card-title mb-0">Organize</h5>
                      </div>
                      <div class="card-body">
                        <!-- Category -->
                        <div class="mb-3 col ecommerce-select2-dropdown">
                          <label class="form-label mb-1" for="vendor"> Categories </label>
                          <select id="vendor" class="select2 form-select" @change="selectCategory()" data-placeholder="Select Vendor">
                              <option value="">Select</option>
                              <option v-for="category in data.data_categories" :value="category.id">{{ category.name }}</option>
                          </select>
                        </div>
                        <!-- Category -->
                        <div class="mb-3 col ecommerce-select2-dropdown">
                          <label class="form-label mb-1" for="vendor">Sub Categories </label>
                          <select id="vendor" class="select2 form-select" v-model="data.product.id_sub_catg" data-placeholder="Select Vendor">
                              <option value="">Select</option>
                              <option v-for="sub_category in data.data_sub_categories" :value="sub_category.id">{{ sub_category.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <!-- /Organize Card -->
                  </div>
                  <!-- /Second column -->
                </div>
              </div>
            </div>
</template>

<script setup>
    import { reactive,onMounted } from "vue";
    import Swal from 'sweetalert2';
    import router from '@/router';
    import { useAuthStore } from '@/stores/useAuthStore.js';

    const store = useAuthStore();
    
    const data = reactive({
      data_categories: [],
      data_sub_categories: [],
      product: {
        id: '',
        title: '',
        description: '',
        price: '',
        discounted_price: '',
        reference: '',
        image: '',
        qte: '',
        qte_dispo: '',
        id_sub_catg: '',
        status: '',
      },
      action:'',
    });

    const fetch_data = async () => {
      data.data_categories=[];
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
    };

    const selectCategory = async (category_id) => {
      alert(category_id);
      // data.data_sub_categories= [];
      // try {
      //   const response = await axios.get('/api/category/sub_categories/'+category_id);
      //   if(response.data.success){
      //     data.data_sub_categories=response.data.sub_categories;
      //   } 
      //   else {
      //     Swal.fire({
      //         icon: 'error',
      //         title: 'Sub Categories...',
      //         text: response.data.message,
      //       });
      //   }
      // } catch (error) {
      //     Swal.fire({
      //           icon: 'error',
      //           title: 'Sub Categories...',
      //           text: error,
      //         });
      // }
    };

    const discard = async () =>{
      data.product.id="";
      data.product.title="";
      data.product.description="";
      data.product.price="";
      data.product.discounted_price="";
      data.product.reference="";
      data.product.image="";
      data.product.qte="";
      data.product.qte_dispo="";
      data.product.id_sub_catg="";
    }
    onMounted(fetch_data);
</script>

<style>
</style>