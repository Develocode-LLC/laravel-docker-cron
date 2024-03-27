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

        var newApiUrl = store.state.apiUrl + 'master_itinerary/' + this.paramId + '/duplicate';
        axios.post(newApiUrl, {}, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            //console.log(result.data.duplicate_itinerary.id);

            let duplicateId = result.data.duplicate_itinerary.id;

            this.$router.push({ path: '/itinerary/' + duplicateId, replace: true });



        }).catch(e => {


            console.error(e)
        })


    },
};
</script>
