// Select DOM elements
const showModalBtn = document.querySelector(".show-modal");
const bottomSheet = document.querySelector(".bottom-sheet");
const sheetOverlay = bottomSheet.querySelector(".sheet-overlay");
const sheetContent = bottomSheet.querySelector(".content");
const dragIcon = bottomSheet.querySelector(".drag-icon");

// Global variables for tracking drag events
let isDragging = false, startY, startHeight;

// Show the bottom sheet, hide body vertical scrollbar, and call updateSheetHeight
const showBottomSheet = () => {
    bottomSheet.classList.add("show");
    // document.body.style.overflowY = "hidden";
    updateSheetHeight(50);
}

const updateSheetHeight = (height) => {
    sheetContent.style.height = `${height}vh`; //updates the height of the sheet content
    // Toggles the fullscreen class to bottomSheet if the height is equal to 100
    bottomSheet.classList.toggle("fullscreen", height === 100);
}

// Hide the bottom sheet and show body vertical scrollbar
const hideBottomSheet = () => {
    bottomSheet.classList.remove("show");
    document.body.style.overflowY = "auto";
}

// Sets initial drag position, sheetContent height and add dragging class to the bottom sheet
const dragStart = (e) => {
    isDragging = true;
    startY = e.pageY || e.touches?.[0].pageY;
    startHeight = parseInt(sheetContent.style.height);
    bottomSheet.classList.add("dragging");
}

// Calculates the new height for the sheet content and call the updateSheetHeight function
const dragging = (e) => {
    if(!isDragging) return;
    const delta = startY - (e.pageY || e.touches?.[0].pageY);
    const newHeight = startHeight + delta / window.innerHeight * 100;
    updateSheetHeight(newHeight);
}

// Determines whether to hide, set to fullscreen, or set to default 
// height based on the current height of the sheet content
const dragStop = () => {
    isDragging = false;
    bottomSheet.classList.remove("dragging");
    const sheetHeight = parseInt(sheetContent.style.height);
    sheetHeight < 25 ? hideBottomSheet() : sheetHeight > 75 ? updateSheetHeight(100) : updateSheetHeight(50);
}

dragIcon.addEventListener("mousedown", dragStart);
document.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);

dragIcon.addEventListener("touchstart", dragStart);
document.addEventListener("touchmove", dragging);
document.addEventListener("touchend", dragStop);

sheetOverlay.addEventListener("click", hideBottomSheet);
showModalBtn.addEventListener("click", showBottomSheet);

    // document.addEventListener('DOMContentLoaded', function() {
    //     const cartButtons = document.querySelectorAll('.cart-btn');
    //     const iconCart = document.querySelector('.icon-cart');
        
    //     cartButtons.forEach(button => {
    //         button.addEventListener('click', function(e) {
    //             e.preventDefault(); 
    //             const productId = this.getAttribute('data-product-id');
                
    //             // Simulate adding to cart and showing the cart icon
    //             if (iconCart) {
    //                 iconCart.style.display = 'flex'; // Show the cart icon
    //             }
                
    //         });
    //     });
    // });

