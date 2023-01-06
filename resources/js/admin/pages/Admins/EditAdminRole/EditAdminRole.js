
export default {
    data() {
        return {
            mainItem: [],
            roles: [],
            loaded: 0,
                                    // Side Menu
            sideMenuPage:{
                main:5,
                sub:1,
            }
        };
    },
    methods: {
        reload:function(){
            this.loadData();
        },
        loadData:function(){
            this.$loading.Start();
            this.$http
            .GetAdminByIdWithPermissions(this.$route.params.id)
            .then(response => {
                this.$loading.Stop();
                if (response.status == 200) {
                    this.mainItem = response.data.data;
                    this.roles = response.data.roles;
                    this.loaded=200;
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.loaded=204;
                    this.$alert.Empty("هذه العنصر غير متوفرة");
                }
                else  {
                    this.loaded=400;
                    this.$alert.Empty(response.data.message);
                }
            })
            .catch(error => {
                this.loaded=404;
                this.$loading.Stop();
                this.$alert.BadRequest(error.response);
            });
        },
        updateAdminRole: function() {
            this.$loading.Start();
            this.$http
                .UpdateAdminRole(this.$route.params.id, {
                    role_id: this.mainItem.role_id
                })
                .then(response => {
                    this.$loading.Stop();
                    this.$alert.Success(response.data.message);
                })
                .catch(error => {
                    this.$loading.Stop();
                    this.$alert.BadRequest(error.response);
                });
        }
    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.loadData();
    },
    computed: {},
    created() {}
};
