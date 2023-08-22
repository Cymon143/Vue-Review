<template>
    <div class="modal fade" id="edit-section">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <alert-error v-else :form="form"></alert-error>
                    <div class="form-group">
                        <label>Adviser</label>
                        <multiselect v-model="form.adviser" :options="option_adviser" :multiple="false" :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="id" :preselect-first="true"
                        :custom-label="teacherInfo">
                        </multiselect>
                        <has-error :form="form" field="preferable"/>
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
                            @change="loadSetlevelSubjects">
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
    export default {
        props: {
            row: {required: true},
            page: {required: true},
        },
        data(){
            return{
                form: new Form({
                    id:'',
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
                this.form.put('/api/section/update/'+this.form.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData', this.page);
                    $('#edit-section').modal('hide');
                }).catch(()=>{
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
                });
            },
            loadSetlevelSubjects(){
                this.form.subjects = [];
                axios.get('/api/level-subject/set-level-subject/'+this.form.level)
                .then(response => {
                    let subjects = response.data.data;
                    subjects.forEach(element => {
                        this.form.subjects.push(element.subject);
                    });
                });
            },
        },
        watch: {
            row: function(){
                this.loadSubjects();
                this.loadAdviser();
                this.form.fill(this.row);
                this.form.subjects = [];
                this.row.subjects.forEach(element => {
                    this.form.subjects.push(element.subject);
                });
            }
        },
    }
</script>

