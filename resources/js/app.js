/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import router from './routes'
import VueRouter from 'vue-router';
import moment from 'moment';
import starRating from './shared/components/StarRaiting.vue'
import FatalError from './shared/components/FatalError.vue'
import ValiadtionError from './shared/components/ValidationError.vue'


Vue.component('index', require('./index.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('star-rating', starRating);
Vue.component('fatal-error', FatalError);
Vue.component('v-error', ValiadtionError);



Vue.use(VueRouter)
Vue.filter("fromNow", value => moment(value).fromNow())

const app = new Vue({
    el: '#app',
    router,
});
