<template>
    <div class="modal fade" id="add-substitution">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Substitute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <alert-error v-else :form="form"></alert-error>
                    <div class="form-group">
                        <label>Teacher</label>
                        <multiselect
                            v-model="form.assigned_user"
                            :options="option_teachers"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Pick some"
                            label="name"
                            track-by="id"
                            :preselect-first="true"
                            :custom-label="teacherInfo"
                            @input="selectTeacher">
                        </multiselect>
                        <has-error :form="form" field="assigned_user"/>
                    </div>
                    <div class="form-group">
                        <div class="card">
                            <div class="card-header p-3">
                                <h3 class="card-title"> </h3>
                                <div class="card-tools float-left">
                                    <div class="input-group input-group-sm" >
                                        <select v-model="length" @change="loadTeacherSchedule" class="form-control form-control-sm w-auto">
                                            <option value="5">Row: 10</option>
                                            <option value="10">Row: 25</option>
                                            <option value="25">Row: 30</option>
                                        </select>
                                        <select v-model="table_search" @change="loadTeacherSchedule" class="form-control form-control-sm w-auto">
                                            <option value="section">Search by Section</option>
                                            <option value="subject">Search by Subject</option>
                                            <option value="time">Search by Time Start</option>
                                            <option value="day">Search by Day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" >
                                        <input
                                            v-model="search" type="text" @keyup="loadTeacherSchedule"
                                            name="table_search"
                                            class="form-control float-right"
                                            placeholder="Search subject code"
                                        />
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" @click="loadTeacherSchedule">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Section</th>
                                            <th>Subject</th>
                                            <th>Room</th>
                                            <th>Day</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(data, index) in option_teacher_schedules.data" :key="index">
                                            <td><input v-model="form.schedule" @change="changeSchedule" :value="data" type="radio"></td>
                                            <td>{{data.section.code}}</td>
                                            <td>{{data.subject.code}}</td>
                                            <td>{{data.room}}</td>
                                            <td>{{data.day|capitalizeWords}}</td>
                                            <td>{{data.time_start|readableTime}} to {{data.time_end|readableTime}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="pagination pagination-sm m-1 float-right">
                                    <li class="page-item" v-for="(link, index) in option_teacher_schedules.links" :key="index">
                                        <button v-html="link.label"
                                            @click="loadTeacherSchedule(link.url)"
                                            class="page-link"
                                            :disabled="link.url == null || link.active"
                                            :class="{'text-muted': link.url == null || link.active}">
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <has-error :form="form" field="subject"/>
                    </div>
                    <div class="form-group">
                        <label>Substitute Teacher</label>
                        <select v-model="form.substitute_user" class="form-control">
                            <option v-for="data in option_substitute_teachers" :value="data" :style="{'background-color': data.priority == 1 ? '#c5fcce' : '#fcfac5'}">
                                {{data.name}} [{{data.major.name}}]
                            </option>
                        </select>
                        <has-error :form="form" field="substitute_user"/>
                    </div>
                    <div class="form-group">
                        <label>Substitute</label>
                        <div class="d-flex justify-content-center">
                            <v-date-picker v-model="form.substitute_date" style="width: 70%;"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea v-model="form.reason" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Prepared By</label>
                                <input v-model="form.prepared_by" class="form-control" readonly type="text">
                            </div>
                            <div class="col">
                                <label>Approved by</label>
                                <input v-model="form.approved_by" class="form-control" type="text">
                            </div>
                            <div class="col">
                                <label>Pricipal</label>
                                <input v-model="form.principal" class="form-control" readonly type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="create">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
    export default {
        components: {
            Multiselect
        },
        data(){
            return{
                form: new Form({
                    assigned_user:[],
                    substitute_user:[],
                    schedule:'',
                    substitute_date:'',
                    reason:'',
                    approved_by:'',
                    prepared_by:'',
                    principal:'',
                }),
                principal:[],
                table_search:'section',
                search:'',
                length:5,
                option_subjects:[],
                option_teachers:[],
                option_substitute_teachers:[],
                option_teacher_schedules:[],
                error:'',
            }
        },
        methods: {
            changeSchedule(){
                this.loadAvailableSubstituteTeacher();
            },
            selectTeacher(){
                this.loadTeacherSchedule();
            },
            teacherInfo({ name, major }){
                return `${name} [${major.name}]`;
            },
            subjectCustomLabel({ code, name }){
                return `${code} - ${name}`;
            },
            create(){
                Swal.fire({
                    title: 'Please wait',
                    html: 'saving',
                    allowOutsideClick:false,
                });
                Swal.showLoading();
                this.form.post('/api/substitution/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.subject = [];
                    this.$emit('getData');
                    this.error = '';
                }).catch(error => {
                    this.error = error.response.data.errors;
                    toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });
                });
            },
            loadSubjects(){
                this.subject = null;
                this.option_subjects = [];
                axios.get('/api/subject/all-by-level/'+this.form.level)
                .then(response => {
                    this.option_subjects = response.data.data;
                });
            },
            loadTeacher(){
                axios.get('/api/user/all')
                .then(response => {
                    this.option_teachers = response.data.data;
                });
            },
            loadAvailableSubstituteTeacher(){
                axios.get('/api/user/all-available-teacher/'+this.form.assigned_user.id+'/'+this.form.schedule.id)
                .then(response => {
                    this.option_substitute_teachers = response.data.data;
                });
            },
            loadTeacherSchedule(page){
                if (typeof page === 'undefined' || page.type == 'keyup'|| page.type == 'change'|| page.type == 'click') {
                    page = '/api/schedule/teacher/?page=1';
                }
                this.current_page = page;
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.timer = setTimeout(() => {
                    axios.get(page, {
                        params: {
                            search: this.search,
                            length: this.length,
                            id: this.form.assigned_user.id,
                            table_search: this.table_search,
                        },
                    })
                    .then(response => {
                        if(response.data.data){
                            this.option_teacher_schedules = response.data.data;
                        }
                    }).catch( error =>{
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
                        })
                    });
                }, 300);
            },
            loadPrincipal(){
                axios.get('/api/settings/index-principal')
                .then(response => {
                    this.principal = response.data.data;
                    this.form.principal = this.principal.value;
                    this.form.prepared_by = this.$gate.current_log_in().name;
                });
            },
        },
        mounted() {
            this.loadSubjects();
            this.loadTeacher();
            this.loadPrincipal();
        }
    }
</script>

