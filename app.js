const { createApp } = Vue;

createApp({
    data() {
        return {
            stores: [
                { id: 1, name: "Maxima" },
                { id: 2, name: "Rimi" }
            ],
            products: [
                { id: 1, storeId: 1, name: "Āboli", price: 1.2, image: "apple.png" },
                { id: 2, storeId: 1, name: "Banāni", price: 1.5, image: "banana.png" },
                { id: 3, storeId: 2, name: "Piens", price: 0.99, image: "milk.png" }
            ],
            selectedStore: null,
            search: "",
            cart: JSON.parse(localStorage.getItem("cart")) || [],
            showCheckout: false,
            orderName: "",
            orderPhone: "",
            orderAddress: ""
        };
    },
    computed: {
        filteredProducts() {
            return this.products.filter(
                p => p.storeId === this.selectedStore?.id &&
                     p.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        totalPrice() {
            return this.cart.reduce((sum, item) => sum + item.price, 0).toFixed(2);
        }
    },
    methods: {
        selectStore(store) {
            this.selectedStore = store;
        },
        addToCart(product) {
            this.cart.push(product);
            localStorage.setItem("cart", JSON.stringify(this.cart));
        },
        removeFromCart(item) {
            this.cart = this.cart.filter(p => p.id !== item.id);
            localStorage.setItem("cart", JSON.stringify(this.cart));
        },
        confirmOrder() {
            if (!this.orderName || !this.orderPhone || !this.orderAddress) {
                alert("⚠️ Lūdzu aizpildiet visus laukus!");
                return;
            }
            alert(`✅ Pasūtījums apstiprināts!\n📍 Piegāde uz: ${this.orderAddress}`);
            this.cart = [];
            localStorage.removeItem("cart");
            this.showCheckout = false;
        }
    }
}).mount("#app");
const express = require("express");
const app = express();
const sqlite3 = require("sqlite3").verbose();
const bcrypt = require("bcrypt");
const path = require("path");

const db = new sqlite3.Database("./users.db");

app.use(express.static("."));
app.use(express.json());

// Создание таблицы пользователей
db.run(`CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT UNIQUE,
  password TEXT
)`);

// Регистрация
app.post("/register", async (req, res) => {
  const { username, password } = req.body;
  const hash = await bcrypt.hash(password, 10);

  db.run(`INSERT INTO users (username, password) VALUES (?, ?)`, [username, hash], function(err) {
    if (err) {
      return res.json({ message: "Пользователь уже существует" });
    }
    res.json({ message: "Регистрация успешна!" });
  });
});

// Запуск сервера
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Сервер запущен: http://localhost:${PORT}`);
});
