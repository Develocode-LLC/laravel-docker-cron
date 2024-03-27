<template>
  <div class="py-4 container-fluid">

    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn Trips</h5>
          </div>

          <div class="row ml-2">
            <div class="col-4">
                <a class="btn btn-success" href="#trips/add"><i class="fa fa-plane" aria-hidden="true"></i> Add New Outbound Trip </a>
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

export default {
  name: "DataTables",
  setup() {
      let tripList = ref([]);

      return {
        tripList
      }
  },
    methods: {
        async fetchTrips() {
            var newApiUrl = store.state.apiUrl + 'trip';

            await axios.get(newApiUrl, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {
                this.tripList = result.data.trips;
            }).catch(error => {
                console.error(error)
            })
        },
        async loadDataTable() {
            let tripRows = new Array();

            const tripSearchDatatable = new DataTable("#trips-search", {
                searchable: true,
                fixedHeight: true,
            });

            await this.fetchTrips();

            this.tripList.forEach((trip) => {

                let btnViewTrip =   `<a class="btn btn-success" href="/trips/${trip.id}">
                                        <i class="fa fa-plane" aria-hidden="true"></i> View Trip Details
                                    </a>`;

                let btnDeleteTrip =   `<a class="btn btn-warning" href="/trips/delete/${trip.id}">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </a>`;

                let orig_city = trip.origination != null ? trip.origination.city : '';
                let dest_city = trip.destinations.map(({name}) => name).join(', ');
                let rowArray = new Array(trip.title, trip.type.toUpperCase(), trip.code, orig_city, dest_city, trip.start_date, trip.end_date, `${trip.min_available_seats} Seats`, btnViewTrip, btnDeleteTrip);

                tripRows.push(rowArray);
            });

            console.log('trips');
            console.log(tripRows);

            tripSearchDatatable.insert({data: tripRows});
        }
    },
    async mounted() {
        await this.loadDataTable();
    }
};
</script>
<style>
.ml-1 {
  margin-left: 10px !important;
}
</style>
