require('./bootstrap');

window.Vue = require('vue');
Vue.component('product-crud', require('./components/product/Product.vue').default);
const app = new Vue({
    el: '#app-product'
});
