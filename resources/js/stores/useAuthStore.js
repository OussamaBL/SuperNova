import { defineStore } from 'pinia';


export const useAuthStore = defineStore('auth', {
    state: () => ({ 
        user: '',
        errors: '',
        count_wishlist:null,
        count_cart:null,
    }),
    getters: {
        getUser: (state) => state.user,
        getName: (state) => state.user.data.name,
        getID: (state) => state.user.data.id,
        getRole: (state) => state.user.role,
        getCount_wishlist: (state) => state.count_wishlist,
        getCount_cart: (state) => state.count_cart,
        getErrors: (state) => state.errors,
        getHeaderConfig(state) {
            const config = {
                headers: {
                    "Authorization" : `Bearer ${state.user.currentToken}`,
                    "Accept": "application/json",
                }
            }  
            return config;
        }
    },
    actions: {
        setUser() {
            if (localStorage.getItem('user')) {
                this.user = JSON.parse(localStorage.getItem('user'));
            }
        },
        storeUser(user) {
            localStorage.setItem('user', JSON.stringify(user));
            this.user = user;
        },
        updateUser(user) {
            if (localStorage.getItem('user')) {
                const storedData = JSON.parse(localStorage.getItem('user'));
                storedData.data = user;
                localStorage.setItem('user', JSON.stringify(storedData));
                this.user.data = user;
            }
        },
        clearStoredData() {
            localStorage.removeItem('user');
            this.user = '';
            this.count_wishlist=null;
            this.count_cart=null;
        },
        setErrors(errors) {
            this.errors = errors;
        },
        clearErrors() {
            this.errors = '';
        },

        // wishlist
        store_count_wishlist(count){
            this.count_wishlist=count;
        },
        add_wishlist(){
            this.count_wishlist++;
        },
        remove_wishlist(){
            this.count_wishlist--;
        },

        // cart
        store_count_cart(count){
            this.count_cart=count;
        },
        add_cart(){
            this.count_cart++;
        },
        remove_cart(){
            this.count_cart--;
        }
    },
});