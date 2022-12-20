
import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainItem: [],
            loaded: 0, 
            // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
                        // Side Menu
                        sideMenuPage:{
                            main:5,
                            sub:1,
                        }
        };
    },
    methods: {
        activeAdmin: function() {
            Swal.fire({
                title: "هل أنت متأكد",
                text: "هل أنت متأكد من أنك تريد تفعيل هذا الحساب !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#16a085",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم تفعيل",
                cancelButtonText: "إلغاء"
            }).then(result => {
                if (result.isConfirmed) {
                    this.$loading.Start();
                    this.$http
                        .ActiveAdmin(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainItem.state = 1;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.loaded=204;
                                this.mainItem = [];
                                this.$alert.Empty(
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
        disActiveAdmin: function() {
            Swal.fire({
                title: "هل أنت متأكد",
                text: "هل أنت متأكد من أنك تريد الغاء تفعيل هذا الحساب !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#16a085",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم إلغاء التفعيل",
                cancelButtonText: "إلغاء"
            }).then(result => {
                if (result.isConfirmed) {
                    this.$loading.Start();
                    this.$http
                        .DisActiveAdmin(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainItem.state = 0;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.loaded=204;
                                this.mainItem = [];
                                this.$alert.Empty(
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
        bannedAdmin: function() {
            Swal.fire({
                title: "هل أنت متأكد",
                text:
                    "هل أنت متأكد من أنك تريد حظر هذا الحساب ؟ إذا قمت بحظر الحساب فلا يمكنك استخدامه مجددا",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#16a085",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم حظر الحساب",
                cancelButtonText: "إلغاء"
            }).then(result => {
                if (result.isConfirmed) {
                    this.$loading.Start();
                    this.$http
                        .BannedAdmin(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainItem.state = 2;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.loaded=204;
                                this.mainItem = [];
                                this.$alert.Empty(
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
        resetPassword: function() {
            Swal.fire({
                title: "هل أنت متأكد",
                text: "سيتم تغيير كلمة المرور لتصبح 123456",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#16a085",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم تغيير",
                cancelButtonText: "إلغاء"
            }).then(result => {
                if (result.isConfirmed) {
                    this.$loading.Start();
                    this.$http
                        .ResetAdminPassword(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.loaded=204;
                                this.mainItem = [];
                                this.$alert.Empty(
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
        deleteAdmin: function(id) {
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
                        .DeleteAdmin(this.$route.params.id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainItem = [];
                                this.loaded=204;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.mainItem = [];
                                this.loaded=204;
                                this.$alert.Empty(
                                    "لم يعد هذا الحساب متوفرة, قد يكون شخص أخر قام بحذفه"
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
            .GetAdminById(this.$route.params.id)
            .then(response => {
                this.$loading.Stop();
                this.loaded = true;
                if (response.status == 200) {
                    this.mainItem = response.data.data;
                    this.loaded=200;
                    this.$alert.Success(response.data.message);
                } else if (response.status == 204) {
                    this.loaded=204;
                    this.$alert.Empty("هذه الرسالة غير متوفرة");
                }
            })
            .catch(error => {
                this.$loading.Stop();
                this.loaded=404;
                this.loaded = true;
                this.$alert.BadRequest(error.response);
            });
    },
    computed: {},
    created() {}
};
