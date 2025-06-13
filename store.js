const stores = {
  Rimi: {
    logo: "https://cdn.nuolaidos.lt/thumb/828/logos/lt/762_rimi.png",
    products: [
      {
        name: "Piens",
        description: "Piens Limbažu 2,5% 1l",
        price: 1.49,
        image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png"
      },
      {
        name: "Gurķi",
        description: "Gurķi īsie, kg",
        price: 2.99,
        image: "https://imgproxy-retcat.assets.schwarz/1PXJl_6jwO8TmAX_lwJQxjBHqy2m7Lwso09kowMThVg/sm:1/w:1278/h:959/cz/M6Ly9wcm9kLWNhd/GFsb2ctbWVkaWEvbHYvMS9CMDJDOUM4OUFBNTAyRThCNzZGMjJDNEM/5NkE4RTEzMkIzMDlBNzkxNjFFN0VGQzQzM0UyRDdDQTlBMEE1M0Q5LmpwZw.jpg"
      },
      {
        name: "Augļi",
        description: "Banāni kg",
        price: 1.39,
        image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png"
      }
    ]
  },
  Maxima: {
    logo: "https://images.teamtailor-cdn.com/images/s3/teamtailor-production/logotype-v3/image_uploads/fdf8dbc8-5b0c-4597-8035-9060bae00675/original.png",
    products: [
      {
        name: "Piens",
        description: "Piens LIMBAŽU 2,5% 1L",
        price: 1.19,
        image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png"
      },
      {
        name: "Gurķi",
        description: "Gurķi garie Latvija kg",
        price: 1.99,
        image: "https://cdn.barbora.lv/products/6fd6e436-fe45-4af3-a9da-80e3416799f3_m.png"
      },
      {
        name: "Augļi",
        description: "Banāni kg",
        price: 1.29,
        image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png"
      }
    ]
  },
  Mego: {
    logo: "https://media.krumod.app/store/lv/mego.png",
    products: [
      {
        name: "Piens",
        description: "Piens LIMBAŽU 2,5% 1L",
        price: 1.35,
        image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png"
      },
      {
        name: "Gurķi",
        description: "Gurķi garie Latvija kg",
        price: 1.79,
        image: "https://cdn.barbora.lv/products/6fd6e436-fe45-4af3-a9da-80e3416799f3_m.png"
      },
      {
        name: "Augļi",
        description: "Banāni kg",
        price: 1.35,
        image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png"
      }
    ]
  },
  Lidl: {
    logo: "https://www.securygard.com/wp-content/uploads/2020/02/Lidl_Logo.png",
    products: [
      {
        name: "Piens",
        description: "Piens LIMBAŽU 2,5% 1L",
        price: 1.29,
        image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png"
      },
      {
        name: "Gurķi",
        description: "Īsie gurķi",
        price: 1.79,
        image: "https://imgproxy-retcat.assets.schwarz/1PXJl_6jwO8TmAX_lwJQxjBHqy2m7Lwso09kowMThVg/sm:1/w:1278/h:959/cz/M6Ly9wcm9kLWNhd/GFsb2ctbWVkaWEvbHYvMS9CMDJDOUM4OUFBNTAyRThCNzZGMjJDNEM/5NkE4RTEzMkIzMDlBNzkxNjFFN0VGQzQzM0UyRDdDQTlBMEE1M0Q5LmpwZw.jpg"
      },
      {
        name: "Augļi",
        description: "Banāni kg",
        price: 1.45,
        image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png"
      }
    ]
  }
};


const productList = document.getElementById("productList");
const cart = [];
const cartCount = document.getElementById("cartCount");
const totalPriceElement = document.getElementById("total-price");
const backButton = document.querySelector(".back-button");
let lastView = "stores";

