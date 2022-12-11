export default {
    state: () => ({
        loadAuth: false,
        auth: false,
        user: {
            id: null,
            name: "",
            phone: "",
            photo: "",
            role: ""
        },
        permissions: [],
        pageList: [
            {
                id: 1,
                name: "الرئيسية",
                role: "HomeChart",
                open: true,
                path: "/admin",
                icon: "fas fa-home",
                list: [
                    {
                        id: 1,
                        name: "الرئيسية",
                        role: "HomeChart",
                        active: true,
                        path: "/admin",
                        icon: "fas fa-home"
                    },
                    {
                        id: 2,
                        name: "الإحصائيات",
                        role: "HomeChart",
                        active: false,
                        path: "/admin",
                        icon: "fas fa-home"
                    },
                ]
            },
            {
                id: 2,
                name: "الرسائل",
                role: "ReadMessage",
                open: false,
                path: "/admin/message",
                icon: "fas fa-comment-dots",
                list: [
                    {
                        id: 3,
                        name: "كل الرسائل",
                        role: "HomeChart",
                        active: false,
                        path: "/admin",
                        icon: "fas fa-home"
                    },
                    {
                        id: 4,
                        name: "اضف رسالة",
                        role: "HomeChart",
                        active: false,
                        path: "/admin",
                        icon: "fas fa-home"
                    },
                ]
            },

            {
                id: 3,
                name: "المشرفين",
                role: "ReadAdmin",
                open: false,
                path: "/admin/admin",
                icon: "fas fa-users",
                list: []
            },
            {
                id: 4,
                name: "أدوار المشرفين",
                role: "ReadRole",
                open: false,
                path: "/admin/role",
                icon: "fas fa-user-shield",
                list: [
                    {
                        id: 5,
                        name: "قائمة المشرفين",
                        role: "ReadRole",
                        active: false,
                        path: "/admin/role",
                        icon: "fas fa-user-shield",
                    },
                    {
                        id: 6,
                        name: "أضف مشرف",
                        role: "ReadRole",
                        active: false,
                        path: "/admin/role",
                        icon: "fas fa-user-shield",
                    },
                ]
            }
        ],
        menu: false,
        loading: false
    }),

    mutations: {
        setUser(state, data) {
            state.user = data;
            state.user.name = data.first_name + " " + data.last_name
            state.auth = true;
        },
        setPermissions(state, data) {
            state.permissions = data;
        },
        authLoaded(state) {
            state.loadAuth = true;
        },
        clearUser(state) {
            state.user = {
                id: null,
                name: "",
                phone: "",
                photo: ""
            };
            state.auth = false;
            state.loadAuth = false;
        },
        updateName(state,data) {
            state.user.first_name = data.first_name;
            state.user.last_name = data.last_name;
            state.user.name=data.first_name+" "+data.last_name;
        },
        updatePhoto(state, photo) {
            state.user.photo = photo;
        },
        activePage(state, pageNumber) {
            for (var i = 0; i < state.pageList.length; i++) {
                state.pageList[i].open = false;
                for (var j = 0; j < state.pageList[i].list.length; j++) {
                    if (state.pageList[i].list[j].id == pageNumber) {
                        state.pageList[i].open = true;
                        state.pageList[i].list[j].active = true;
                    }
                    else {
                        state.pageList[i].list[j].active = false;
                    }
                }

            }
        },
        openPageList(state, pageNumber) {
            for (var i = 0; i < state.pageList.length; i++) {
                if (state.pageList[i].id == pageNumber) {
                    state.pageList[i].open = true;
                }
            }
        },
        closePageList(state, pageNumber) {
            for (var i = 0; i < state.pageList.length; i++) {
                if (state.pageList[i].id == pageNumber) {
                    state.pageList[i].open = false;
                }
            }
        },
        toggleMenu(state) {
            state.menu = !state.menu;
        },
        loadingStart(state) {
            state.loading = true;
        },
        loadingStop(state) {
            state.loading = false;
        },
    },

    actions: {
        // If 401 Error
        async clearAuth({ commit }) {
            this.commit("clearUser");
        },

    }
};
