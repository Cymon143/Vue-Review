<template>
<div v-if="!can('list schedule')">
    <forbidden/>
</div>
<div v-else>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        Encoding of Schedule: <strong> {{schedule_encoding.start|readableDate}} to {{schedule_encoding.end|readableDate}}</strong>
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
                                    <button class="btn btn-success btn-sm ml-auto" @click="openAddModal" v-if="can('create schedule')"
                                    :disabled="!encoding_schedule_period"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <div class="card-tools">
                                <button class="btn btn-success btn-sm ml-auto"><i class="far fa-print"></i> Print</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="btn btn-block btn-primary" style="pointer-events: none;">MONDAY</p>
                                    <div v-for="data in option_schedules.mon">
                                        <template-schedule @editData="editData" @getData="getData" :data="data" :canEdit="encoding_schedule_period"></template-schedule>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="btn btn-block btn-primary" style="pointer-events: none;">TUESDAY</p>
                                    <div v-for="data in option_schedules.tue">
                                        <template-schedule @editData="editData" @getData="getData" :data="data" :canEdit="encoding_schedule_period"></template-schedule>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="btn btn-block btn-primary" style="pointer-events: none;">WEDNESDAY</p>
                                    <div v-for="data in option_schedules.wed">
                                        <template-schedule @editData="editData" @getData="getData" :data="data" :canEdit="encoding_schedule_period"></template-schedule>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="btn btn-block btn-primary" style="pointer-events: none;">THURSDAY</p>
                                    <div v-for="data in option_schedules.thu">
                                        <template-schedule @editData="editData" @getData="getData" :data="data" :canEdit="encoding_schedule_period"></template-schedule>
                                    </div>
                                </div>
                                <div class="col">
                                    <p class="btn btn-block btn-primary" style="pointer-events: none;">FRIDAY</p>
                                    <div v-for="data in option_schedules.fri">
                                        <template-schedule @editData="editData" @getData="getData" :data="data" :canEdit="encoding_schedule_period"></template-schedule>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <add-modal @getData="getData"></add-modal>
    <edit-modal @getData="getData" :row="selected_edit"></edit-modal>
</div>
</template>
<script>
import addModal from "./AddSchedule.vue";
import editModal from "./EditSchedule.vue";
import templateSchedule from './TemplateSchedule.vue';
export default {
    components: {
        addModal,
        editModal,
        templateSchedule,
    },
    data() {
        return {
            option_schedules:[],
            selected_edit:[],
            encoding_schedule_period: false,
            schedule_encoding:[],
        }
    },
    methods: {
        editData(data){
            this.selected_edit = data;
        },
        preferableFormat(data){
            if(data){
                let dd = JSON.parse(data);
                let d = '';
                for (let index = 0; index < dd.length; index++) {
                    d = d+dd[index].name+(dd.length > index +1 ? ', ':'');
                }
                return d;
            }
        },
        openAddModal() {
            $('#add-schedule').modal('show');
        },
        getData(){
            this.option_schedules = [];
            axios.get('/api/schedule/list')
            .then(response => {
                this.option_schedules = response.data.data;
            });
        },
        loadEncodeSchedulePeriod(){
            this.option_sections = [];
            this.section = [];
            axios.get('/api/settings/period-schedule-encoding')
            .then(response => {
                this.encoding_schedule_period = response.data.data;
            });
        },
        loadScheduleEncoding(){
            axios.get('/api/settings/index-schedule-encoding')
            .then(response => {
                this.schedule_encoding = response.data.data;
            });
        },
    },
    created() {
        this.getData();
        this.loadEncodeSchedulePeriod();
        this.loadScheduleEncoding();
    },
}
</script>
