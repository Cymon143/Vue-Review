<template>
    <div class="modal fade" id="edit-schedule">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible" v-if="error.duplicate">
                        {{error.duplicate[0]}}
                    </div>
                    <div class="alert alert-danger alert-dismissible" v-else-if="error.conflict">
                        <h5><i class="icon fas fa-ban"></i> Conflict Schedule</h5>
                        <span v-for="data in error.conflict[0]">
                            Section: <strong>{{data.section.code}}</strong> | Teacher: <strong>{{data.teacher.name}}</strong> | Subject: <strong>{{data.subject.code}}</strong> | Day: <strong>{{data.day | capitalizeWords}}</strong> | time: <strong>{{data.time_start | readableTime}} to {{data.time_end | readableTime}}</strong> <br>
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
                            <input v-model="form.time_start" min="06:00" max="17:30" required type="time" class="form-control">
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
                    <button type="button" class="btn btn-danger mr-auto" @click="remove()">Remove</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="update">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            row: {required: true},
        },
        data(){
            return{
                section:[],
                subject:[],
                form: new Form({
                    id:'',
                    time_start:'06:00',
                    time_end:'06:30',
                    section_id:'',
                    subject_id:'',
                    room:'',
                    day:'mon',
                    level:'7',
                    teacher_user_id:''
                }),
                option_sections:[],
                option_subjects: [],
                error:'',
            }
        },
        methods: {
            remove(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this schedule.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/schedule/delete/'+this.row.id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.$emit('getData');
                        })
                    }
                }).catch(() =>{
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
            sectionCustomLabel({code, name, adviser}){
                return `${code} - ${name} [Adviser: ${adviser.name} - ${adviser.major.name}]`;
            },
            subjectCustomLabel({code, name}){
                return `${code} - ${name}`;
            },
            update(){
                Swal.fire({
                    title: 'Please wait',
                    html: 'saving',
                    allowOutsideClick:false,
                });
                Swal.showLoading();
                this.form.put('/api/schedule/update/'+this.row.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.subject = [];
                    this.section = [];
                    this.$emit('getData');
                    this.error = '';
                    $('#edit-schedule').modal('hide');
                }).catch(error=>{
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
                let level = this.form.level ? this.form.level:this.row.section.level;
                if(level){
                    axios.get('/api/section/all/'+level)
                    .then(response => {
                        this.option_sections = response.data.data;
                        this.section = this.option_sections.find((data) => data.id == this.row.section_id);
                        this.changeSection();
                        this.subject = this.option_subjects.find((data) => data.id == this.row.subject_id);
                    });
                }
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
            },
        },
        watch: {
            row: function(){
                this.form.fill(this.row);
                this.form.level = this.row.section.level;
                this.loadSection();
                this.section = this.option_sections.find((data) => data.id == this.row.section_id);
            },
        },
    }
</script>

