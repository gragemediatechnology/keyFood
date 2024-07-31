
function formatPrice(price) {
    return 'Rp ' + price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }).slice(3);
}

function getCartData() {
    return JSON.parse(localStorage.getItem('cart')) || {};
}

function updateCheckoutDetails() {
    const cart = getCartData();
    const checkoutLists = document.getElementById('checkout-lists');
    checkoutLists.innerHTML = '';

    let totalPrice = 0;

    for (const productId in cart) {
        const item = cart[productId];
        const itemTotal = item.price * item.quantity;
        totalPrice += itemTotal;

        checkoutLists.innerHTML += `
            <div class="card-product">
                <div class="card-image"><img src="${item.photo}" alt="${item.name}"></div>
                <div class="card-details" data-counter-id="${productId}">
                    <div class="card-name">${item.name}</div>
                    <div class="card-price" data-price="${item.price}">Rp. ${item.price}</div>
                    <div class="card-wheel">
                        <button class="decrement" data-product-id="${productId}">-</button>
                        <span class="count" data-count="${item.quantity}">${item.quantity}</span>
                        <button class="increment" data-product-id="${productId}">+</button>
                    </div>
                </div>
            </div>`;
    }

    document.getElementById('total-price').textContent = formatPrice(totalPrice);
}

function updateCart(productId, quantityChange) {
    const cart = getCartData();
    if (cart[productId]) {
        cart[productId].quantity += quantityChange;
        if (cart[productId].quantity <= 0) {
            delete cart[productId];
        }
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCheckoutDetails();
}

document.addEventListener('DOMContentLoaded', () => {
    updateCheckoutDetails();

    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('decrement')) {
            const productId = event.target.getAttribute('data-product-id');
            updateCart(productId, -1);
        }

        if (event.target.classList.contains('increment')) {
            const productId = event.target.getAttribute('data-product-id');
            updateCart(productId, 1);
        }
    });
});