import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            formData: {
                name: '',
qouta: '',
price: '',

            },
            formValidate: {
                name: '',
qouta: '',
price: '',

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
        reload:function () {
            this.loadData();
        },
        loadData:function(){
            this.$loading.Start();
            this.loaded = 200;
                    this.$loading.Stop();
            // this.$http
            //     .GetPlanNeeds()
            //     .then(response => {
            //         this.$loading.Stop();
            //         if (response.status == 200) {
            //             this.mainItem = response.data.data;
            //             //this.formData.name=response.data.data.name;
//this.formData.qouta=response.data.data.qouta;
//this.formData.price=response.data.data.price;

            //             this.loaded = 200;
            //             this.$alert.Success(response.data.message);
            //         } else if (response.status == 204) {
            //             this.loaded = 204;
            //             this.$alert.Empty("هذه الباقة غير متوفر");
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
            this.validateName();
 if (this.formValidate.name != '') return 0;
this.validateQouta();
 if (this.formValidate.qouta != '') return 0;
this.validatePrice();
 if (this.formValidate.price != '') return 0;


        this.$loading.Start();
            this.$http
            .PostNewPlan(this.formData)
            .then(response => {
                this.$loading.Stop();
                if (response.status == 200) {
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.mainItem = [];
                    this.loaded = 204;
                    this.$alert.Empty(
                        "لم يعد هذا الباقة متوفرة, قد يكون شخص أخر قام بحذفه"
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

        validateName: function() {return 1;},
validateQouta: function() {return 1;},
validatePrice: function() {return 1;},

    },
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        this.loadData();
    },
    computed: {},
    created() { }
};
