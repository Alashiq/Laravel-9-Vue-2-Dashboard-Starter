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
        pages: [
            {
                id: 1,
                target: 0, // 0 label - 1 page
                name: "الرئيسية",
                nameEn: "Home",
                role: "HomeLabel",
                url: "/admin",
                icon: "fa-regular fa-house",
                list: [],
            },
            {
                id: 2,
                target: 1, // 0 label - 1 page
                name: "الصفحة الرئيسية",
                nameEn: "Home Page",
                role: "HomeChart",
                url: "/admin",
                icon: "fa-sharp fa-solid fa-house",
                list: [],
            },
            {
                id: 3,
                target: 0, // 0 label - 1 page
                name: "الإعدادات",
                nameEn: "Settings",
                role: "SettingLabel",
                url: "/admin",
                icon: "fas fa-home",
                list: [],
            },
            {
                id: 5,
                target: 1, // 0 label - 1 page
                name: "المشرفين والصلاحيات",
                nameEn: "Admins & Roles",
                role: "RolePermissionsList",
                url: "/admin",
                icon: "fas fa-user-shield",
                list: [
                    {
                        id: 1,
                        name: "قائمة المشرفين",
                        nameEn: "Admins List",
                        role: "ReadAdmin",
                        url: "/admin/admin",
                    },
                    {
                        id: 2,
                        name: "إضافة مشرف",
                        nameEn: "New Admin",
                        role: "CreateAdmin",
                        url: "/admin/admin/new",
                    },
                    {
                        id: 3,
                        name: "أدوار المشرفين",
                        nameEn: "Roles List",
                        role: "ReadRole",
                        url: "/admin/role",
                    },
                    {
                        id: 4,
                        name: "إضافة دور",
                        nameEn: "New Role",
                        role: "CreateRole",
                        url: "/admin/role/new",
                    },
                ],
            },
            {
                id: 6,
                target: 1, // 0 label - 1 page
                name: "قائمة المشرفين",
                nameEn: "Admins List",
                role: "ReadAdmin",
                url: "/admin",
                icon: "fas fa-user-shield",
                list: [],
            },
        ],
        pageActive: 4,
        subPageActive: 1,
        openPageList: 4,
        loading: false,

        // Menu
        menu: false,
        languageMenu: false,
        userMenu: false,


        // Language
        language:'ar',
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
        updateName(state, data) {
            state.user.first_name = data.first_name;
            state.user.last_name = data.last_name;
            state.user.name = data.first_name + " " + data.last_name;
        },
        updatePhoto(state, photo) {
            state.user.photo = photo;
        },
        activePage(state, v) {
            state.pageActive = v.main;
            state.subPageActive = v.sub;
            state.openPageList = v.main;
        },
        toggllePageList(state, pageNumber) {
            if (state.openPageList != pageNumber)
                state.openPageList = pageNumber;
            else
                state.openPageList = 0;
        },
        // Loading 
        loadingStart(state) {
            state.loading = true;
        },
        loadingStop(state) {
            state.loading = false;
        },
        // Menu
        toggleMenu(state) {
            state.menu = !state.menu;
        },
        toggleLanguageMenu(state,val) {
            if(val==1)
            state.languageMenu = !state.languageMenu;
            else
            state.languageMenu=false;
        },
        toggleUserMenu(state,val) {
            if(val==1)
            state.userMenu = !state.userMenu;
            else
            state.userMenu=false;
        },
        // Language
        channgeLanguage(state,language){
            state.language=language;
            localStorage.setItem("language", language);
        }
    },

    actions: {
        // If 401 Error
        async clearAuth({ commit }) {
            this.commit("clearUser");
        },

    }
};
