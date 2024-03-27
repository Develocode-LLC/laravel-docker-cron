<template>
  <div class="py-4 container-fluid">

    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn Programs</h5>

          </div>
          <!-- <div class="row">
                <pre>{{ tripList }}</pre>
            </div> -->
          <div class="table-responsive">
            <table id="trips-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Trip Type</th>
                  <th>Trip Code</th>
                  <th>Destination</th>

                  <th>Beginning Date</th>
                  <th>End Date</th>
                  <th>Available Seats</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

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

    const route = useRoute();

    let tripList = ref([]);
    let tripsRows = Array();

    //get trip list
    var newApiUrl = store.state.apiUrl + 'trip';
    axios.get(newApiUrl, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.token
      }
    }).then(r => {
      const result = r;

      const programs = [];

      console.log(result.data.trips);

      result.data.trips.forEach(function (programItem) {

        let linkBtn = '<a class="btn btn-success" href="#trips/' + programItem.id + '"><i class="fa fa-plane" aria-hidden="true"></i> View Program Details</a>';

        let orig_city = '';
        let dest_city = '';

        if (programItem.origination != null) {
          orig_city = programItem.origination.city;
        }

        if (programItem.destinations != null) {
          for (let i = 0; i < programItem.destinations.length; i++) {

            if (dest_city > '') {

              dest_city = dest_city + ', ' + programItem.destinations[i].name;

            }
            else {

              dest_city = programItem.destinations[i].name;

            }

          }
        }


        let rowArray = new Array(programItem.title, programItem.type.toUpperCase(), programItem.code, dest_city, programItem.start_date, programItem.end_date, programItem.available_seats + " Seats", linkBtn);

        try {
          tripsRows.push(rowArray);
        }
        catch (err) {
          console.log(err.message);
        }

      });


      const dataTableSearch = new DataTable("#trips-search", {
        searchable: true,
        fixedHeight: true,
      });

      try {
        dataTableSearch.insert({ data: tripsRows });
      }
      catch (err) {
        console.log(err.message);
      }

      tripList.value = programs;


    }).catch(e => {


      console.error(e)
    })



    return {
      tripList,
      tripsRows
    }


  },
  methods: {


  }
  ,
  mounted() {


  },
};
</script>
