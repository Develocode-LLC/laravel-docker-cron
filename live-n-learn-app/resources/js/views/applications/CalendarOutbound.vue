<template>
    <div class="py-4 container-fluid">
        <div class="row">
            <div class="col-12 ms-auto">

            </div>
            <div class="col-xl-9">
                <div class="card card-calendar">
                    <div class="p-3 card-body">
                        <calendar-table />
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="row">
                    <div class="mt-4 col-xl-12 col-md-6 mt-xl-0">
                        <div class="card">
                            <div class="p-3 pb-0 card-header">
                                <h6 class="mb-0">Upcoming Flights</h6>
                            </div>

                            <div v-for="flightInfo in flightRows" class="p-3 card-body border-radius-lg">
                                <div class="d-flex">
                                    <div>
                                        <div
                                            class="text-center shadow shadow-none icon icon-shape bg-danger-soft border-radius-md">
                                            <i :class="getDynamicClassColor(flightInfo.id)" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="numbers">
                                            <h6 class="mb-1 text-sm text-dark">{{ flightInfo.title }}</h6>
                                            <span class="text-sm"><b>{{ flightInfo.airline }} {{ flightInfo.flight_number
                                            }}</b></span>
                                            <br>


                                            <span class="text-sm">{{ flightInfo.origin_city }} - {{
                                                flightInfo.destination_city }}</span>
                                            <br>
                                            <span class="text-sm"><b>Departure:</b> {{ flightInfo.departure_date_time
                                            }}</span>
                                            <br>
                                            <span class="text-sm"><b>Arrival:</b> {{ flightInfo.arrival_date_time }}</span>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CalendarTable from "./components/CalendarTable.vue";
import EventsCard from "./components/EventsCard.vue";
import ProductivityChart from "./components/ProductivityChart.vue";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from 'vue';

export default {
    name: "Calendar",
    inheritAttrs: false,
    components: { CalendarTable, EventsCard, ProductivityChart },
    setup() {

        let flightRows = ref([]);

        //get flight list
        ///api/v1/flights
        var newApiUrl = store.state.apiUrl + 'trip_flights';
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


                let origin_airport_id = flightItem.origin_airport_id.toString();

                let destination_airport_id = flightItem.destination_airport_id.toString();


                let rowArray = { 'id': flightItem.trip_id, 'title': flightItem.trip.title, 'airline': flightItem.airline, 'flight_number': flightItem.airline_flight_number, 'origin_city': flightItem.origin_airport.city, 'destination_city': flightItem.destination_airport.city, 'departure_date_time': flightItem.departure_date + ' ' + flightItem.departure_time, 'arrival_date_time': flightItem.arrival_date + ' ' + flightItem.arrival_time, 'date': flightItem.departure_date };

                flightRows.value.push(rowArray);



            });

            result.data.return_flights.forEach(function (flightItem) {



                let origin_airport_id = flightItem.origin_airport_id.toString();

                let destination_airport_id = flightItem.destination_airport_id.toString();


                let rowArray = { 'id': flightItem.trip_id, 'title': flightItem.trip.title, 'airline': flightItem.airline, 'flight_number': flightItem.airline_flight_number, 'origin_city': flightItem.origin_airport.city, 'destination_city': flightItem.destination_airport.city, 'departure_date_time': flightItem.departure_date + ' ' + flightItem.departure_time, 'arrival_date_time': flightItem.arrival_date + ' ' + flightItem.arrival_time, 'date': flightItem.departure_date };

                flightRows.value.push(rowArray);



            });

            //sort array
            flightRows.value.sort((a, b) => a.date > b.date ? 1 : -1);





        }).catch(e => {


            console.error(e)
        })







        return {
            flightRows
        }


    },
    methods: {
        getDynamicClassColor(id) {

            let arrIndex = id % 5;

            let classColors = ['text-lg fa fa-plane text-primary text-gradient opacity-10', 'text-lg fa fa-plane text-success text-gradient opacity-10', 'text-lg fa fa-plane text-danger text-gradient opacity-10', 'text-lg fa fa-plane text-warning text-gradient opacity-10', 'text-lg fa fa-plane text-info text-gradient opacity-10'];

            return classColors[arrIndex];
        }
    }
};
</script>
