const products = [
    { id: 1, name: 'Product 1', description: 'Description for product 1', price: 100 },
    { id: 2, name: 'Product 2', description: 'Description for product 2', price: 200 },
    { id: 3, name: 'Product 3', description: 'Description for product 3', price: 300 }
];

const cart = [];

// Function to display products
function displayProducts() {
    const productList = document.getElementById('product-list');
    if (productList) {
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.classList.add('product');
            productDiv.innerHTML = `
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <p>$${product.price}</p>
                <button onclick="addToCart(${product.id})">Add to Cart</button>
                <a href="product.html?id=${product.id}">View Details</a>
            `;
            productList.appendChild(productDiv);
        });
    }
}

// Function to add product to cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    cart.push(product);
    alert(`${product.name} has been added to the cart.`);
}

// Function to display cart items
function displayCart() {
    const cartItems = document.getElementById('cart-items');
    if (cartItems) {
        cartItems.innerHTML = '';
        cart.forEach(item => {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.classList.add('cart-item');
            cartItemDiv.innerHTML = `
                <h3>${item.name}</h3>
                <p>$${item.price}</p>
                <button onclick="removeFromCart(${item.id})">Remove</button>
            `;
            cartItems.appendChild(cartItemDiv);
        });
    }
}

// Function to remove item from cart
function removeFromCart(productId) {
    const productIndex = cart.findIndex(p => p.id === productId);
    if (productIndex > -1) {
        cart.splice(productIndex, 1);
        displayCart();
        alert(`Product has been removed from the cart.`);
    }
}

// Function to display product details
function displayProductDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = parseInt(urlParams.get('id'), 10);
    const product = products.find(p => p.id === productId);
    if (product) {
        document.getElementById('product-name').innerText = product.name;
        const productDetails = document.getElementById('product-details');
        productDetails.innerHTML = `
            <p>${product.description}</p>
            <p>$${product.price}</p>
            <button onclick="addToCart(${product.id})">Add to Cart</button>
        `;
    }
}

// Function to handle checkout
function checkout() {
    alert('Thank you for your purchase!');
    cart.length = 0; // Clear the cart
    displayCart();
}

// Initialize product list or cart based on the page
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('product-list')) {
        displayProducts();
    }
    if (document.getElementById('cart-items')) {
        displayCart();
    }
    if (document.getElementById('product-details')) {
        displayProductDetails();
    }
});
