<template>
    <div class="modal fade" id="add-section">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Section test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <alert-error v-else :form="form"></alert-error>
                    <div class="form-group">
                        <label>Adviser</label>
                        <multiselect
                            v-model="form.adviser"
                            :options="option_adviser"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            :value="option_adviser.id"
                            placeholder="Pick some"
                            label="name"
                            track-by="id"
                            :preselect-first="true"
                            :custom-label="teacherInfo">
                        </multiselect>
                        <has-error :form="form" field="adviser"/>
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input v-model="form.code" type="text" class="form-control">
                        <has-error :form="form" field="code"/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name"/>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select v-model="form.level" class="form-control"
                            @change="loadSubjects"
                            :disable="form.subjects.length > 0">
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <has-error :form="form" field="level"/>
                    </div>
                    <div class="form-group">
                        <label>Subjects</label>
                        <multiselect
                            v-model="form.subjects"
                            :options="option_subjects"
                            :multiple="true"
                            :close-on-select="false"
                            :preserve-search="false"
                            placeholder="Subject"
                            label="name"
                            track-by="name"
                            :custom-label="subjectCustomLabel"
                            :preselect-first="true">
                        </multiselect>
                        <has-error :form="form" field="level"/>
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
                    adviser:[],
                    name:'',
                    code:'',
                    level:'7',
                    subjects:[],
                }),
                option_adviser:[],
                option_subjects:[],
                error_subject:'',
                error:'',
            }
        },
        methods: {
            subjectCustomLabel({code, name}){
                return `${code} - ${name}`;
            },
            teacherInfo({ name, major }){
                return `${name} [${major.name}]`;
            },
            create(){
                Swal.fire({
                    title: 'Please wait',
                    html: 'saving',
                    allowOutsideClick:false,
                })
                Swal.showLoading()
                this.form.post('/api/section/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData');
                    this.error = '';
                }).catch(error =>{
                    this.error = error.response.data.errors;
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
            loadAdviser(){
                axios.get('/api/user/all')
                .then(response => {
                    this.option_adviser = response.data.data;
                });
            },
            loadSubjects(){
                this.form.subjects = [];
                this.option_subjects = [];
                axios.get('/api/subject/all-by-level/'+this.form.level)
                .then(response => {
                    this.option_subjects = response.data.data;
                    this.loadSetlevelSubjects();
                });
            },
            loadSetlevelSubjects(){
                axios.get('/api/level-subject/set-level-subject/'+this.form.level)
                .then(response => {
                    let subjects = response.data.data;
                    subjects.forEach(element => {
                        this.form.subjects.push(element.subject);
                    });
                });
            },
        },
        mounted() {
            this.loadAdviser();
            this.loadSubjects();
        },

    }
</script>

