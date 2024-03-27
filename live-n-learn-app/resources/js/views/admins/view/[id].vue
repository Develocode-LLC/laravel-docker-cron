<template>
    <div class="py-4 container-fluid">
        <HostFamily v-bind:id="paramId"></HostFamily>
    </div>
</template>

<script>
import { useRoute } from 'vue-router';
import axios from "axios";
import HostFamily from '@/views/admins/view/hosts.vue';

export default {
    components: {
        HostFamily
    },
    methods: {

    }
    ,
    setup() {
        const route = useRoute();
        const paramId = route.params.id;
        return {
            paramId
        }

    },
    mounted() {

    },
};
</script>
