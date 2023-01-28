import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            formData: {
                //xcolumn
            },
            formValidate: {
                //xvalidate
            },
            loaded: 0,
            // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
            // Side Menu
            sideMenuPage: {
                main: xpageid,
                sub: 2,
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
            this.loaded = 200;
                    this.$loading.Stop();
            // this.$http
            //     .GetxmodelNeeds()
            //     .then(response => {
            //         this.$loading.Stop();
            //         if (response.status == 200) {
            //             this.mainItem = response.data.data;
            //             //xsetcolumn
            //             this.loaded = 200;
            //             this.$alert.Success(response.data.message);
            //         } else if (response.status == 204) {
            //             this.loaded = 204;
            //             this.$alert.Empty("هذه الxsinglearabic غير متوفر");
            //         }
            //     })
            //     .catch(error => {
            //         this.$loading.Stop();
            //         if (error.response.status == 400) {
            //             this.errorMessage=error.response.data.message;
            //             this.loaded = 400;
            //             this.$alert.BadRequest(error.response.data.message);
            //         } else if (error.response.status == 403) {
            //             this.errorMessage=error.response.data.message;
            //             this.loaded = 403;
            //             this.$alert.BadRequest(error.response.data.message);
            //         } else if (error.response.status == 401) {
            //             this.$alert.NotAuth();
            //         } else {
            //             this.errorMessage="حدث خطأ ما";
            //             this.loaded = 404;
            //             this.$alert.BadRequest("حدث خطأ ما, الرجاء إعادة المحاولة");
            //         }
            //     });
        },
        addNewItem: function () {
            //xcheckvalidatecolumn

        this.$loading.Start();
            this.$http
            .PostNewxmodel(this.formData)
            .then(response => {
                this.$loading.Stop();
                if (response.status == 200) {
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.mainItem = [];
                    this.loaded = 204;
                    this.$alert.Empty(
                        "لم يعد هذا الxsinglearabic متوفرة, قد يكون شخص أخر قام بحذفه"
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

        //xvalidatecolumn
    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.loadData();
    },
    computed: {},
    created() { }
};
