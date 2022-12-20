
import Swal from "sweetalert2";
export default {
    data() {
        return {
            mainList: [],
            loaded: 0, // 0 not Loaded - 200 Load Success - 204 Empty - 400 Bad Request - 404 No Internet 
            tagId: null, //null =>All ,  1 => Active , 0 =>Not Active , 2=>Banned 
            pageId:1,
            countPerPage:5, 
            lastPage:0,
            totalRows:0,
            itemFrom:0,
            itemTo:0,
            // Search 
            phoneSrh:"",
            firstNameSrh:"",
            lastNameSrh:"",
            // UI
            optionId:0,
            // Side Menu
            sideMenuPage:{
                main:5,
                sub:1,
            }
        };
    },
    methods: {
        loadData: function(page) {
            this.pageId=page;
            this.$loading.Start();
            this.$http
                .GetAllAdmins(this.pageId,this.countPerPage,this.tagId,this.phoneSrh,this.firstNameSrh,this.lastNameSrh)
                .then(response => {
                    this.$loading.Stop();
                    if (response.status == 200) {
                        this.mainList = response.data.data.data;
                        this.lastPage = response.data.data.last_page;
                        this.totalRows = response.data.data.total;
                        this.itemFrom = response.data.data.from;
                        this.itemTo = response.data.data.to;
                        this.$alert.Success(response.data.message);
                        this.loaded=200;
                    } else if (response.status == 204) {
                        this.loaded=204;
                        this.$alert.Empty("تنبيه لا يوجد اي مشرفين");
                    }else{
                    this.loaded=400;
                    alert("400");
                    }
                })
                .catch(error => {
                    this.loaded=404;
                    this.$loading.Stop();
                    this.$alert.BadRequest(error.response);
                });
        },
        changeTag(tag) {
            this.tagId = tag;
            this.pageId=1;
            this.loadData(1);
        },
        changePerPage: function(event){
            this.countPerPage=event.target.value;
            this.pageId=1;
            this.loadData(this.pageId);
        },
        clearSearch:function(){
            this.phoneSrh="";
            this.firstNameSrh="";
            this.lastNameSrh="";
            this.loadData(this.pageId);
        },
        moveToNext: function(){
            this.pageId++;
            this.loadData(this.pageId);
        },
        moveToPrevius: function(){
            this.pageId--
            this.loadData(this.pageId);
        },
        openOptions: function(event){
            if(event.target.id==0){
                this.optionId=0;
            console.log(event.target.id);
            }else{
                this.optionId=event.target.id;
            console.log(event.target.id);
            }

        },
        activeAdmin: function(id, index) {
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
                        .ActiveAdmin(id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainList[this.mainList.findIndex(m => m.id === id)].state = 1;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
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
        disActiveAdmin: function(id, index) {
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
                        .DisActiveAdmin(id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainList[this.mainList.findIndex(m => m.id === id)].state = 0;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
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
                        .DeleteAdmin(id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainList.splice(this.mainList.findIndex(m => m.id === id), 1);
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
                                this.mainList.splice(this.mainList.findIndex(m => m.id === id), 1);
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
        bannedAdmin: function(id, index) {
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
                        .BannedAdmin(id)
                        .then(response => {
                            this.$loading.Stop();
                            if (response.status == 200) {
                                this.mainList[this.mainList.findIndex(m => m.id === id)].state = 2;
                                this.$alert.Success(response.data.message);
                            } else if (response.status == 204) {
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
        this.loadData(this.pageId);
    },
    computed: {
    },
    created() {}
};
