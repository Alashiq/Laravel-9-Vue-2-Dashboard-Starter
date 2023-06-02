import axios from "axios";
export default {
    // ============== Auth Part =======================
    Login(loginData) {
        return axios.post("/admin/api/login", loginData);
    },
    CheckToken() {
        return axios.get("/admin/api/auth/auth");
    },
    Logout() {
        return axios.get("/admin/api/logout");
    },
    ChangeName(formData) {
        return axios.post("/admin/api/auth/editName", formData);
    },
    ChangePassword(formData) {
        return axios.post("/admin/api/auth/editPassword", formData);
    },
    ChangePhoto(data, config) {
        return axios.post("/admin/api/auth/editPhoto", data, config);
    },
    // ============== Home Part =======================
    GetHome() {
        return axios.get("/admin/api/home");
    },

    
    // ============== Admin Part =======================
    GetAllAdmins(page,countPerPage,tag,phone,firstName,lastName) {
        return axios.get("/admin/api/admin?page=" + page + "&count=" + countPerPage + "&state=" + tag + "&phone=" + phone + "&first_name=" + firstName + "&last_name=" + lastName);
    },
    ActiveAdmin(admin) {
        return axios.put("/admin/api/admin/" + admin + "/active");
    },
    DisActiveAdmin(admin) {
        return axios.put("/admin/api/admin/" + admin + "/disActive");
    },
    DeleteAdmin(admin) {
        return axios.delete("/admin/api/admin/" + admin);
    },
    BannedAdmin(admin) {
        return axios.put("/admin/api/admin/" + admin + "/banned");
    },
    ResetAdminPassword(admin) {
        return axios.put("/admin/api/admin/" + admin + "/reset");
    },
    GetAdminById(admin) {
        return axios.get("/admin/api/admin/" + admin);
    },
    GetAdminByIdWithPermissions(admin) {
        return axios.get("/admin/api/admin/" + admin + "/withPermissions");
    },
    GetAdminRolesForNewAdmin() {
        return axios.get("/admin/api/admin/role");
    },
    PostNewAdmin(admin) {
        return axios.post("/admin/api/admin", admin);
    },
    UpdateAdminRole(admin, formData) {
        return axios.put("/admin/api/admin/" + admin + "/role", formData);
    },

    // ============== Role Part =======================
    GetAllRoles(page,countPerPage,name) {
        return axios.get("/admin/api/permission?page=" + page + "&count=" + countPerPage + "&name=" + name);
    },
    GetRoleById(role) {
        return axios.get("/admin/api/permission/" + role);
    },
    DeleteRole(role) {
        return axios.delete("/admin/api/permission/" + role);
    },
    GetAllPermissionsForNewRole() {
        return axios.get("/admin/api/permission/allPermissions");
    },
    PostNewRole(role) {
        return axios.post("/admin/api/permission", role);
    },
    EditRole(role, formData) {
        return axios.put("/admin/api/permission/" + role, formData);
    },





 // ============== Currency Part =======================
GetAllCurrencies(page,countPerPage,name,abbreviation) { 
return axios.get('/admin/api/currency?page=' + page + '&count=' + countPerPage+ '&name=' + name+ '&abbreviation=' + abbreviation);
}, 

DeleteCurrency(id){
return axios.delete('/admin/api/currency/' + id);
}, 
GetCurrencyById(id){
return axios.get('/admin/api/currency/' + id);
}, 
PostNewCurrency(formData){
return axios.post('/admin/api/currency' , formData);
}, 
EditCurrency(id,formData){
return axios.put('/admin/api/currency/' + id , formData);
}, 
GetCurrencyNew(){
return axios.get('/admin/api/currency/new');
}, 



 // ============== BankAccount Part =======================
GetAllBankAccounts(page,countPerPage,name,branch,account_number) { 
return axios.get('/admin/api/bankaccount?page=' + page + '&count=' + countPerPage+ '&name=' + name+ '&branch=' + branch+ '&account_number=' + account_number);
}, 

DeleteBankAccount(id){
return axios.delete('/admin/api/bankaccount/' + id);
}, 
GetBankAccountById(id){
return axios.get('/admin/api/bankaccount/' + id);
}, 
PostNewBankAccount(formData){
return axios.post('/admin/api/bankaccount' , formData);
}, 
EditBankAccount(id,formData){
return axios.put('/admin/api/bankaccount/' + id , formData);
}, 
GetBankAccountNew(){
return axios.get('/admin/api/bankaccount/new');
}, 



 //xapi


    
};
