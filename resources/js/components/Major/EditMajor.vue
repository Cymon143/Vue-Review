<template>
    <div class="modal fade" id="edit-major">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <alert-error :form="form"></alert-error>
                    <div class="form-group">
                        <label>Name</label>
                        <input v-model="form.name" type="text" class="form-control">
                        <has-error :form="form" field="name"/>
                    </div>
                    <div class="form-group">
                        <label>Preferable major/s</label>
                        <multiselect
                            v-model="form.preferable"
                            :options="option_majors"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Pick some"
                            label="name"
                            track-by="id"
                            :preselect-first="true"
                            :max="3">
                        </multiselect>
                        <has-error :form="form" field="preferable"/>
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
                    name:'',
                    preferable:[],
                }),
                preferably:[],
                option_majors:[],
            }
        },
        methods: {
            create(){
                this.form.put('/api/major/update/'+this.form.id).then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.loadMajors();
                    this.form.reset();
                    this.$emit('getData', this.page);
                    $('#edit-major').modal('hide');
                }).catch(()=>{
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
            loadMajors(){
                this.option_majors = [];
                axios.get('/api/major/all/'+this.form.id)
                .then(response => {
                    this.option_majors = response.data.data;
                });
            }
        },
        watch: {
            row: function(){
                this.form.fill(this.row);
                if(this.form.preferable){
                    this.form.preferable = JSON.parse(this.form.preferable);
                }
                this.loadMajors();
            }
        },
    }
</script>

