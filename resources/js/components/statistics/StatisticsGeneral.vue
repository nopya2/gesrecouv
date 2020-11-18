<template>
</template>

<script>
    export default {
        props : [],
        mounted() {
        },
        data(){
            return{

            }
        },

        created(){

            if (window.localStorage.getItem('authUser')) {
                const authUser = JSON.parse(window.localStorage.getItem('authUser'))
                this.api_token = authUser.api_token
            }

        },

        methods: {

        }

    }
</script>
