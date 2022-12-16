
export default {
    data() {
        return {
            mainItem: [],
            roles: [],
            loaded: 0
        };
    },
    methods: {
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
        this.$store.commit("activePage", 3);
        this.$loading.Start();
        this.$http
            .GetAdminByIdWithPermissions(this.$route.params.id)
            .then(response => {
                this.$loading.Stop();
                this.loaded = true;
                if (response.status == 200) {
                    this.loaded=200;
                    this.mainItem = response.data.data;
                    this.roles = response.data.roles;
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.loaded=204;
                    this.$alert.Empty("هذا المشرف غير موجود");
                }
            })
            .catch(error => {
                this.$loading.Stop();
                this.$alert.BadRequest(error.response);
            });
    },
    computed: {},
    created() {}
};
