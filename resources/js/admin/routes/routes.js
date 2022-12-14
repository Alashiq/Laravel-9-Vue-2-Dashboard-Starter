import Home from "../pages/Home/Home.vue";
import Profile from "../pages/Profile/Profile.vue";
import Login from "../pages/Login/Login.vue";
import Layout from "../pages/Layout/Layout.vue";
import Admins from "../pages/Admins/Admins.vue";
import Admin from "../pages/Admins/Admin/Admin.vue";
import NewAdmin from "../pages/Admins/NewAdmin/NewAdmin.vue";
import Roles from "../pages/Roles/Roles.vue";
import NewRole from "../pages/Roles/NewRole/NewRole.vue";
import Role from "../pages/Roles/Role/Role.vue";
import EditRole from "../pages/Roles/EditRole/EditRole.vue";
import EditAdminRole from "../pages/Admins/EditAdminRole/EditAdminRole.vue";


import store from "../store/index";

const ifAuth = (to, from, next) => {
    if (store.state.auth == true) {
        next();
        return;
    }
    next("/admin/login");
};

const ifNotAuth = (to, from, next) => {
    if (store.state.auth != true) {
        next();
        return;
    }
    next("/admin");
};

export const routes = [
    {
        path: "/",
        name: "layout",
        component: Layout,
        children: [
            {
                path: "admin",
                component: Home
            },
            {
                path: "admin/profile",
                component: Profile
            },
            {
                path: "admin/admin",
                component: Admins
            },
            {
                path: "admin/admin/new",
                component: NewAdmin
            },
            {
                path: "admin/admin/:id",
                component: Admin
            },
            {
                path: "admin/admin/:id/edit",
                component: EditAdminRole
            },
            {
                path: "admin/role",
                component: Roles
            },
            {
                path: "admin/role/new",
                component: NewRole
            },
            {
                path: "admin/role/:id",
                component: Role
            },
            {
                path: "admin/role/:id/edit",
                component: EditRole
            },
        ]
    },
    {
        path: "/admin/login",
        component: Login
        //beforeEnter: ifNotAuth
    }
];
