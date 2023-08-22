<template>
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header border-bottom-0 bg-lightblue">
            Subject: <strong>{{data.subject.code}}</strong>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-12">
                    <h2 class="lead pt-1"><b>Section: {{data.section.name}}</b></h2>
                    <p class="text-muted text-sm">
                        <b>Adviser: </b> {{data.section.adviser.name}}
                    </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small">
                            <span class="fa-li"><i class="fas fa-layer-group"></i></span>
                            Grade: {{data.section.level | ordinal}}
                        </li>
                        <li class="small">
                            <span class="fa-li"><i class="far fa-map-marker-alt"></i></span>
                            Room: {{data.room}}
                        </li>
                        <li class="small">
                            <span class="fa-li"><i class="far fa-clock"></i></span>
                            {{data.time_start | readableTime}} to {{data.time_end | readableTime}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button class="btn btn-sm bg-danger float-left"
                    @click="remove"
                    :disabled="!canEdit">
                    <i class="fas fa-trash-can"></i>
                </button>
                <button class="btn btn-sm bg-teal disabled">
                    <i class="fas fa-eye"></i> View
                </button>
                <button class="btn btn-sm btn-primary"
                    @click="edit"
                    :disabled="!canEdit">
                    <i class="far fa-edit"></i> Edit
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import editModal from "./EditSchedule.vue";
export default {
    components: {
        editModal,
    },
    props: {
        data: {required: true},
        canEdit: {required: true},
    },
    methods: {
        edit(){
            this.$emit('editData', this.data);
            $('#edit-schedule').modal('show');
        },
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
                    axios.delete('/api/schedule/delete/'+this.data.id)
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
        }
    },
};
</script>
