<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">View Message</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to send a Message to anyone in the Live N' Learn Universe
                        </p>
                    </div>
                    <div class="row" style="margin:10px;">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="message_description">Author</label>
                                <input class="form-control" id="message_author" rows="3" required
                                    placeholder="Author" v-model="author" readonly />
                                
                            </div>
                            <div class="form-group">
                                <label for="message_description">Recipient</label>
                                <input class="form-control" id="message_recipient" rows="3" required
                                    placeholder="Recipient" v-model="recipient" readonly />
                                
                            </div>
                            <div class="form-group">
                                <label for="message_title">Subject</label>
                                <input type="text" class="form-control" id="message_subject" readonly placeholder="Subject"
                                    v-model="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message_description">Message</label>
                                <textarea class="form-control" id="message_content" rows="3" required
                                    placeholder="Message" readonly v-model="message"></textarea>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { DataTable } from "simple-datatables";
import axios from "axios";
import { useRoute } from "vue-router";
import store from "@/store/index.js";
import { ref } from "vue";

export default {
    name: "DataTables",
    setup() {

        const route = useRoute();
        const paramId = route.params.id;

        const recipient = ref("");
        const author = ref("");
        const subject = ref("");
        const message = ref("");

        //get trip Info
        var newApiUrl = store.state.apiUrl + "message/" + paramId;
        axios
            .get(newApiUrl, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.token,
                },
            })
            .then((result) => {
                author.value = result.data.user_message.author.full_name;
                recipient.value = result.data.user_message.recipient.full_name;
                subject.value = result.data.user_message.subject;
                message.value = result.data.user_message.message;
            })
            .catch((error) => {
                console.error(error);
            });

        return {
            author,
            recipient,
            subject,
            message
        }

    },
    data() {
        return {
            formdata: {
                subject: "",
                message_send_date: "",
                message: "",
                recipient: "",
                author: ""
            },
            showError: false,
            error: {
                message: ''
            },

        }

    },
    mounted() {
        // eslint-disable-next-line no-unused-vars

    },
};
</script>
