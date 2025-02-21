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
