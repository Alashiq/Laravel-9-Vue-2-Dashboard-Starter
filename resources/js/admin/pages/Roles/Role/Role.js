
import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            loaded: 0,
            // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
            // Side Menu
            sideMenuPage: {
                main: 5,
                sub: 3,
            }
        };
    },
    methods: {
        deleteMainItem: function (id) {
            Swal.fire({
                title: "هل أنت متأكد",
                text: "هل أنت متأكد من أنك تريد حذف هذا الدور !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#16a085",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم حذف",
                cancelButtonText: "إلغاء"
            }).then(result => {
                if (result.isConfirmed) {
                    this.$loading.Start();
                    this.$http
                        .DeleteRole(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainItem = [];
                                this.loaded = 204;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.mainItem = [];
                                this.loaded = 204;
                                this.$alert.Empty(
                                    "لم يعد هذا الدور متوفرة, قد يكون شخص أخر قام بحذفه"
                                );
                            }
                            else if (response.status == 400) {
                                this.mainItem = [];
                                this.loaded = 204;
                                this.$alert.Empty(
                                    response.data.messageresponse.data.message
                                );
                            }
                        })
                        .catch(error => {
                            this.$loading.Stop();
                            this.$alert.BadRequest(error.response);
                        });
                }
            });
        },
    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.$loading.Start();
        this.$http
            .GetRoleById(this.$route.params.id)
            .then(response => {
                this.$loading.Stop();
                this.loaded = true;
                if (response.status == 200) {
                    this.mainItem = response.data.data;
                    this.loaded = 200;
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.loaded = 204;
                    this.$alert.Empty("هذه الدور غير متوفر");
                }
            })
            .catch(error => {
                this.$loading.Stop();
                this.loaded = 404;
                this.loaded = true;
                this.$alert.BadRequest(error.response);
            });
    },
    computed: {},
    created() { }
};
