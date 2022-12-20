export default {
    data() {
        return {
            data: {
                todayVisitor:0,
                weekVisitor:0,
                monthVisitor:0,
                todayMessage:0,
                notSloveMessage:0,
                sloveMessage:0,
            },
            loaded:204, // 0 not load - 200 done - 204 empty 
            sideMenuPage:{
                main:2,
                sub:0,
            }
        };
    },
    methods: {},
    mounted() {
        this.$store.commit("activePage", this.sideMenuPage);
        // this.$loading.Start();
        // this.$http
        //     .GetHome()
        //     .then(response => {
        //         this.$loading.Stop();
        //         this.loaded = true;
        //         if (response.status == 200) {
        //             this.data = response.data.data;
        //             this.$alert.Success(response.data.message);
        //         } else if (response.status == 204) {
        //             this.$alert.Empty("لم نتمكن من جلب البيانات");
        //         }
        //     })
        //     .catch(error => {
        //         this.$loading.Stop();
        //         this.loaded = true;
        //         this.$alert.BadRequest(error.response);
        //     });
    },
    computed: {},
    created() {}
};