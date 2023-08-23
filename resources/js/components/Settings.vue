<template>
<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">General Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col" v-if="can('substitution status settings')">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Substitution Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <button class="btn btn-danger" @click="clickResetSubstituteStatus"><i class="far fa-user-slash"></i> Reset Status</button>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" @click="saveSchoolYear">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="col" v-if="can('school year settings')">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">School Year</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Year</label>
                                        <div class="row">
                                            <div class="col">
                                                <input v-model="form.school_year.value" type="number" class="form-control"/>
                                            </div>
                                            <div class="col">
                                                <input :value="parseInt(form.school_year.value)+1" readonly type="text" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" @click="saveSchoolYear">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary" v-if="can('principal settings')">
                        <div class="card-header">
                            <h3 class="card-title">Principal</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.principal.value" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" @click="savePrincipal">Save</button>
                        </div>
                    </div>
                    <div class="row" v-if="can('school name settings')">
                        <div class="col">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Short School Name</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Name</label>
                                                <input v-model="form.short_school_name.value" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" @click="saveShortSchoolName">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">School Name</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label>Name</label>
                                                <input v-model="form.school_name.value" type="text" class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" @click="saveSchoolName">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Profile Image</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group text-center">
                                <div class="">
                                    <img :src="profile_image" width="250px" class="bg-info rounded-circle"/>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="file" @change="changeProfileImage"/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" @click="saveProfileImage">Save</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-primary" v-if="can('encoding of schedule settings')">
                        <div class="card-header">
                            <h3 class="card-title">Encoding of Schedule </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <v-date-picker v-model="form.schedule_encoding" is-range style="width:100%"/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" @click="saveScheduleEncoding">Save</button>
                        </div>
                    </div>
                    <div class="card card-primary" v-if="can('school logo settings')">
                        <div class="card-header">
                            <h3 class="card-title">School Logo</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group text-center">
                                <div class="">
                                    <img :src="image" width="250px"/>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="file" @change="changeSchoolLogo"/>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" @click="saveSchoolLogo">Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
</template>

<script>
export default {
    data() {
        return {
            schedule_encoding_id:'',
            form: new Form({
                school_year:[],
                schedule_encoding: {
                    id:'',
                    start: new Date(),
                    end: new Date(),
                },
                principal:{
                    id:'',
                    value:'',
                },
                short_school_name:{
                    id:'',
                    value:'',
                },
                school_name:{
                    id:'',
                    value:'',
                },
                school_logo:{
                    id:'',
                    value:'',
                },
                profile_image:{
                    id:'',
                    value:'',
                }
            }),
            image:'',
            profile_image:'',
        }
    },
    methods: {
        clickResetSubstituteStatus(){
            Swal.fire({
                title: 'Are you sure?',
                text: "All teacher substitution status will be reset.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it.'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get('/api/settings/reset-substitute-status')
                    .then(response => {
                        Swal.fire(
                            'Reset Status!',
                            'Successfully',
                            'success'
                        )
                    });
                }
            })

        },
        loadSchoolYear(){
            axios.get('/api/settings/index-school-year')
            .then(response => {
                this.form.school_year = response.data.data;
            });
        },
        saveSchoolYear(){
            this.form.put('/api/settings/update-school-year/'+this.form.school_year.id).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        loadScheduleEncoding(){
            axios.get('/api/settings/index-schedule-encoding')
            .then(response => {
                this.form.schedule_encoding = response.data.data;
                this.schedule_encoding_id = this.form.schedule_encoding.id;
            });
        },
        saveScheduleEncoding(){
            this.form.put('/api/settings/update-schedule-encoding/'+this.schedule_encoding_id).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        savePrincipal(){
            this.form.put('/api/settings/update-principal/'+this.form.principal.id).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        loadPrincipal(){
            axios.get('/api/settings/index-principal')
            .then(response => {
                this.form.principal = response.data.data;
            });
        },
        saveSchoolName(){
            this.form.put('/api/settings/update-school-name/'+this.form.school_name.id).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        loadShortSchoolName(){
            axios.get('/api/settings/index-short-school-name')
            .then(response => {
                this.form.short_school_name = response.data.data;
            });
        },
        saveShortSchoolName(){
            this.form.put('/api/settings/update-short-school-name/'+this.form.short_school_name.id).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        loadSchoolName(){
            axios.get('/api/settings/index-school-name')
            .then(response => {
                this.form.school_name = response.data.data;
            });
        },
        saveSchoolLogo(){
            this.form.post('/api/settings/update-school-logo',{
            headers: {
                "Content-Type": "multipart/form-data",
            }}).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        loadSchoolLogo(){
            axios.get('/api/settings/index-school-logo')
            .then(response => {
                this.form.school_logo = response.data.data;
                this.image = this.form.school_logo.value;
            });
        },
        changeSchoolLogo(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.form.school_logo.value = e.target.files[0];
            this.createImage(files[0]);
        },
        createImage(file) {
            var reader = new FileReader();
            var vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        saveProfileImage(){
            this.form.post('/api/settings/update-profile-image',{
            headers: {
                "Content-Type": "multipart/form-data",
            }}).then(()=>{
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                });
            })
        },
        changeProfileImage(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.form.profile_image.value = e.target.files[0];
            this.createProfileImage(files[0]);
        },
        createProfileImage(file) {
            var reader = new FileReader();
            var vm = this;
            reader.onload = (e) => {
                vm.profile_image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
    },
    mounted() {
        this.loadSchoolYear();
        this.loadScheduleEncoding();
        this.loadPrincipal();
        this.loadSchoolName();
        this.loadSchoolLogo();
        this.loadShortSchoolName();
        this.profile_image = this.$gate.current_log_in().image;
    },
};
</script>
<style scoped>
    .upload-image{
        width: 300px;
    }
</style>
