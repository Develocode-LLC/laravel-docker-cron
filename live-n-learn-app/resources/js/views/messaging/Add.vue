<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Send Message</h5>
            <p class="mb-0 text-sm">
              Use this tool to send a Message to anyone in the Live N Learn
              Universe
            </p>
          </div>
          <div class="row" style="margin: 10px">
            <form @submit.prevent="submit">
              <div class="form-group">
                <label for="message_description">Select Recipient</label>
                <select
                  class="form-select"
                  id="message_description"
                  v-model="formdata.recipient"
                >
                  <option value="Select Recipient">Select Recipient</option>
                  <option
                    v-for="(name, id) in coordinatorsList"
                    :value="name.id"
                    :label="name.name"
                  >
                    {{ name.name }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="message_title">Subject</label>
                <input
                  type="text"
                  class="form-control"
                  id="message_title"
                  placeholder="Message Subject"
                  v-model="formdata.subject"
                  required
                />
              </div>
              <div class="form-group">
                <label for="message_description">Message</label>
                <textarea
                  class="form-control"
                  id="message_description"
                  rows="6"
                  required
                  placeholder="Enter Message Details Here"
                  v-model="formdata.message"
                ></textarea>
              </div>

              <div class="form-group">
                <label for="end_date">Message Send Date:</label>
                <input
                  type="date"
                  class="form-control"
                  id="registration_cutoff_date"
                  onfocus="this.showPicker()"
                  placeholder="Registration Cutoff Date"
                  v-model="formdata.message_send_date"
                  required
                />
              </div>

              <div v-if="showError" class="invalid-feedback2">
                {{ error.message }}
              </div>

              <button
                type="submit"
                @click="sendMessage()"
                class="btn bg-gradient-success"
              >
                <i class="fa fa-envelope" aria-hidden="true"></i> Schedule
                Message
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRoute } from "vue-router";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";

export default {
  name: "DataTables",
  setup() {
    const coordinatorsList = ref([]);

    //get user list
    var newApiUrl = store.state.apiUrl + "user";
    //var newApiUrl = store.state.apiUrl + 'user';
    axios
      .get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.token,
        },
      })
      .then((r) => {
        const result = r;

        const users = [];

        result.data.users.forEach(function (useritem) {
          coordinatorsList.value.push({
            id: useritem.id,
            name: useritem.full_name + " (" + useritem.class.replace(/_/g," ") + ")"
          });
        });
      })
      .catch((e) => {
        console.error(e);
      });

    return {
      formdata: {
        subject: "",
        message_send_date: "",
        message: "",
        recipient: "Select Recipient"
      },
      coordinatorsList,
      showError: false,
      error: {
        message: "",
      },
    };
  },
  methods: {
    sendMessage() {
      console.log(this.$store.state.apiUrl);
      console.log(this.formdata);
      console.log(localStorage.token);

      var newApiUrl = this.$store.state.apiUrl + "message";
      axios
        .post(
          newApiUrl,
          {
            subject: this.formdata.subject,
            message: this.formdata.message,
            recipient_id: this.formdata.recipient,
            message_send_date: this.formdata.message_send_date,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.token,
            },
          }
        )
        .then((r) => {
          const result = r.data;

          this.$router.push({ path: "/messaging/view", replace: true });
        })
        .catch((e) => {
          console.log(e.message);
          console.error(e.response.data);
          this.showError = true;
          this.error.message = e.response.data.message;
        });
    },
  },
  mounted() {
    // eslint-disable-next-line no-unused-vars
  },
};
</script>
