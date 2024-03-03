<template>
    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <router-link to="/dashboard">
					<h3><strong style="color: #F28123;">Super<span style="color: white;">Nova</span> </strong></h3>
				</router-link>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <router-link to="/dashboard">
                                <i class="fas fa-chart-bar"></i>dashboard
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/categories">
                                <i class="fas fa-solid fa-list"></i>Categories
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/products">
                                <i class="fab fa-product-hunt"></i>Products
                            </router-link>
                        </li>
                        
                        
                      
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->
</template>