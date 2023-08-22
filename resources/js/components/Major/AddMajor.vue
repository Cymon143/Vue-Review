<template>
    <div class="modal fade" id="add-major">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Department</h5>
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
import Multiselect from 'vue-multiselect'
    export default {
        components: {
            Multiselect
        },
        data(){
            return{
                form: new Form({
                    name:'',
                    preferable:[],
                }),
                preferably:[],
                option_majors:[],
            }
        },
        methods: {
            create(){
                this.form.post('/api/major/create').then(()=>{
                    toast.fire({
                        icon: 'success',
                        text: 'Data Saved.',
                    })
                    this.form.reset();
                    this.$emit('getData');
                    this.loadMajors();
                    // $('#add-program').modal('hide');
                }).catch(()=>{
                    toast.fire({
                        icon: 'error',
                        text: 'Something went wrong!',
                    })
                });
            },
            loadMajors(){
                this.option_majors = [];
                axios.get('/api/major/all')
                .then(response => {
                    this.option_majors = response.data.data;
                });
            }
        },
        mounted() {
            this.loadMajors();
        }
    }
</script>