function updateCart() {
  const cartItems = document.getElementById("cartItems");
  cartItems.innerHTML = "";
  let total = 0;

  cart.forEach((item, index) => {
    const li = document.createElement("li");
    li.innerHTML = `${item.name} - ${item.price.toFixed(2)} € <button class="remove-btn" onclick="removeFromCart(${index})">✕</button>`;
    cartItems.appendChild(li);
    total += item.price;
  });

  cartCount.textContent = cart.length;
  totalPriceElement.textContent = `${total.toFixed(2)}€`;
}

function removeFromCart(index) {
  cart.splice(index, 1);
  updateCart();
}

function addToCart(product) {
  cart.push(product);
  updateCart();
}

function addToCartByName(store, productName) {
  const product = stores[store].products.find(p => p.name === productName);
  if (product) addToCart(product);
}

function showProducts(storeName) {
  lastView = "stores";
  productList.innerHTML = `<h2>${storeName} produkti</h2>`;
  productList.classList.remove("hidden");
  backButton.classList.remove("hidden");
  document.getElementById("cart").classList.add("hidden");
  document.getElementById("storeCards").style.display = "none";

  stores[storeName].products.forEach(product => {
    const div = document.createElement("div");
    div.classList.add("product");
    div.innerHTML = `
      <img src="${product.image}" alt="${product.name}"><br>
      ${product.name}<br>
      ${product.description}<br>
      Cena: ${product.price.toFixed(2)} €<br>
      <button onclick='addToCartByName("${storeName}", "${product.name}")'>Pievienot grozam</button>
      <button onclick='skatīt("${product.name.replace(/"/g, '&quot;')}")'>Skatīt</button>
    `;
    productList.appendChild(div);
  });
}

function skatīt(productName) {
  lastView = "skatīt";
  productList.innerHTML = `<h2>Skatīt: ${productName}</h2>`;
  productList.classList.remove("hidden");
  backButton.classList.remove("hidden");
  document.getElementById("storeCards").style.display = "none";
  document.getElementById("cart").classList.add("hidden");

  for (let store in stores) {
    const product = stores[store].products.find(p => p.name === productName);
    if (product) {
      const div = document.createElement("div");
      div.classList.add("product");
      div.innerHTML = `
        <strong>${store}</strong><br>
        <img src="${product.image}" alt="${product.name}"><br>
        ${product.description}<br>
        Cena: ${product.price.toFixed(2)} €<br>
        <button onclick='addToCartByName("${store}", "${product.name}")'>Pievienot grozam</button>
      `;
      productList.appendChild(div);
    }
  }
}

function searchProducts() {
  const term = document.getElementById("searchInput").value.toLowerCase();
  productList.innerHTML = `<h2>Rezultāti pēc: "${term}"</h2>`;
  productList.classList.remove("hidden");
  backButton.classList.remove("hidden");
  document.getElementById("cart").classList.add("hidden");
  document.getElementById("storeCards").style.display = "none";

  for (let store in stores) {
    stores[store].products.forEach(product => {
      if (
        product.name.toLowerCase().includes(term) ||
        product.description.toLowerCase().includes(term)
      ) {
        const div = document.createElement("div");
        div.classList.add("product");
        div.innerHTML = `
          <strong>${store}</strong><br>
          <img src="${product.image}" alt="${product.name}"><br>
          ${product.name}<br>
          ${product.description}<br>
          Cena: ${product.price.toFixed(2)} €<br>
          <button onclick='addToCartByName("${store}", "${product.name}")'>Pievienot grozam</button>
          <button onclick='skatīt("${product.name.replace(/"/g, '&quot;')}")'>Skatīt</button>
        `;
        productList.appendChild(div);
      }
    });
  }
}

function toggleCart() {
  document.getElementById("cart").classList.toggle("hidden");
  productList.classList.add("hidden");
  document.getElementById("storeCards").style.display = "none";
  backButton.classList.remove("hidden");
}

function goBack() {
  productList.classList.add("hidden");
  document.getElementById("cart").classList.add("hidden");
  backButton.classList.add("hidden");
  document.getElementById("storeCards").style.display = "flex";
}