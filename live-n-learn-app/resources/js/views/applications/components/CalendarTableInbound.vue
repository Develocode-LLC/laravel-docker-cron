<template>
    <div id="calendar" class="calendar" data-bs-toggle="calendar"></div>
</template>

<script>
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import axios from "axios";
import store from "@/store/index.js";
import { reactive, ref } from "vue";
import { isProxy, toRaw } from "vue";

export default {
    name: "CalendarCard",
    setup() { },
    methods: {

    },
    mounted() {
        let calendarRows = reactive([]);

        //get flight list
        ///api/v1/flights
        var newApiUrl = store.state.apiUrl + "inbound_program_flights";
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
                console.log(result.data);
                result.data.departure_flights.forEach(function (flightItem) {

                    let arrIndex = flightItem.trip_id % 5;

                    let classColors = ['bg-gradient-primary', 'bg-gradient-success', 'bg-gradient-danger', 'bg-gradient-warning', 'bg-gradient-info'];

                    let rowArray = {
                        title: flightItem.inbound_program.origin_country + ' - ' + flightItem.inbound_program.program_location.name  + '\n(' + flightItem.airline_code + ' ' + flightItem.airline_flight_number + ': ' + flightItem.destination_airport.code + ' - ' + flightItem.origin_airport.code + ')',
                        description: flightItem.inbound_program.origin_country + ' - ' + flightItem.inbound_program.program_location.name,
                        start: flightItem.departure_date,
                        end: flightItem.departure_date,
                        className: classColors[arrIndex],
                        url: '/flights/inbound/' + flightItem.inbound_program_id
                    };

                    calendarRows.push(rowArray);
                });

                result.data.return_flights.forEach(function (flightItem) {

                    let arrIndex = flightItem.trip_id % 5;

                    let classColors = ['bg-gradient-primary', 'bg-gradient-success', 'bg-gradient-danger', 'bg-gradient-warning', 'bg-gradient-info'];

                    let rowArray = {
                        title: flightItem.inbound_program.origin_country + ' - ' + flightItem.inbound_program.program_location.name  + '\n(' + flightItem.airline_code + ' ' + flightItem.airline_flight_number + ': ' + flightItem.destination_airport.code + ' - ' + flightItem.origin_airport.code + ')',
                        description: flightItem.inbound_program.origin_country + ' - ' + flightItem.inbound_program.program_location.name,
                        start: flightItem.departure_date,
                        end: flightItem.departure_date,
                        className: classColors[arrIndex],
                        url: '/flights/inbound/' + flightItem.inbound_program_id
                    };

                    calendarRows.push(rowArray);
                });

                //console.log(JSON.parse(JSON.stringify(calendarRows)));

                var date = new Date();

                //render calendar
                var calendar = new Calendar(document.getElementById("calendar"), {
                    contentHeight: "auto",
                    plugins: [dayGridPlugin],
                    initialView: "dayGridMonth",
                    headerToolbar: {
                        start: "title", // will normally be on the left. if RTL, will be on the right
                        center: "",
                        end: "today prev,next", // will normally be on the right. if RTL, will be on the left
                    },
                    selectable: true,
                    editable: true,
                    initialDate: date.toISOString().substring(0, 10),
                    events: calendarRows,
                    views: {
                        month: {
                            titleFormat: {
                                month: "long",
                                year: "numeric",
                            },
                        },
                        agendaWeek: {
                            titleFormat: {
                                month: "long",
                                year: "numeric",
                                day: "numeric",
                            },
                        },
                        agendaDay: {
                            titleFormat: {
                                month: "short",
                                year: "numeric",
                                day: "numeric",
                            },
                        },
                    },
                });

                calendar.render();
            })
            .catch((e) => {
                console.error(e);
            });
    },
};
</script>
<style>
.fc-daygrid-event {
    white-space: normal !important;
    align-items: normal !important;
  }
</style>