//ini untuk fungsi memasukkan data product ke cart
function getData() {
    const iconCart = document.querySelector('.icon-cart');
    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    if (Object.keys(cart).length === 0) {
        document.getElementById('cart').innerHTML = '<p>Keranjang Anda Kosong</p>';
        document.getElementById('count-cart').innerHTML = 0;
        document.getElementById('total-price').innerHTML = 'Rp.0';
        iconCart.style.display = 'none'; // Hide the cart icon
        hideBottomSheet();
    } else {
        let totalPrice = 0;
        document.getElementById('count-cart').innerHTML = Object.keys(cart).length;
        document.getElementById('cart').innerHTML = '';
        iconCart.style.display = 'flex'; // Show the cart icon
        for (let key in cart) {
            let itemTotal = cart[key].price * cart[key].quantity;
            totalPrice += itemTotal;
            document.getElementById('cart').innerHTML += `
              <div class="cart-item rounded-3xl border-2 border-gray-200 p-4 lg:p-8 grid grid-cols-12 mb-8 max-lg:max-w-lg max-lg:mx-auto gap-y-4">
                    <div class="col-span-12 lg:col-span-2 img box">
                        <img src="${cart[key].photo}" alt="${cart[key].name}" class="max-lg:w-full lg:w-[180px] rounded-lg">
                    </div>
                    <div class="col-span-12 lg:col-span-10 detail w-full lg:pl-3">
                        <div class="flex items-center justify-between w-full mb-4">
                            <h5 class="font-manrope font-bold text-2xl leading-9 text-gray-900">${cart[key].name}</h5>
                            <a href="javascript:void(0)" class="remove" data-remove-id="${key}">
                                <button class="rounded-full group flex items-center justify-center focus-within:outline-red-500">
                                    <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-red-50 transition-all duration-500 group-hover:fill-red-400" cx="17" cy="17" r="17" fill="" />
                                        <path class="stroke-red-500 transition-all duration-500 group-hover:stroke-white"
                                            d="M14.1673 13.5997V12.5923C14.1673 11.8968 14.7311 11.333 15.4266 11.333H18.5747C19.2702 11.333 19.834 11.8968 19.834 12.5923V13.5997M19.834 13.5997C19.834 13.5997 14.6534 13.5997 11.334 13.5997C6.90804 13.5998 27.0933 13.5998 22.6673 13.5997C21.5608 13.5997 19.834 13.5997 19.834 13.5997ZM12.4673 13.5997H21.534V18.8886C21.534 20.6695 21.534 21.5599 20.9807 22.1131C20.4275 22.6664 19.5371 22.6664 17.7562 22.6664H16.2451C14.4642 22.6664 13.5738 22.6664 13.0206 22.1131C12.4673 21.5599 12.4673 20.6695 12.4673 18.8886V13.5997Z"
                                            stroke="#EF4444" stroke-width="1.6" stroke-linecap="round" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <p class="font-normal text-base leading-7 text-gray-500 mb-6">
                            ${cart[key].slug} <a href="javascript:;" class="text-indigo-600"></a>
                        </p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <a href="javascript:void(0)" class="decrement" data-decrement-id="${key}">
                                    <button class="group rounded-[50px] border border-gray-200 shadow-sm shadow-transparent p-2.5 flex items-center justify-center bg-white transition-all duration-500 hover:shadow-gray-200 hover:bg-gray-50 hover:border-gray-300 focus-within:outline-gray-300">
                                        <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.5 9.5H13.5" stroke="" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </a>
                                <input type="text" id="number" class="border border-gray-200 rounded-full w-10 aspect-square outline-none text-gray-900 font-semibold text-sm py-1.5 px-3 bg-gray-100 text-center" placeholder="${cart[key].quantity}">
                                <a href="javascript:void(0)" class="increment" data-increment-id="${key}">
                                    <button class="group rounded-[50px] border border-gray-200 shadow-sm shadow-transparent p-2.5 flex items-center justify-center bg-white transition-all duration-500 hover:shadow-gray-200 hover:bg-gray-50 hover:border-gray-300 focus-within:outline-gray-300">
                                        <svg class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black" width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.75 9.5H14.25M9 14.75V4.25" stroke="" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </div>
                            <h6 class="price text-indigo-600 font-manrope font-bold text-lg leading-9 text-right">Rp ${itemTotal.toLocaleString('id-ID')}</h6>

                    </div>
                </div>`;
        }
        document.getElementById('total-price').innerHTML = 'Rp.' + totalPrice.toLocaleString('id-ID');
    }
}

function sendCartDataToServer() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    console.log('Sending cart data to server:', cart);
    axios.post('/save-cart', {
        cartItems: cart
    })
    .then(response => {
        console.log(response.data);
        with('Cart items saved successfully');
        window.location.href = "/checkout"
    })
    .catch(error => {
        console.log(error.response.data);
    });
}


$(function() {
    getData();
});

$(document).ready(function() {
    // cart buttons
    $(document).on('click', '.cart-btn', function() {
        let productId = $(this).data('product-id');
        let storeId = $(this).data('store-id'); // Ambil store_id dari data atribut
        let categoryId = $(this).data('category-id'); // Ambil category_id dari data atribut
        let slug = $(this).data('slug'); // Ambil slug dari data atribut
        
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                product_id: productId,
                store_id: storeId, // Sertakan store_id
                category_id: categoryId, // Sertakan category_id
                name: $(this).siblings('strong').text(),
                price: parseFloat($(this).siblings('.price').text().replace('Rp ', '').replace(/\./g, '')),
                photo: $(this).siblings('img').attr('src'),
                quantity: 1,
                slug:slug,
            };
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        getData();
    });

    // decrement buttons
    $(document).on('click', '.decrement', function() {
        let productId = $(this).data('decrement-id');
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        if (cart[productId]) {
            if (cart[productId].quantity > 1) {
                cart[productId].quantity--;
            } else {
                delete cart[productId];
            }
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        getData();
    });

    //  increment buttons
    $(document).on('click', '.increment', function() {
        let productId = $(this).data('increment-id');
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        if (cart[productId]) {
            if (cart[productId].quantity >= 0) {
                cart[productId].quantity++;
            }
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        getData();
    });

    // remove buttons
    $(document).on('click', '.remove', function() {
        let productId = $(this).data('remove-id');
        let cart = JSON.parse(localStorage.getItem('cart')) || {};

        if (cart[productId]) {
            delete cart[productId];
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        getData();
    });
});


document.getElementById('logout').addEventListener('click', function(event) {
    event.preventDefault();
    function clearCartData() {
        localStorage.removeItem('cart');
        console.log('Cart data cleared.');
    }
    
    clearCartData();
    window.location.replace('/logout');
});
