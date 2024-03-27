<template>
    <div class="py-4 container-fluid">

      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Live N Learn - Messages</h5>

            </div>
            <div class="table-responsive">
              <table id="messages-search" class="table table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Subject</th>
                    <th>Send Date/Time</th>
                    <th>Receipients</th>
                    <th></th>

                  </tr>
                </thead>
                <tbody>
                  <!-- <tr>
                    <td class="text-sm font-weight-normal"><a href="#">Hello World</a></td>
                    <td class="text-sm font-weight-normal">11/01/2023</td>
                    <td class="text-sm font-weight-normal">yaw@develocode.com</td>
                    <td><a class="btn btn-success" href="#messaging/1">View Details</a></td>
                  </tr> -->

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { DataTable } from "simple-datatables";
  import axios from "axios";
  import store from "@/store/index.js";
  import { ref } from 'vue';
  import { useRoute } from 'vue-router';

  export default {
    name: "DataTables",
    setup() {

      const router = useRoute();

      let messageList = ref([]);
      let messageRows = Array();

      var newApiUrl = store.state.apiUrl + 'message';
      axios.get(newApiUrl, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.token
      }
    }).then(result => {

      const messages = [];

      console.log(result.data.user_messages);

      result.data.user_messages.forEach(function (message) {

        let viewButton = '<td><a class="btn btn-success" href="#messaging/' + message.id + '">View Details</a></td>'

        let rowArray = new Array(message.subject, message.message_send_date, message.recipient.full_name, viewButton);

        try {
          messageRows.push(rowArray);
        }
        catch (err) {
          console.log(err.message);
        }

      });

      const dataTableSearch = new DataTable("#messages-search", {
        searchable: true,
        fixedHeight: true,
      });

      try {
        dataTableSearch.insert({ data: messageRows });
      }
      catch (err) {
        console.log(err.message);
      }

      messageList.value = messages;


    }).catch(error => {
      console.error(error);
    });

    return {
      router,
      messageList,
      messageRows
    }

    },
    mounted() {

      // eslint-disable-next-line no-unused-vars
      // const dataTableSearch = new DataTable("#datatable-search", {
      //   searchable: true,
      //   fixedHeight: true,
      // });
    },
  };
  </script>
