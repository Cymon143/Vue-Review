<template>
    <div class="modal fade" id="add-section">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Level-subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <alert-error v-else :form="form"></alert-error>
                    <div class="form-group">
                        <label>Level</label>
                        <select v-model="form.level" class="form-control"
                            @change="loadSubjects">
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
                        <label>Subject</label>
                        <multiselect
                            v-model="form.subject"
                            :options="option_subjects"
                            :multiple="false"
                            :close-on-select="true"
                            :preserve-search="true"
                            placeholder="Search subject"
                            label="name"
                            track-by="name"
                            :custom-label="subjectCustomLabel"
                            :preselect-first="true">
                        </multiselect>
                        <has-error :form="form" field="subjects_validate"/>
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
                subject:null,
                form: new Form({
                    subject:[],
                    level:7,
                }),
                option_subjects:[],
                error:'',
            }
        },
        methods: {
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
                this.form.post('/api/level-subject/create').then(()=>{
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
            }
        },
        mounted() {
            this.loadSubjects();
        }
    }
</script>

