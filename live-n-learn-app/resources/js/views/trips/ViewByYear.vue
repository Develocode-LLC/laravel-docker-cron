<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn Trips</h5>
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
                    <a class="dropdown-item" href="/trips/2024">2024</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/trips/2023">2023</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/trips/2022">2022</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table id="trips-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Trip Type</th>
                  <th>Trip Code</th>
                  <th>Outbound City</th>
                  <th>Inbound City</th>
                  <th>Beginning Date</th>
                  <th>End Date</th>
                  <th>Available Seats</th>
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
    var newApiUrl = store.state.apiUrl + "trip";
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

        console.log(result.data.trips);

        result.data.trips.forEach(function (programItem) {
          let linkBtn =
            '<a class="btn btn-success" href="#trips/' +
            programItem.id +
            '"><i class="fa fa-plane" aria-hidden="true"></i> View Trip Details</a>';

          let delBtn =
            '<a class="btn btn-warning" href="#trips/delete/' +
            programItem.id +
            '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';

          let orig_city = "";
          let dest_city = "";

          if (programItem.origination != null) {
            orig_city = programItem.origination.city;
          }

          if (programItem.destinations != null) {
            for (let i = 0; i < programItem.destinations.length; i++) {
              if (dest_city > "") {
                dest_city = dest_city + ", " + programItem.destinations[i].name;
              } else {
                dest_city = programItem.destinations[i].name;
              }
            }
          }

          let rowArray = new Array(
            programItem.title,
            programItem.type.toUpperCase(),
            programItem.code,
            orig_city,
            dest_city,
            programItem.start_date,
            programItem.end_date,
            programItem.available_seats + " Seats",
            linkBtn,
            delBtn
          );

          try {
            tripsRows.push(rowArray);
          } catch (err) {
            console.log(err.message);
          }
        });

        const dataTableSearch = new DataTable("#trips-search", {
          searchable: true,
          fixedHeight: true,
        });

        try {
          dataTableSearch.insert({ data: tripsRows });
        } catch (err) {
          console.log(err.message);
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
<style>
.ml-1 {
  margin-left: 10px !important;
}
</style>
