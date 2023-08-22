<template>
    <div class="modal fade" id="add-schedule">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <div class="alert alert-danger alert-dismissible" v-else-if="error.conflict">
                        <h5><i class="icon fas fa-ban"></i> Conflict Schedule</h5>
                        <span v-for="error in error.conflict[0]">
                            Section: <strong>{{error.section.code}}</strong> | Teacher: <strong>{{error.teacher.name}}</strong> | Subject: <strong>{{error.subject.code}}</strong> | Day: <strong>{{error.day | capitalizeWords}}</strong> | time: <strong>{{error.time_start | readableTime}} to {{error.time_end | readableTime}}</strong> <br>
                        </span>
                    </div>
                    <alert-error v-else :form="form"></alert-error>
                    <div class="form-group">
                        <label>Level</label>
                        <select v-model="form.level" class="form-control"
                            @change="loadSection">
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
                        <label>Section</label>
                        <multiselect
                            v-model="section"
                            :options="option_sections"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Pick some"
                            label="name"
                            track-by="id"
                            :preselect-first="true"
                            :custom-label="sectionCustomLabel"
                            @input="changeSection">
                        </multiselect>
                        <has-error :form="form" field="section_id"/>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <multiselect
                            v-model="subject"
                            :options="option_subjects"
                            :multiple="false"
                            :close-on-select="true"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Pick some"
                            label="name"
                            track-by="id"
                            :preselect-first="true"
                            :custom-label="subjectCustomLabel"
                            @input="changeSubject">
                        </multiselect>
                        <has-error :form="form" field="subject_id"/>
                    </div>
                    <div class="form-group">
                        <label>Room</label>
                        <input v-model="form.room" type="text" class="form-control">
                        <has-error :form="form" field="room"/>
                    </div>
                    <div class="form-group">
                        <label>Day</label>
                        <select v-model="form.day" class="form-control">
                            <option value="mon">Monday</option>
                            <option value="tue">Tuesday</option>
                            <option value="wed">Wednesday</option>
                            <option value="thu">Thursday</option>
                            <option value="fri">Friday</option>
                        </select>
                        <has-error :form="form" field="day"/>
                    </div>
                    <div class="form-group">
                       <div class="row">
                        <div class="col-6">
                            <label>Time Start</label>
                            <input v-model="form.time_start"  min="06:00" max="17:30" required type="time" class="form-control">
                            <has-error :form="form" field="time_start"/>
                        </div>
                        <div class="col-6">
                            <label>Time End</label>
                            <input v-model="form.time_end" min="06:30" max="18:00" required type="time" class="form-control">
                            <has-error :form="form" field="time_end"/>
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
    export default {
        data(){
            return{
                section:[],
                subject:[],
                form: new Form({
                    time_start:'06:00',
                    time_end:'06:30',
                    section_id:'',
                    subject_id:'',
                    room:'',
                    day:'mon',
                    level:'7',
                }),
                option_sections:[],
                option_subjects: [],
                error:'',
            }
        },
        methods: {
            sectionCustomLabel({code, name, adviser}){
                return `${code} - ${name} [Adviser: ${adviser.name} - ${adviser.major.name}]`;
            },
            subjectCustomLabel({code, name}){
                return `${code} - ${name}`;
            },
            create(){
                Swal.fire({
                    title: 'Please wait',
                    html: 'saving',
                    allowOutsideClick:false,
                });
                Swal.showLoading();
                this.form.post('/api/schedule/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
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
            loadSection(){
                this.option_sections = [];
                this.section = [];
                axios.get('/api/section/all/'+this.form.level)
                .then(response => {
                    this.option_sections = response.data.data;
                });
            },
            changeSection(){
                this.form.section_id = this.section.id;
                this.subject = [];
                this.option_subjects = [];
                this.section.subjects.forEach(element => {
                    this.option_subjects.push(element.subject);
                });
            },
            changeSubject(){
                this.form.subject_id = this.subject.id;
            }
        },
        mounted() {
            this.loadSection();
        },
    }
</script>

