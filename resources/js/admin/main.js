require("../bootstrap");

import Vue from "vue";

import DataServices from "./shared/DataServices";
import Alert from "./shared/Alert";
import Loading from "./shared/Loading";
window.Vue = require("vue");

import VueRouter from "vue-router";
Vue.use(VueRouter);
import { routes } from "./routes/routes";


import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/index.js"
import axios from "axios";

Vue.prototype.$http = DataServices;
Vue.prototype.$alert = Alert;
Vue.prototype.$loading = Loading;

const store = new Vuex.Store(
    storeData
 )

const router = new VueRouter({
    routes,
    mode: "history",
});





// Shared Components
Vue.component('App-Side', require('../admin/pages/Layout/AppSide/AppSide.vue').default);
Vue.component('App-Header', require('../admin/pages/Layout/AppHeader/AppHeader.vue').default);

Vue.component('Loading-Box', require('../admin/components/LoadingBox/LoadingBox.vue').default);
Vue.component('Pagination-Bar', require('../admin/components/PaginationBar/PaginationBar.vue').default);
Vue.component('Single-Page-Header', require('../admin/components/SinglePageHeader/SinglePageHeader.vue').default);
Vue.component('Btn-Submit-New-Item', require('../admin/components/BtnSubmitNewItem/BtnSubmitNewItem.vue').default);
Vue.component('Empty-Box', require('../admin/components/EmptyBox/EmptyBox.vue').default);
Vue.component('Bad-Request', require('../admin/components/BadRequest/BadRequest.vue').default);
Vue.component('No-Permission', require('../admin/components/NoPermission/NoPermission.vue').default);
Vue.component('No-Internet', require('../admin/components/NoInternet/NoInternet.vue').default);




window.root = new Vue({
    el: "#app",
    router,
    store,
    beforeCreate: function () {
    },
    methods:{
    }
});



