<template>
    <div class="h-20 w-full bg-white mb-8 flex justify-between items-center px-3 layout-shadow">


        <div class="flex justify-end clear-left">
            <div class="flex justify-end clear-left">
                <div @click="toggleUserMenu()"
                    :class="[userMenu ? 'active-header-user' : ' '] +' flex flex-wrap items-center font-normal cairo text-sm text-gray-500   hover:bg-gray-100 cursor-pointer px-2 py-1 rounded-lg'">
                    <div class="border rounded-full flex items-center justify-center">
                        <img :src="user.photo" class="w-10 h-10 m-1 rounded-full " alt="">
                    </div>
                    <div class="w-2"></div>
                    <div >
                     {{ t[lang].headerWelcome }}

                    </div>
                    <div class="w-1"></div>
                    <div class="font-medium">
                        {{ user.first_name }}
                    </div>

                    <div class="w-2"></div>
                    <div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
                <div v-if="userMenu" class="py-1 w-44 bg-white mt-14 rounded absolute text-gray-600 text-sm cairo"
                    style="box-shadow: 0 0.25rem 1rem rgb(161 172 184 / 45%);">

                    <div class="flex items-center px-4 pt-3 pb-2">
                        <div class="h-10 w-10">
                            <img :src="user.photo" class="rounded-full h-10" />
                            <div
                                class="rounded-full  h-3 w-3 bg-white shadow-xl animate-ping  -mt-3 mr-7 flex items-center justify-center">
                                <div class="back-btn h-4 w-4 rounded-full animate-ping"></div>
                            </div>
                            <div
                                class="rounded-full h-3 w-3 bg-white shadow-xl relative z-10 -mt-3 mr-7 flex items-center justify-center">
                                <div class="back-btn h-2 w-2 rounded-full"></div>
                            </div>
                        </div>
                        <div class="w-2"></div>
                        <div class="">
                            <div class="Swissra-Normal text-basea" style="color:#697a8d;">{{ user.first_name }}</div>
                            <div class="text-gray-400 text-xs">{{ user.role }}</div>
                        </div>
                    </div>

                    <div class="w-full bg-gray-200 h-px my-1"></div>

                    <router-link to="/admin/profile">
                        <div
                            class="flex items-center justify-start px-4 my-1 h-10 hover:bg-gray-100 JF-Flat cursor-pointer"
                            style="color:#697a8d;">
                            <i class="fa-solid fa-user-pen"></i>
                            <div class="w-2"></div>
                            <span >{{ t[lang].editAccount }}</span>
                        </div>
                    </router-link>

                    <div class="w-full bg-gray-200 h-px my-1"></div>
                    <div @click="logout"
                        class="flex items-center justify-start px-4 my-1 h-10 hover:bg-gray-100 JF-Flat cursor-pointer"
                        style="color:#697a8d;">
                        <i class="fa-solid fa-power-off"></i>
                        <div class="w-2"></div>
                        <span >{{ t[lang].logout }}</span>
                    </div>

                </div>
            </div>

            <!-- Notification Box -->
            <div class="text-2xl mx-4 flex items-center justify-center">
                <i class="fa-regular fa-bell" style="color:#697a8d;"></i>
            </div>
            <!-- End Notifications Box -->
        </div>

        <div class=" flex items-center justify-center">
            <div class="h-9 ml-2 flex items-start justify-end" id="language">
                <div  @click="toggleLanguageMenu()" class="h-9 w-9 border border-gray-200 cursor-pointer rounded-xl flex items-center justify-center">
                    <img v-if="lang=='ar'" src="http://localhost:3000/src/assets/png/ar.png" class="h-7 w-7 rounded-lg" alt="">
                    <img v-else src="https://demos.themeselection.com/sneat-aspnet-core-admin-template/assets/vendor/fonts/flags/1x1/us.svg" class="h-7 w-7 rounded-lg" alt="">
                </div>

                <!-- Language Box -->
                <div v-if="languageMenu" class="py-1 w-32 bg-white mt-10 rounded absolute text-gray-600 text-sm cairo"
                    style="box-shadow: 0 0.25rem 1rem rgb(161 172 184 / 45%);">

                    <div @click="changeLanguage('ar')"
                        class="flex items-center justify-start px-4 my-1 h-10 hover:bg-gray-100 JF-Flat cursor-pointer"
                        style="color:#697a8d;">
                        <img src="http://localhost:3000/src/assets/png/ar.png" class="h-6 w-6 rounded-full" alt="">
                        <div class="w-2"></div>
                        <span>العربية</span>
                    </div>


                    <div @click="changeLanguage('en')"
                        class="flex items-center justify-start px-4 my-1 h-10 hover:bg-gray-100 JF-Flat cursor-pointer"
                        style="color:#697a8d;">
                        <img src="https://demos.themeselection.com/sneat-aspnet-core-admin-template/assets/vendor/fonts/flags/1x1/us.svg" class="h-6 w-6 rounded-full" alt="">
                        <div class="w-2"></div>
                        <span>English</span>
                    </div>

                </div>
                <!-- End Language Box -->

            </div>
            <div @click="toggleMenu"
                class="h-16 w-16 text-gray-600 flex items-center justify-center text-2xl hover:text-red-400 cursor-pointer md:hidden">
                <i class="fas fa-bars"></i>
            </div>
        </div>

    </div>
</template>

<script>
import language from "../../../lang/layout.json";
export default {
    data: function () {
        return {
            userMenu: false,
            t: language,
        };
    },
    methods: {
        toggleMenu() {
            this.$store.commit("toggleMenu");
        },
        toggleUserMenu: function () {
            this.userMenu = !this.userMenu;
        },
        toggleLanguageMenu: function () {
            this.$store.commit("toggleLanguageMenu");
        },
        logout: function () {
            this.$loading.Start();
            this.$http
                .Logout()
                .then(response => {
                    this.$loading.Stop();
                    this.$router.push("/admin/login");
                    this.$store.commit("clearUser");
                    localStorage.removeItem("token");
                    axios.defaults.headers.common["Authorization"] = null;
                    this.$alert.Success(response.data.message);
                })
                .catch(error => {
                    this.$loading.Stop();
                    this.$alert.BadRequest(error.response.data.message);
                });
        },
        toggleSideList: function (id) {
            this.$store.commit("toggllePageList", id);
        },
        // Change Language
        changeLanguage(language) {
            this.$store.commit("channgeLanguage",language);
        },
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        languageMenu() {
            return this.$store.state.languageMenu;
        },
        lang(){
            return this.$store.state.language;
        }
    }
};
</script>

<style>
.active-header-user {
    background: rgba(67, 89, 113, .04);
}
</style>
