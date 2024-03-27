<template>
    <div class="py-4 container-fluid">

        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Live N Learn - Flights</h5>

                    </div>

                    <div class="row ml-2">
                        <div class="col-4">
                            <a class="btn btn-success" href="/flights/add"><i class="fa fa-plus" aria-hidden="true"></i> Add
                                New Flight </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable-flights" class="table table-flush">
                            <thead class="thead-light">
                                <!-- Airline Flight Number Originating City Destination Departure Time Arrival Time -->
                                <tr>
                                    <th>Trip</th>
                                    <th>Airline</th>
                                    <th>Flight Number</th>
                                    <th>Originating City</th>
                                    <th>Destination</th>
                                    <th>Departure Time</th>
                                    <th>Arrival Time</th>
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
    inheritAttrs: false,
    setup() {

        let locationsList = ref([]);
        let locations = [];
        let flightRows = Array();

        //get flight list
        ///api/v1/flights
        var newApiUrl = store.state.apiUrl + 'trip_flights';
        console.log(newApiUrl);
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            console.log(result.data);

            result.data.departure_flights.forEach(function (flightItem) {

                let linkBtn = '<a class="btn btn-success" href="/flights/' + flightItem.trip_id + '"><i class="fa fa-plane" aria-hidden="true"></i> View Details</a>';

                console.log(flightItem.origin_airport_id.toString(), flightItem.destination_airport_id.toString());

                let origin_airport_id = flightItem.origin_airport_id.toString();

                let destination_airport_id = flightItem.destination_airport_id.toString();


                let rowArray = new Array(flightItem.trip.title, flightItem.airline, flightItem.airline_flight_number, flightItem.origin_airport.city, flightItem.destination_airport.city, flightItem.departure_date + ' ' + flightItem.departure_time, flightItem.arrival_date + ' ' + flightItem.arrival_time, linkBtn);

                try {
                    flightRows.push(rowArray);
                }
                catch (err) {
                    console.log(err.message);
                }


            });

            result.data.return_flights.forEach(function (flightItem) {

                let linkBtn = '<a class="btn btn-success" href="/flights/' + flightItem.trip_id + '"><i class="fa fa-plane" aria-hidden="true"></i> View Details</a>';

                console.log(flightItem.origin_airport_id.toString(), flightItem.destination_airport_id.toString());

                let origin_airport_id = flightItem.origin_airport_id.toString();

                let destination_airport_id = flightItem.destination_airport_id.toString();


                let rowArray = new Array(flightItem.trip.title, flightItem.airline, flightItem.airline_flight_number, flightItem.origin_airport.city, flightItem.destination_airport.city, flightItem.departure_date + ' ' + flightItem.departure_time, flightItem.arrival_date + ' ' + flightItem.arrival_time, linkBtn);

                try {
                    flightRows.push(rowArray);
                }
                catch (err) {
                    console.log(err.message);
                }


            });





            //return_flights

            const dataTableSearch = new DataTable("#datatable-flights", {
                searchable: true,
                fixedHeight: true,
            });

            try {
                dataTableSearch.insert({ data: flightRows });
            }
            catch (err) {
                console.log(err.message);
            }


        }).catch(e => {


            console.error(e)
        })







        return {
            locationsList,
            locations,
            flightRows
        }


    },
    methods: {



    }
    ,
    beforeRouteUpdate(to, from, next) {
        if (to.path !== from.path) {
            window.location = to.path;
        }
    },
    mounted() {

        this.$forceUpdate();


    },
};
</script>
<style>
.ml-2 {
    margin-left: 20px !important;
}
</style>
