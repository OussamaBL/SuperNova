import Swal from 'sweetalert2';
import axios from 'axios';
import router from '@/router/index.js';

export const addProduct_Cart = async (product_id, product_title,store) => {
    try {
        const result = await Swal.fire({
            title: 'Confirm addition',
            text: `Are you sure you want to add the product '${product_title}' in the cart ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel',
        });

        if (result.isConfirmed) {
            const response = await axios.post("/api/products/cart/store", { 
                user_id: store.getID,
                product_id: product_id
            });

            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Cart...',
                    text: response.data.message,
                });
                store.add_cart();
                router.push('/Cart');
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Cart...',
                    text: response.data.message,
                });
            }
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Cart...',
            text: error,
        });
    }
};

export const removeProduct_Cart = async (cart_id, product_title,store) => {
    try {
        const result = await Swal.fire({
            title: 'Confirm Delete',
            text: `Are you sure you want to delete the product '${product_title}' from the cart ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        });

        if (result.isConfirmed) {
            const response = await axios.delete("/api/products/cart/destroy/" + cart_id);
            if (response.data.success) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Cart...',
                    text: response.data.message,
                });
                store.remove_cart();
                router.push('/Cart');
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Cart...',
                    text: response.data.message,
                });
            }
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Cart...',
            text: error,
        });
    }
};