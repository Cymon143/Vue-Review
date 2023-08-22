<template>
<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th>Progress</th>
                <th style="width: 40px">Label</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>{{search}}</td>
                <td>
                <div class="progress progress-xs">
                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                </div>
                </td>
                <td><span class="badge bg-danger">55%</span></td>
            </tr>
        </tbody>
    </table>
</div>
</template>
<script>
    export default {
        props: {
            search: {required: true},
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
