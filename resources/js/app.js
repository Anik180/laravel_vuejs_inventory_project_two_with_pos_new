/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

// Route imported
import {routes} from './routes';
//  imported user Class
import User from './Helpers/User';
window.User = User

//  imported Notification Class
import Notification from './Helpers/Notification';
window.Notification = Notification

const router = new VueRouter({
  routes,
  mode:'history'
})
//Sweet Alert Start
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.Toast = Toast;
//Sweet Alert end

window.Reload = new Vue();

const app = new Vue({
    el: '#app',
    router
});

