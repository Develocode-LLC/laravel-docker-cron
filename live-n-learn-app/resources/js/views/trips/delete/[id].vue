<template>
    <div class="py-4 container-fluid">


    </div>
</template>

<script>
import { useRoute } from "vue-router";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";


export default {
    name: "DeleteTrip",
    setup() {
        const route = useRoute();
        const paramId = route.params.id;


        return {
            paramId
        }


    },
    methods: {
        deleteTrip(tripId){

            this.$router.push({ path: '/trips/view', replace: true });

        }

    }
    ,
    mounted() {
        //prepare delete url

        var newApiUrl = store.state.apiUrl + 'trip/' + this.paramId;

        console.log(newApiUrl);
        axios.delete(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;


            this.$router.push({ path: '/trips/view', replace: true });

            //window.location = '';

            this.$forceUpdate();



        }).catch(e => {


            console.error(e)
        })



    },
};
</script>
