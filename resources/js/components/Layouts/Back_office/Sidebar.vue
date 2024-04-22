<template>
   <!-- Menu -->
   <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <!-- <a href="index.html" class="app-brand-link"> -->
              <h3 style="margin-top: 14px;"><strong style="color: #F28123;">Super<span style="color: #051922;">Nova</span> </strong></h3>
            <!-- </a> -->

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            
            <li class="menu-item">
              <router-link to="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons fa fa-tachometer" aria-hidden="true"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </router-link>
            </li>
            <li class="menu-item">
              <router-link to="/categories" class="menu-link">
                <i class="menu-icon tf-icons fa fa-list" aria-hidden="true"></i>
                <div data-i18n="Categories">Categories</div>
              </router-link>
            </li>
            <li class="menu-item">
              <router-link to="/sub_categories" class="menu-link">
                <i class="menu-icon tf-icons fa fa-bars" aria-hidden="true"></i>
                <div data-i18n="Sub Categories">Sub categories</div>
              </router-link>
            </li>
            <li class="menu-item">
              <router-link to="/products" class="menu-link">
                <i class="menu-icon tf-icons fa fa-product-hunt" aria-hidden="true"></i>
                <div data-i18n="Products">Products</div>
              </router-link>
            </li>
            <li class="menu-item">
              <router-link to="/Back/payments" class="menu-link">
                <i class="menu-icon tf-icons fa fa-shopping-cart" aria-hidden="true"></i>
                <div data-i18n="Payments">Payments</div>
              </router-link>
            </li>
            <li class="menu-item">
              <router-link to="/Coupons" class="menu-link">
                <i class="menu-icon tf-icons fa fa-window-maximize" aria-hidden="true"></i>
                <div data-i18n="Coupons">Coupons</div>
              </router-link>
            </li>
           
            <!-- e-commerce-app menu start -->
            <!-- <li class="menu-item active open">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div data-i18n="eCommerce">eCommerce</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item active">
                  <a href="app-ecommerce-dashboard.html" class="menu-link">
                    <div data-i18n="Dashboard">Dashboard</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="Products">Products</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="app-ecommerce-product-list.html" class="menu-link">
                        <div data-i18n="Product List">Product List</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-product-add.html" class="menu-link">
                        <div data-i18n="Add Product">Add Product</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-category-list.html" class="menu-link">
                        <div data-i18n="Category List">Category List</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="Order">Order</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="app-ecommerce-order-list.html" class="menu-link">
                        <div data-i18n="Order List">Order List</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-order-details.html" class="menu-link">
                        <div data-i18n="Order Details">Order Details</div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="Customer">Customer</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="app-ecommerce-customer-all.html" class="menu-link">
                        <div data-i18n="All Customers">All Customers</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Customer Details">Customer Details</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item">
                          <a href="app-ecommerce-customer-details-overview.html" class="menu-link">
                            <div data-i18n="Overview">Overview</div>
                          </a>
                        </li>
                        <li class="menu-item">
                          <a href="app-ecommerce-customer-details-security.html" class="menu-link">
                            <div data-i18n="Security">Security</div>
                          </a>
                        </li>
                        <li class="menu-item">
                          <a href="app-ecommerce-customer-details-billing.html" class="menu-link">
                            <div data-i18n="Address & Billing">Address & Billing</div>
                          </a>
                        </li>
                        <li class="menu-item">
                          <a href="app-ecommerce-customer-details-notifications.html" class="menu-link">
                            <div data-i18n="Notifications">Notifications</div>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li class="menu-item">
                  <a href="app-ecommerce-manage-reviews.html" class="menu-link">
                    <div data-i18n="Manage Reviews">Manage Reviews</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-ecommerce-referral.html" class="menu-link">
                    <div data-i18n="Referrals">Referrals</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <div data-i18n="Settings">Settings</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-detail.html" class="menu-link">
                        <div data-i18n="Store Details">Store Details</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-payments.html" class="menu-link">
                        <div data-i18n="Payments">Payments</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-checkout.html" class="menu-link">
                        <div data-i18n="Checkout">Checkout</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-shipping.html" class="menu-link">
                        <div data-i18n="Shipping & Delivery">Shipping & Delivery</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-locations.html" class="menu-link">
                        <div data-i18n="Locations">Locations</div>
                      </a>
                    </li>
                    <li class="menu-item">
                      <a href="app-ecommerce-settings-notifications.html" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li> -->
            <!-- e-commerce-app menu end -->

          </ul>
    </aside>
    <!-- / Menu -->
</template>
<style scoped>
.menu-vertical .menu-inner{
  background-color: #051922;
}
.menu-vertical .menu-inner > .menu-item .menu-link{
  color: white;
}
html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item:not(.active) > .menu-link:hover, .layout-menu-hover.layout-menu-collapsed .bg-menu-theme .menu-inner .menu-item:not(.active) > .menu-link:hover{
  background: #bf7422;
}
.menu-icon{
  font-size: 18px;
}
</style>