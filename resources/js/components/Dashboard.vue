<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">Calendar</div>

                    <div class="card-body">
                        <v-calendar class="custom-calendar"></v-calendar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selectedDate:null
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style scoped>
.custom-calendar.vc-container {
    --day-border: 1px solid #b8c2cc;
    --day-border-highlight: 1px solid #b8c2cc;
    --day-width: 90px;
    --day-height: 90px;
    --weekday-bg: #f8fafc;
    --weekday-border: 1px solid #eaeaea;
    border-radius: 0;
    width: 100%;
}
</style>
