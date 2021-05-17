/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

'use strict';


import ProductReviewsComponent from './components/ProductReviewsComponent';
import Vue from 'vue';

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('product-reviews-component', ProductReviewsComponent);

/**
 * This let us access the `__` method for localization in VueJS templates
 * ({{ __('key') }})
 */
Vue.prototype.__ = (key) => {
    return window.trans[key] !== 'undefined' ? window.trans[key] : key;
};
new Vue({
    el: '#app',
});


if ($('#footer-links').length) {
    new Vue({
        el: '#footer-links',
    });
}
