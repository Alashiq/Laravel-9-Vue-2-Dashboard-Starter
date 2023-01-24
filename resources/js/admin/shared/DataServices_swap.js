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






 // ============== Teacher Part =======================
GetAllTeachers(page,countPerPage,full_name,class_type) { 
return axios.get('/admin/api/teahcer?page=' + page + '&count=' + countPerPage+ '&full_name=' + full_name+ '&class_type=' + class_type);
}, 

DeleteTeacher(id){
return axios.delete('/admin/api/teahcer/' + id);
}, 
GetTeacherById(id){
return axios.get('/admin/api/teahcer/' + id);
}, 
PostNewTeacher(formData){
return axios.post('/admin/api/teahcer' + formData);
}, 
EditTeacher(id,formData){
return axios.put('/admin/api/teahcer/' + id , formData);
}, 



 // ============== Teacher Part =======================
GetAllTeacher(page,countPerPage,name) { 
return axios.get('/admin/api/teacher?page=' + page + '&count=' + countPerPage+ '&name=' + name);
}, 

DeleteTeacher(id){
return axios.delete('/admin/api/teacher/' + id);
}, 
GetTeacherById(id){
return axios.get('/admin/api/teacher/' + id);
}, 
PostNewTeacher(formData){
return axios.post('/admin/api/teacher' + formData);
}, 
EditTeacher(id,formData){
return axios.put('/admin/api/teacher/' + id , formData);
}, 



 // ============== Teacher Part =======================
GetAllTeachers(page,countPerPage,f_name) { 
return axios.get('/admin/api/teacher?page=' + page + '&count=' + countPerPage+ '&f_name=' + f_name);
}, 

DeleteTeacher(id){
return axios.delete('/admin/api/teacher/' + id);
}, 
GetTeacherById(id){
return axios.get('/admin/api/teacher/' + id);
}, 
PostNewTeacher(formData){
return axios.post('/admin/api/teacher' + formData);
}, 
EditTeacher(id,formData){
return axios.put('/admin/api/teacher/' + id , formData);
}, 



 // ============== Teacher Part =======================
GetAllTeachers(page,countPerPage,name,school) { 
return axios.get('/admin/api/teacher?page=' + page + '&count=' + countPerPage+ '&name=' + name+ '&school=' + school);
}, 

DeleteTeacher(id){
return axios.delete('/admin/api/teacher/' + id);
}, 
GetTeacherById(id){
return axios.get('/admin/api/teacher/' + id);
}, 
PostNewTeacher(formData){
return axios.post('/admin/api/teacher' + formData);
}, 
EditTeacher(id,formData){
return axios.put('/admin/api/teacher/' + id , formData);
}, 



 // ============== School Part =======================
GetAllSchools(page,countPerPage,name,city) { 
return axios.get('/admin/api/school?page=' + page + '&count=' + countPerPage+ '&name=' + name+ '&city=' + city);
}, 

DeleteSchool(id){
return axios.delete('/admin/api/school/' + id);
}, 
GetSchoolById(id){
return axios.get('/admin/api/school/' + id);
}, 
PostNewSchool(formData){
return axios.post('/admin/api/school' + formData);
}, 
EditSchool(id,formData){
return axios.put('/admin/api/school/' + id , formData);
}, 



 // ============== School Part =======================
GetAllSchools(page,countPerPage,name,city) { 
return axios.get('/admin/api/school?page=' + page + '&count=' + countPerPage+ '&name=' + name+ '&city=' + city);
}, 

DeleteSchool(id){
return axios.delete('/admin/api/school/' + id);
}, 
GetSchoolById(id){
return axios.get('/admin/api/school/' + id);
}, 
PostNewSchool(formData){
return axios.post('/admin/api/school' + formData);
}, 
EditSchool(id,formData){
return axios.put('/admin/api/school/' + id , formData);
}, 



 //xapi


    
};
