import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            formData: {
                first_name: '',
                last_name: '',

            },
            formValidate: {
                first_name: '',
                last_name: '',

            },
            loaded: 0,
            // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
            // Side Menu
            sideMenuPage: {
                main: 5,
                sub: 3,
            },
            errorMessage: "حدث خطأ ما",
        };
    },
    methods: {
        reload: function () {
            this.loadData();
        },
        loadData: function () {
            this.$loading.Start();
            this.$http
                .GetMemberById(this.$route.params.id)
                .then(response => {
                    this.$loading.Stop();
                    if (response.status == 200) {
                        this.mainItem = response.data.data;
                        this.formData.first_name = response.data.data.first_name;
                        this.formData.last_name = response.data.data.last_name;

                        this.loaded = 200;
                        this.$alert.Success(response.data.message);
                    } else if (response.status == 204) {
                        this.loaded = 204;
                        this.$alert.Empty("هذه الاستاذ غير متوفر");
                    }
                })
                .catch(error => {
                    this.$loading.Stop();
                    if (error.response.status == 400) {
                        this.errorMessage = error.response.data.message;
                        this.loaded = 400;
                        this.$alert.BadRequest(error.response.data.message);
                    } else if (error.response.status == 403) {
                        this.errorMessage = error.response.data.message;
                        this.loaded = 403;
                        this.$alert.BadRequest(error.response.data.message);
                    } else if (error.response.status == 401) {
                        this.$alert.NotAuth();
                    } else {
                        this.errorMessage = "حدث خطأ ما";
                        this.loaded = 404;
                        this.$alert.BadRequest("حدث خطأ ما, الرجاء إعادة المحاولة");
                    }
                });
        },
        editMainItem: function (id) {
            this.validateFirst_name();
            if (this.formValidate.first_name != '') return 0;
            this.validateLast_name();
            if (this.formValidate.last_name != '') return 0;

            // this.validateName();
            // if (this.formValidate.name != "") return 0;

            this.$loading.Start();
            this.$http
                .EditMember(this.$route.params.id, this.formData)
                .then(response => {
                    this.$loading.Stop();
                    if (response.status == 200) {
                        this.$alert.Success(response.data.message);
                    } else if (response.status == 204) {
                        this.mainItem = [];
                        this.loaded = 204;
                        this.$alert.Empty(
                            "لم يعد هذا الاستاذ متوفرة, قد يكون شخص أخر قام بحذفه"
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

        },
        validateName: function () {
            this.formValidate.name = "";
            if (this.formData.name.trim() == "") {
                this.formValidate.name = "لا يمكن ترك هذا الحقل فارغ";
                return 1;
            }
            if (this.formData.name.trim().length < 5) {
                this.formValidate.name = "يجب ان يكون الحقل 5 أحرف أو اكثر";
                return 1;
            }
            if (this.formData.name.trim().length > 16) {
                this.formValidate.name = "يجب ان يكون الحقل أقل من 16 حرف";
                return 1;
            }
        },
        validateFirst_name: function () { return 1; },
        validateLast_name: function () { return 1; },

    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.loadData();
    },
    computed: {},
    created() { }
};
