let cart = [];
let currentStore = null;

function showTab(tabId) {
  const allSections = ["searchTab", "cart", "register", "productList", "productDetails", "storeCards"];
  allSections.forEach(id => {
    const section = document.getElementById(id);
    if (section) section.classList.add("hidden");
  });

  const activeSection = document.getElementById(tabId);
  if (activeSection) activeSection.classList.remove("hidden");

  // Если открыли поиск, покажем магазины
  if (tabId === "searchTab" || tabId === "productList") {
    const storeCards = document.getElementById("storeCards");
    if (storeCards) storeCards.classList.remove("hidden");
  }
}

function viewStore(storeName) {
  currentStore = storeName;
  const list = document.getElementById("productList");
  const details = document.getElementById("productDetails");
  list.innerHTML = "";
  details.classList.add("hidden");
  list.classList.remove("hidden");

  stores[storeName].forEach(product => {
    const div = document.createElement("div");
    div.className = "product";
    div.innerHTML = `
      <img src="${product.image}" alt="${product.name}" />
      <h3>${product.name}</h3>
      <p>${product.description}</p>
      <p><b>${product.price.toFixed(2)}€</b></p>
      <button onclick="addToCart('${product.name}', ${product.price})">Pievienot grozam</button>
      <button onclick="showDetails('${product.name}')">Skatīt</button>
    `;
    list.appendChild(div);
  });
}

function addToCart(name, price) {
  cart.push({ name, price });
  document.getElementById("cartCount").textContent = cart.length;
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchInput.form.submit();
            }
        });
    }
});

function toggleCart() {
  const cartSection = document.getElementById("cart");
  cartSection.classList.toggle("hidden");
  const list = document.getElementById("cartItems");
  list.innerHTML = "";
  cart.forEach(item => {
    const li = document.createElement("li");
    li.textContent = `${item.name} - ${item.price.toFixed(2)}€`;
    list.appendChild(li);
  });
}

function checkout() {
  if (cart.length === 0) return alert("Grozs ir tukšs!");

  fetch("https://api.stripe.com/v1/checkout/sessions", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
      "Authorization": "Bearer sk_test_1234567890abcdef" // 🔒 замените на свою Stripe API key
    },
    body: new URLSearchParams({
      "success_url": window.location.href,
      "cancel_url": window.location.href,
      "line_items[0][price_data][currency]": "eur",
      "line_items[0][price_data][product_data][name]": cart[0].name,
      "line_items[0][price_data][unit_amount]": Math.round(cart[0].price * 100),
      "line_items[0][quantity]": "1",
      "mode": "payment"
    })
  })
    .then(res => res.json())
    .then(data => {
      if (data.url) window.location = data.url;
      else alert("Stripe kļūda");
    });
}

function searchProducts() {
  const query = document.getElementById("searchInput").value.toLowerCase();
  if (!query) return;
  for (const store in stores) {
    const product = stores[store].find(p => p.name.toLowerCase().includes(query));
    if (product) {
      viewStore(store);
      return;
    }
  }
  alert("Produkts nav atrasts.");
}

function showDetails(productName) {
  const section = document.getElementById("productDetails");
  section.innerHTML = `<h2>${productName} cenas dažādos veikalos</h2>`;
  for (const store in stores) {
    const match = stores[store].find(p => p.name === productName);
    if (match) {
      const div = document.createElement("div");
      div.className = "product";
      div.innerHTML = `
        <img src="${match.image}" />
        <h3>${store}</h3>
        <p>${match.description}</p>
        <p><b>${match.price.toFixed(2)}€</b></p>
        <button onclick="addToCart('${match.name}', ${match.price})">Pievienot grozam</button>
      `;
      section.appendChild(div);
    }
  }
  section.classList.remove("hidden");
}

function toggleRegister() {
  document.getElementById("register").classList.toggle("hidden");
}

function registerUser() {
  const name = document.getElementById("regName").value;
  const email = document.getElementById("regEmail").value;
  const pass = document.getElementById("regPass").value;
  if (!name || !email || !pass) return alert("Aizpildiet visus laukus");
  localStorage.setItem("ozymUser", JSON.stringify({ name, email, pass }));
  alert("Reģistrācija veiksmīga!");
  toggleRegister();
}
function updateCart() {

  let total = 0;
  cart.forEach(item => {
    total += item.price * item.quantity;
  });

  const totalPriceElement = document.getElementById("total-price");
  if (totalPriceElement) {
    totalPriceElement.textContent = `${total}₽`;
  }
}
document.getElementById("register-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  const response = await fetch("/register", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ username, password }),
  });

  const result = await response.json();
  document.getElementById("register-status").textContent = result.message;
});
