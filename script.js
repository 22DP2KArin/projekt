let cart = {};
let currentStore = '';

const productsData = {
    maxima: [
        { name: "Piens", price: 1.2 },
        { name: "Maize", price: 0.8 },
        { name: "Siers", price: 2.5 },
        { name: "Olas", price: 1.5 },
        { name: "Sviests", price: 3.0 }
    ],
    rimi: [
        { name: "Kafija", price: 4.2 },
        { name: "Tēja", price: 2.5 },
        { name: "Cukurs", price: 1.1 },
        { name: "Šokolāde", price: 2.8 },
        { name: "Banāni", price: 1.9 }
    ],
    lidl: [
        { name: "Sula", price: 3.0 },
        { name: "Ūdens", price: 0.6 },
        { name: "Čipsi", price: 2.0 },
        { name: "Jogurts", price: 1.4 },
        { name: "Medus", price: 5.0 }
    ],
    mego: [
        { name: "Kviešu milti", price: 1.3 },
        { name: "Griķi", price: 2.0 },
        { name: "Rīsi", price: 2.2 },
        { name: "Tomāti", price: 3.5 },
        { name: "Gurķi", price: 2.7 }
    ]
};

function openStore(storeName) {
    currentStore = storeName;
    document.querySelector(".store-container").classList.add("hidden");
    document.getElementById("store-content").classList.remove("hidden");
    document.getElementById("store-name").innerText = storeName.charAt(0).toUpperCase() + storeName.slice(1);
    loadProducts(storeName);
}

function loadProducts(store) {
    let productsDiv = document.getElementById("products");
    productsDiv.innerHTML = "";
    productsData[store].forEach(product => {
        productsDiv.innerHTML += `
            <div class="product-card">
                <h3>${product.name}</h3>
                <p>${product.price}€</p>
                <button class="add-btn" onclick="addToCart('${store}', '${product.name}', ${product.price})">Pievienot grozam</button>
            </div>
        `;
    });
}

function searchProducts(query) {
    let productsDiv = document.getElementById("products");
    productsDiv.innerHTML = "";
    productsData[currentStore].filter(product => 
        product.name.toLowerCase().includes(query.toLowerCase())
    ).forEach(product => {
        productsDiv.innerHTML += `
            <div class="product-card">
                <h3>${product.name}</h3>
                <p>${product.price}€</p>
                <button class="add-btn" onclick="addToCart('${currentStore}', '${product.name}', ${product.price})">Pievienot grozam</button>
            </div>
        `;
    });
}

function goBack() {
    document.getElementById("store-content").classList.add("hidden");
    document.querySelector(".store-container").classList.remove("hidden");
}

function addToCart(store, name, price) {
    if (!cart[store]) cart[store] = [];
    cart[store].push({ name, price });
    updateCart();
}

function updateCart() {
    let cartItems = document.getElementById("cart-items");
    cartItems.innerHTML = "";
    for (let store in cart) {
        if (cart[store].length > 0) {
            cartItems.innerHTML += `<h3>${store.toUpperCase()}</h3>`;
            cart[store].forEach((item, index) => {
                cartItems.innerHTML += `
                    <li>${item.name} - ${item.price}€ 
                        <button class="remove-btn" onclick="removeFromCart('${store}', ${index})">X</button>
                    </li>
                `;
            });
        }
    }
}

function removeFromCart(store, index) {
    cart[store].splice(index, 1);
    updateCart();
}

function toggleCart() {
    document.getElementById("cart-section").classList.toggle("hidden");
}

function openCheckout() {
    document.getElementById("checkout-modal").style.display = "flex";
}

function closeCheckout() {
    document.getElementById("checkout-modal").style.display = "none";
}

function confirmOrder() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let address = document.getElementById("address").value;

    if (!name || !email || !phone || !address) {
        alert("Aizpildiet visus laukus!");
        return;
    }

    alert(`Paldies, ${name}! Jūsu pasūtījums ir pieņemts.`);
    cart = {};
    updateCart();
    closeCheckout();
}

document.querySelector(".dark-mode-toggle").addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
});
