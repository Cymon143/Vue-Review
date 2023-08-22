<template>
<div>
    <h1>teacher</h1>
    <br>{{search}}
</div>
</template>
<script>
    export default {
        props: {
            search: {required: true},
        },
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>
