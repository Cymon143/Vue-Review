<template>
<section class="content">
    <div class="container-fluid">
        <h2 class="text-center display-4">Search</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="input-group">
                    <!-- <div class="input-group-prepend">
                        <select v-model="length" @change="getData" class="form-control">
                            <option value="10">Row: 10</option>
                            <option value="25">Row: 25</option>
                            <option value="30">Row: 30</option>
                        </select>
                    </div> -->
                    
                    <input v-model="search" @keyup="getData" type="search" class="form-control" :placeholder="'Search by Teacher/Section...'">
                    <div class="input-group-append">
                        <button type="button" @click="getData" class="btn btn btn-primary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"></h3>
                        <div class="card-tools float-left">
                            <select v-model="length" @change="getData" class="form-control form-control-sm">
                                <option value="20">Row: 20</option>
                                <option value="30">Row: 30</option>
                                <option value="50">Row: 50</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Room</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>SY</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="option_search.data">
                                <tr v-for="(data, index) in option_search.data" :key="index">
                                    <td class="align-middle">{{data.section.code}} - <small>(Adv.:{{data.section.adviser.name|truncate(30)}})</small></td>
                                    <td class="align-middle">{{data.subject.code}} - {{data.subject.name|truncate(30)}}</td>
                                    <td class="align-middle">{{data.teacher.name|truncate(30)}}</td>
                                    <td class="align-middle">{{data.room|capitalizeWords}}</td>
                                    <td class="align-middle">{{data.day|capitalizeWords}}</td>
                                    <td class="align-middle">{{data.time_start|readableTime}} to {{data.time_end|readableTime}}</td>
                                    <td class="align-middle">{{data.school_year|schoolYear}}</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary btn-sm" @click="editData(data)">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8" class="text-center">-- No data found --</td>
                                </tr>
                            </tbody>
                        </table>
                        <ul class="pagination pagination-sm m-1 float-left" v-if="this.option_search.total > 0">
                            <p class="m-1">Showing {{this.option_search.from}} to {{this.option_search.to}} of {{this.option_search.total}} results </p>
                        </ul>
                        <ul class="pagination pagination-sm m-1 float-right">
                            <li class="page-item" v-for="(link, index) in option_search.links" :key="index">
                                <button v-html="link.label"
                                    @click="getData(link.url)"
                                    class="page-link"
                                    :disabled="link.url == null || link.active"
                                    :class="{'text-muted': link.url == null || link.active}">
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <edit-modal @getData="getData" :row="selected_edit"></edit-modal>
    </div>
</section>
</template>
<script>
import editModal from "../Schedule/EditSchedule.vue";
    export default {
        components: {
            editModal,
        },
        data() {
            return {
                search_by:'teacher',
                search:'',
                length:20,
                option_search:[],
                errors:'',
                selected_edit:[],
            }
        },
        methods: {
            editData(data){
                this.selected_edit = data;
                // console.log(data);
                $('#edit-schedule').modal('show');
            },
            changeSearchBy(){
                this.search = '';
            },
            getData(page){
                if (typeof page === 'undefined' || page.type == 'keyup'|| page.type == 'change'|| page.type == 'click') {
                    page = '/api/schedule/search/?page=1';
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
                        },
                    })
                    .then(response => {
                        if(response.data.data){
                            this.option_search = response.data.data;
                        }
                    }).catch( error =>{
                        this.error = error;
                        toast.fire({
                            icon: 'error',
                            text: error.response.data.message,
                        })
                    });
                }, 300);
            },
        },
    }
</script>
