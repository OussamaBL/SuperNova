import Swal from 'sweetalert2';
import axios from 'axios';
import router from '@/router/index.js';

export const addProduct_Wishlist = async (product_id, product_title,store) => {
    try {
        const result = await Swal.fire({
            title: 'Confirm addition',
            text: `Are you sure you want to add the product '${product_title}' in the wishlist ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel',
        });

        if (result.isConfirmed) {
            const response = await axios.post("/api/products/wishlist/store", { 
                user_id: store.getID,
                prod_id: product_id
            });

            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Wishlist...',
                    text: response.data.message,
                });
                store.add_wishlist();
                router.push('/Wishlist');
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Wishlist...',
                    text: response.data.message,
                });
            }
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Products...',
            text: error,
        });
    }
};

export const removeProduct_Wishlist = async (wishlist_id, product_title,store) => {
    try {
        const result = await Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the product '${product_title}' from the wishlist ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        });

        if (result.isConfirmed) {
            const response = await axios.delete("/api/products/wishlist/destroy/" + wishlist_id);
            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Wishlist...',
                    text: response.data.message,
                });
                router.push('/Wishlist');
                store.remove_wishlist();
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Wishlist...',
                    text: response.data.message,
                });
            }
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Products...',
            text: error,
        });
    }
};