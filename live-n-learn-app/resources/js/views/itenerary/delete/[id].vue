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
    setup() {
        const route = useRoute();
        const paramId = route.params.id;

        return {
        paramId

        }


    },
    methods: {

    }
    ,
    mounted() {

        var newApiUrl = store.state.apiUrl + 'master_itinerary/' + this.paramId;

        console.log(newApiUrl);
        axios.delete(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            //console.log(r);

            this.$router.push({ path: '/itinerary/view', replace: true });




        }).catch(e => {


            console.error(e)
        })


    },
};
</script>
