<?php require_once 'db.php'; ?>
<?php
session_start();
require_once "config.php";

$session_id = session_id();
$stmt = $conn->prepare("SELECT * FROM cart WHERE session_id = ?");
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
    $total += $row['price'] * $row['quantity'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product = $_POST['product'];
    $price = floatval($_POST['price']);
    $quantity = 1;

    $stmt = $conn->prepare("INSERT INTO cart (session_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $session_id, $product, $price, $quantity);
    $stmt->execute();
    header("Location: shop.php");
    exit;
}

$search = $_GET['search'] ?? '';
$store = $_GET['store'] ?? '';
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Veikals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1f1f1f; color: white; font-family: Arial; }
        .store-card, .product { background: #2b2b2b; margin: 10px; padding: 10px; border-radius: 10px; display: inline-block; vertical-align: top; width: 200px; text-align: center; }
        .store-card img, .product img { width: 100px; height: 100px; object-fit: contain; }
        .cart-box { background: #333; padding: 15px; border-radius: 10px; margin: 20px 0; }
        .order-button { background: #4CAF50; padding: 10px 15px; border: none; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
        .hidden { display: none; }
        .compare-toggle {
    background-color: #ff9800;
    color: white;
    border: none;
    padding: 6px 12px;
    margin-top: 8px;
    border-radius: 5px;
    cursor: pointer;
  }

  .compare-toggle:hover {
    background-color: #e68900;
  }

  #backToStores {
    margin: 15px;
    display: inline-block;
    background-color: #444;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
  }

  #backToStores:hover {
    background-color: #666;
  }
    </style>
</head>
<body>

<div class="container mt-3">
  <div class="input-group mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Meklēt produktus...">
    <button class="btn btn-primary" onclick="searchProducts()">Meklēt</button>
  </div>
</div>


<div style="padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center;">
        <img src="photo_5908834535334857354_x.jpg" alt="Logo" style="height: 60px; margin-right: 25px;">
        <a href="shop.php" style="color:white; margin-right:20px; text-decoration:none; font-weight:bold;">Veikals</a>
        <a href="cart.php" style="color:white; margin-right:20px; text-decoration:none;">🛒 Grozs</a>
        <a href="guest.php" style="color:white; margin-right:20px; text-decoration:none;">👥 Viesis</a>
        <a href="admin_login.php" style="color:white; margin-right:20px; text-decoration:none;">🔐 Admins</a>
</div>

</div>


<div id="storeCards">  <a href="login.php" style="color:white; margin-left:15px;">🔑 Viedoties</a>
  <a href="register.php" style="color:white; margin-left:15px;">📝 Reģistrēties</a>
</div>
<div id="productList" class="hidden">  <a href="login.php" style="color:white; margin-left:15px;">🔑 Viedoties</a>
  <a href="register.php" style="color:white; margin-left:15px;">📝 Reģistrēties</a>
</div>
<a id="backToStores" class="hidden" onclick="goBackToStores()">⬅ Atpakaļ uz veikaliem</a>

<script>
const stores = {
  Rimi: {
    logo: "https://cdn.nuolaidos.lt/thumb/828/logos/lt/762_rimi.png",
    products: [
      { name: "Piens", description: "Limbažu piens 2,5% 1l", price: 1.49, image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png" },
      { name: "Gurķi", description: "Īsie gurķi, kg", price: 2.99, image: "https://imgproxy-retcat.assets.schwarz/1PXJl_6jwO8TmAX_lwJQxjBHqy2m7Lwso09kowMThVg/sm:1/w:1278/h:959/cz/M6Ly9wcm9kLWNhd/GFsb2ctbWVkaWEvbHYvMS9CMDJDOUM4OUFBNTAyRThCNzZGMjJDNEM/5NkE4RTEzMkIzMDlBNzkxNjFFN0VGQzQzM0UyRDdDQTlBMEE1M0Q5LmpwZw.jpg" },
      { name: "Banāni", description: "Banāni, kg", price: 1.39, image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png" }
    ]
  },
  Maxima: {
    logo: "https://images.teamtailor-cdn.com/images/s3/teamtailor-production/logotype-v3/image_uploads/fdf8dbc8-5b0c-4597-8035-9060bae00675/original.png",
    products: [
      { name: "Piens", description: "Limbažu piens 2,5% 1l", price: 1.19, image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png" },
      { name: "Gurķi", description: "Garie gurķi Latvijā, kg", price: 1.99, image: "https://cdn.barbora.lv/products/6fd6e436-fe45-4af3-a9da-80e3416799f3_m.png" },
      { name: "Banāni", description: "Banāni, kg", price: 1.29, image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png" }
    ]
  },
  Mego: {
    logo: "https://media.krumod.app/store/lv/mego.png",
    products: [
      { name: "Piens", description: "Limbažu piens 2,5% 1l", price: 1.35, image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png" },
      { name: "Gurķi", description: "Garie gurķi Latvijā, kg", price: 1.79, image: "https://cdn.barbora.lv/products/6fd6e436-fe45-4af3-a9da-80e3416799f3_m.png" },
      { name: "Banāni", description: "Banāni, kg", price: 1.35, image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png" }
    ]
  },
  Lidl: {
    logo: "https://www.securygard.com/wp-content/uploads/2020/02/Lidl_Logo.png",
    products: [
      { name: "Piens", description: "Limbažu piens 2,5% 1l", price: 1.29, image: "https://cdn.barbora.lv/products/ab96660c-5fe7-42b3-9027-66547593793c_m.png" },
      { name: "Gurķi", description: "Īsie gurķi", price: 1.79, image: "https://imgproxy-retcat.assets.schwarz/1PXJl_6jwO8TmAX_lwJQxjBHqy2m7Lwso09kowMThVg/sm:1/w:1278/h:959/cz/M6Ly9wcm9kLWNhd/GFsb2ctbWVkaWEvbHYvMS9CMDJDOUM4OUFBNTAyRThCNzZGMjJDNEM/5NkE4RTEzMkIzMDlBNzkxNjFFN0VGQzQzM0UyRDdDQTlBMEE1M0Q5LmpwZw.jpg" },
      { name: "Banāni", description: "Banāni, kg", price: 1.45, image: "https://cdn.barbora.lv/products/ed99c0de-fe2d-4a6d-96a2-357ca48d0141_m.png" }
    ]
  }
};

const storeCardsContainer = document.getElementById("storeCards");
const productList = document.getElementById("productList");

document.addEventListener("DOMContentLoaded", () => {


  for (let store in stores) {
    const card = document.createElement("div");
    card.classList.add("store-card");
    card.innerHTML = `<img src="${stores[store].logo}" /><strong>${store}</strong>`;
    card.onclick = () => showProducts(store);
    storeCardsContainer.appendChild(card);
  }
});

function searchProducts() {
  const search = document.getElementById("searchInput").value.toLowerCase();
  document.querySelectorAll(".product").forEach(p => {
    p.style.display = p.textContent.toLowerCase().includes(search) ? "inline-block" : "none";
  });
}
const backToStores = document.getElementById("backToStores");

function showProducts(storeName) {
  storeCardsContainer.classList.add("hidden");
  productList.classList.remove("hidden");
  backToStores.classList.remove("hidden");
  productList.innerHTML = "";

  stores[storeName].products.forEach(product => {
    const div = document.createElement("div");
    div.className = "product";

    let comparisonHtml = `<div class="comparison hidden">`;
    for (let otherStore in stores) {
      if (otherStore !== storeName) {
        const match = stores[otherStore].products.find(p => p.name === product.name);
        if (match) {
          comparisonHtml += `<p><strong>${otherStore}:</strong> ${match.price.toFixed(2)}€</p>`;
        }
      }
    }


    div.innerHTML = `
      <img src="${product.image}" alt="${product.name}" />
      <h3>${product.name}</h3>
      <p>${product.description}</p>
      <strong>${product.price.toFixed(2)}€</strong><br>
      <form method="POST">
        <input type="hidden" name="product" value="${product.name}">
        <input type="hidden" name="price" value="${product.price}">
        <button type="submit" name="add_to_cart">Pievienot grozam</button>
      </form>
      <button type="button" class="compare-toggle">Salīdzināt cenas</button>
      ${comparisonHtml}
    `;
    productList.appendChild(div);
  });

  document.querySelectorAll(".compare-toggle").forEach((btn) => {
    btn.addEventListener("click", () => {
      const comparisonDiv = btn.nextElementSibling;
      if (comparisonDiv) {
        comparisonDiv.classList.toggle("hidden");
      }
    });
  });
}

function goBackToStores() {
  productList.classList.add("hidden");
  storeCardsContainer.classList.remove("hidden");
  backToStores.classList.add("hidden");
}

</script>

<script src="store.js"></script>
</body>
</html>
