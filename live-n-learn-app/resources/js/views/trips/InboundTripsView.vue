<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn - Hosting Programs</h5>
          </div>
          <div class="row ml-1">
            <div class="col-2">
              <div class="dropdown">
                <button
                  class="btn btn-secondary dropdown-toggle"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  {{ router.params.year ?? "Filter by Year" }}
                </button>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="/trips/inbound/view">2024</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/trips/inbound/view">2023</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/trips/inbound/view">2022</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table id="trips-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Location</th>
                  <th>Partner</th>
                  <th>Country of Origin</th>
                  <th>Max Participants</th>
                  <!-- <th>Registered Participants</th> -->
                  <th>Start Date</th>
                  <th>End Date</th>
                  <!-- <th>Local Coordinator(s)</th> -->
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
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
import { ref } from "vue";
import { useRoute } from "vue-router";

export default {
  name: "DataTables",
  setup() {
    const route = useRoute();

    const router = useRoute();

    let tripList = ref([]);
    let tripsRows = Array();

    //get trip list
    var newApiUrl = store.state.apiUrl + "inbound_program";
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

        const programs = [];

        result.data.inbound_programs.forEach(function (programItem) {
          let linkBtn =
            '<a class="btn btn-success" href="/trips/' +
            programItem.id +
            '"><i class="fa fa-plane" aria-hidden="true"></i> View Program Details</a>';

          let delBtn =
            '<a class="btn btn-warning" href="/trips/delete/' +
            programItem.id +
            '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';

          let program_location =
            programItem.program_location.city +
            ", " +
            programItem.program_location.state_province;

          let rowArray = new Array(
            program_location,
            programItem.inbound_partner.name,
            programItem.origin_country,
            programItem.available_seats + " Seats",
            programItem.start_date,
            programItem.end_date,
            linkBtn,
            delBtn
          );

          try {
            tripsRows.push(rowArray);
          } catch (err) {
            console.error(err.message);
          }
        });

        const dataTableSearch = new DataTable("#trips-search", {
          searchable: true,
          fixedHeight: true,
        });

        try {
          dataTableSearch.insert({ data: tripsRows });
        } catch (err) {
          console.error(err.message);
        }

        tripList.value = programs;
      })
      .catch((e) => {
        console.error(e);
      });

    return {
      router,
      tripList,
      tripsRows,
    };
  },
  methods: {},
  mounted() {},
};
</script>
