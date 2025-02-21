const storeJS = `
const store = Vuex.createStore({
    state() {
        return {
            cart: JSON.parse(localStorage.getItem('cart')) || []
        };
    },
    mutations: {
        addToCart(state, product) {
            state.cart.push(product);
            localStorage.setItem('cart', JSON.stringify(state.cart));
        }
    }
});
`;