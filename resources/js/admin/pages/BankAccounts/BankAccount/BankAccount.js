
import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            loaded: 0,
            // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
            // Side Menu
            sideMenuPage: {
                main: 12,
                sub: 1,
            },
            errorMessage: "حدث خطأ ما",
        };
    },
    methods: {
        reload:function () {
            this.loadData();
        },
        loadData:function(){
            this.$loading.Start();
            this.$http
            .GetBankAccountById(this.$route.params.id)
            .then(response => {
                this.$loading.Stop();
                if (response.status == 200) {
                    this.mainItem = response.data.data;
                    this.loaded = 200;
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.loaded = 204;
                    this.$alert.Empty("هذه الحساب غير متوفر");
                }
            })
            .catch(error => {
                this.$loading.Stop();
                if (error.response.status == 400) {
                    this.errorMessage=error.response.data.message;
                    this.loaded = 400;
                    this.$alert.BadRequest(error.response.data.message);
                } else if (error.response.status == 403) {
                    this.errorMessage=error.response.data.message;
                    this.loaded = 403;
                    this.$alert.BadRequest(error.response.data.message);
                } else if (error.response.status == 401) {
                    this.$alert.NotAuth();
                } else {
                    this.errorMessage="حدث خطأ ما";
                    this.loaded = 404;
                    this.$alert.BadRequest("حدث خطأ ما, الرجاء إعادة المحاولة");
                }
            });
        },
        deleteMainItem: function (id) {
            Swal.fire({
                title: "هل أنت متأكد",
                text: "هل أنت متأكد من أنك تريد حذف هذا الحساب !",
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
                        .DeleteBankAccount(this.$route.params.id)
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
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
                            this.$alert.BadRequest(error.response.data.message);
                        });
                }
            });
        },
    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.loadData();
    },
    computed: {},
    created() { }
};
