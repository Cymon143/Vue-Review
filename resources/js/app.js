
require('./bootstrap');
window.Vue = require('vue').default;
import router from './routes';
import Vue from 'vue';
import Form from 'vform';
import Gate from './gate';
import './filter';
import './global';
import {HasError, AlertError } from 'vform/src/components/bootstrap5';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
Vue.prototype.$gate = new Gate(window.user,window.role);
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast:true,
    position: 'top-end',
    showConfirmButton:false,
    timer:3000,
});
window.toast = toast;

import VueRouter from 'vue-router';
Vue.use(VueRouter);
Vue.use(LaravelPermissionToVueJS)
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

Vue.component('v-calendar', Calendar)
Vue.component('v-date-picker', DatePicker)

Vue.prototype.can = function(value){
    return window.Laravel.jsPermissions.permissions.includes(value);
}
Vue.prototype.is = function(value){
    return window.Laravel.jsPermissions.roles.includes(value);
}
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
Vue.component(
    'forbidden',
    require('./components/Forbidden.vue').default
);
const app = new Vue({
    el: '#app',
    router
});
