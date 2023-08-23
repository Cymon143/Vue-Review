<template>
    <div class="modal fade" id="edit-subject">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Code</label>
                        <input v-model="form.code" type="text" class="form-control">
                        <has-error :form="form" field="code" />
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name" />
                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Text Disabled</label>
                                <input type="text" class="form-control" placeholder="Enter ..." disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hours</label>
                                <select v-model="form.hour" class="form-control">
                                    <option value="00" :disabled="form.minute == '00'">0 hour</option>
                                    <option value="01">1 hour</option>
                                    <option value="02">2 hours</option>
                                    <option value="03">3 hours</option>
                                    <option value="04">4 hours</option>
                                    <option value="05">5 hours</option>
                                </select>
                                <has-error :form="form" field="hour" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Minutes</label>
                                <select v-model="form.minute" class="form-control" @change="changeMinute">
                                    <option value="00" :disabled="form.hour == '00'">00 minute</option>
                                    <option value="10">10 minutes</option>
                                    <option value="15">15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                </select>
                                <has-error :form="form" field="minute" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <input v-model="form.unit" type="number" class="form-control">
                        <has-error :form="form" field="unit" />
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select v-model="form.level" class="form-control">
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <has-error :form="form" field="level" />
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
        row: { required: true },
        page: { required: true },
    },
    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                code: '',
                hour: '',
                minute: '',
                unit: '',
                level: '',
            }),
        }
    },
    methods: {
        create() {
            this.form.put('/api/subject/update/' + this.form.id).then(() => {
                toast.fire({
                    icon: 'success',
                    text: 'Data Saved.',
                })
                this.form.reset();
                this.$emit('getData', this.page);
                $('#edit-subject').modal('hide');
            }).catch(() => {
                toast.fire({
                    icon: 'error',
                    text: 'Something went wrong!',
                })
            });
        },
        changeMinute(){
            if(this.form.minute == '00' && this.form.hour == '00'){
                this.form.hour = '';
            }
        }
    },
    watch: {
        row: function () {
            this.form.fill(this.row);
            var split_hour_minute = this.form.hour.split(":");
            this.form.hour = split_hour_minute[0];
            this.form.minute = split_hour_minute[1];
        }
    },
}
</script>

