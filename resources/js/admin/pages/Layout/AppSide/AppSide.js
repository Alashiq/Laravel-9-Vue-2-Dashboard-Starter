
import { mapGetters, mapActions,mapMutations } from "vuex"

export default {
    data: function() {
        return {
        };
    },
    methods: {
        logout: function() {
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
        toggleSideList:function(id){
        this.$store.commit("toggllePageList", id);
        },
    },
    computed: {
        ...mapGetters(["user","language"]),
        pageList() {
            return this.$store.state.pageList;
        },
        pages() {
            return this.$store.state.pages;
        },
        pageActive() {
            return this.$store.state.pageActive;
        },
        subPageActive() {
            return this.$store.state.subPageActive;
        },
        openPageList() {
            return this.$store.state.openPageList;
        },
        menu() {
            return this.$store.state.menu;
        },
        lang(){
            return this.language;
        },
        t() {
            return this.$lang.Profile[this.language];
        }
    }
};
