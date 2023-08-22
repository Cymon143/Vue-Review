<template>
    <div v-if="!can('list substitution')">
        <forbidden/>
    </div>
    <div v-else>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Substitution</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Substitution</a></li>
                            <!-- <li class="breadcrumb-item active">Starter Page</li> -->
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3 class="card-title"> </h3>
                            <div class="card-tools float-left">
                                <div class="input-group input-group-sm" >
                                    <select v-model="length" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="10">Row: 10</option>
                                        <option value="25">Row: 25</option>
                                        <option value="30">Row: 30</option>
                                    </select>
                                    <select v-model="order_by" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="">Order By</option>
                                        <option value="name">Name</option>
                                        <!-- <option value="status">status</option> -->
                                        <option value="created_at">Created</option>
                                    </select>
                                    <select v-model="sort_by" @change="getData" class="form-control form-control-sm w-auto">
                                        <option value="ASC">Asc</option>
                                        <option value="DESC">Desc</option>
                                    </select>
                                    <button class="btn btn-success btn-sm ml-auto" @click="openAddModal" v-if="can('create substitution')"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" >
                                    <input
                                        v-model="search" type="text" @keyup="getData"
                                        name="table_search"
                                        class="form-control float-right"
                                        placeholder="Search"
                                    />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" @click="getData">
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
                                        <th>Assigned Teacher</th>
                                        <th>Substitute Teacher</th>
                                        <th>Section</th>
                                        <th>Subject</th>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Date Substitute</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in option_users.data" :key="index">
                                        <td>{{data.assigned_teacher.name}}</td>
                                        <td>{{data.substitute_teacher.name}}</td>
                                        <td>{{data.schedule.section.code}}</td>
                                        <td>{{data.schedule.subject.code}}</td>
                                        <td>{{data.schedule.day}}</td>
                                        <td>{{data.schedule.time_start}} to {{data.schedule.time_end}}</td>
                                        <td>{{data.substitute_date|readableDate}}</td>
                                        <td v-html="statusFormat(data.status)"></td>
                                        <td class="text-right">
                                            <a :href="'/substitution-print-report/'+data.id" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Print</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <ul class="pagination pagination-sm m-1 float-left" v-if="this.option_users.total > 0">
                                <p class="m-1">Showing {{this.option_users.from}} to {{this.option_users.to}} of {{this.option_users.total}} results </p>
                            </ul>
                            <ul class="pagination pagination-sm m-1 float-right">
                                <li class="page-item" v-for="(link, index) in option_users.links" :key="index">
                                    <button v-html="link.label"
                                        @click="getData(link.url)"
                                        class="page-link"
                                        :disabled="link.url == null || link.active"
                                        :class="{'text-muted': link.url == null || link.active}">
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- declare the add modal -->
                <add-modal @getData="getData"></add-modal>
                <!-- declare the edit modal -->
                <edit-modal @getData="getData" :row="selected_user" :page="current_page"></edit-modal>
                </div>
            </div>
        </div>
    </div>
    </template>
    <script>
    import addModal from "./AddSubstitution.vue";
    import EditModal from "./EditSubstitution.vue";
    export default {
        components: {
            addModal,
            EditModal,
        },
        data() {
            return {
                order_by:'created_at',
                sort_by:'DESC',
                option_users:[],
                length:10,
                search:'',
                status:'',
                selected_user:[],
                current_page:[],
                form: new Form({
                    id:'',
                }),
                error:'',
            }
        },
        methods: {
            statusFormat(status){
                if(status == 'Completed'){
                    return '<small class="badge badge-success">Completed</small>'
                }
                else{
                    return '<small class="badge badge-danger">Pending</small>'
                }
            },
            openAddModal() {
                $('#add-substitution').modal('show');
            },
            openEditModal(data) {
                this.selected_user = data;
                $('#edit-substitution').modal('show');
            },
            getData(page){
                if (typeof page === 'undefined' || page.type == 'keyup'|| page.type == 'change'|| page.type == 'click') {
                    page = '/api/substitution/list/?page=1';
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
                            time_start: this.time_start,
                            time_end: this.time_end,
                            day: this.day,
                            section_id: this.section_id,
                            order_by: this.order_by,
                            sort_by: this.sort_by,
                            status: this.status,
                        },
                    })
                    .then(response => {
                        if(response.data.data){
                            this.option_users = response.data.data;
                        }
                    }).catch( error =>{
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
                        })
                    });
                }, 500);
            },
            remove(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/substitution/delete/'+id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.getData();
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
        created() {
            this.getData();
        },
    }
    </script>
