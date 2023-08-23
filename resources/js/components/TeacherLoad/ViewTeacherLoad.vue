<template>
    <!-- Modal -->
    <div class="modal fade" id="modal-view-teacher-load" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">My Load</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <dl>
                                    <dt>Name</dt>
                                        <dd>{{row.name}}</dd>
                                    <dt>Hour/s</dt>
                                        <dd>{{total_hours}}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <dl>
                                    <dt>Substitute Status</dt>
                                        <dd>{{loads.status_substitute == 1 ? 'TRUE':'FALSE'}}</dd>
                                    <dt>Unit/s</dt>
                                        <dd>{{total_units.toFixed(1)}}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" style="width: 18px">#</th>
                                        <th class="align-middle">Section</th>
                                        <th class="align-middle">Subject</th>
                                        <th class="text-center align-middle">Unit/s</th>
                                        <th class="text-center align-middle">Hour/s</th>
                                        <th class="text-center align-middle">Room</th>
                                        <th class="text-center align-middle">Day</th>
                                        <th class="text-center align-middle">Time Start</th>
                                        <th class="text-center align-middle">Time End</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(schedule, index) in loads.schedules">
                                        <td class="text-center align-middle">{{index+1}}</td>
                                        <td class="align-middle">{{schedule.section.code}}</td>
                                        <td class="align-middle">{{schedule.subject.code}} - {{schedule.subject.name}}</td>
                                        <td class="text-center align-middle">{{schedule.subject.unit.toFixed(1)}}</td>
                                        <td class="text-center align-middle">{{moment('2023-01-01 '+ schedule.subject.hour)}}</td>
                                        <td class="text-center align-middle">{{schedule.room}}</td>
                                        <td class="text-center align-middle">{{schedule.day.toUpperCase() }}</td>
                                        <td class="text-center align-middle">{{moment('2023-01-01 '+schedule.time_start, 'H:mm a')}}</td>
                                        <td class="text-center align-middle">{{moment('2023-01-01 '+schedule.time_end, 'H:mm a')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: {
        row: { required: true },
    },
    data() {
        return {
            loads: [],
            adviser_loads: [],
        }
    },
    methods: {
        loadTeacherLoad(id) {
            axios.get('/api/teacher-load/loads/' + id)
                .then(response => {
                    this.loads = response.data.loads;
                    this.adviser_loads = response.data.adviser_loads;
                });
        },
        moment(date,format = 'H:mm'){
            return moment(date).format(format);
        }
    },
    watch: {
        row: function () {
            if (this.row.id) {
                this.loadTeacherLoad(this.row.id);
            }
        }
    },
    computed: {
        total_units: function(){
            var total = 0;
            if(this.loads.schedules){
                this.loads.schedules.forEach(e => {
                    total += parseFloat(e.subject.unit);
                });
            }
            return total;
        },
        total_hours: function(){
            var total = '2023-01-01 00:00:00';
            if(this.loads.schedules){
                this.loads.schedules.forEach(e => {
                    var hours = moment('2023-01-01 '+e.subject.hour);
                    total = moment(total).add(hours);
                });
            }
            return moment(total).format('H:mm');
        }
    },
}
</script>

<style lang="scss" scoped></style>
