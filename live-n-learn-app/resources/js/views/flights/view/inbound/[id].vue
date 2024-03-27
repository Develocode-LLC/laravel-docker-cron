<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Update Inbound Program Flights</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to update Flights for an existing Program
                        </p>
                    </div>
                    <div class="row" style="margin: 10px">

                            <div class="form-group">
                                <label for="destination">Program Name</label>
                                <select class="form-select" v-model="trip_id">
                                    <option value="">Select Trip</option>
                                    <option v-for="(name, id) in tripsList" :value="name.id" :label="name.name">
                                        {{ name.name }}</option>
                                </select>

                            </div>
                            <div class="row">
                                <h5>Departure Flight</h5>
                            </div>
                            <div class="row" v-for="flightInfo in departureFlightData">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="origin_airport">Originating City</label>

                                            <select2 ref="origin_airport" :data="airportList" :value="parseInt(flightInfo.origin_airport.id)">
                                            </select2>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="destination_airport">Destination</label>
                                            <select2 ref="destination_airport" :data="airportList2" :value="parseInt(flightInfo.destination_airport.id)"></select2>

                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="airline">Airline</label>
                                    <select2 ref="dep_airline" :data="airlineList" :value="flightInfo.airline" allowClear="true" data-placeholder="All"></select2>

                                </div>


                                <div class="form-group">
                                    <label for="flight_number">Flight Number:</label>
                                    <input type="text" class="form-control" id="flight_number" ref="flight_number"
                                        placeholder="Flight Number" :value="flightInfo.airline_flight_number" required>
                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_date">Departure Date:</label>
                                            <input type="date" class="form-control" id="departure_date"
                                                onfocus="this.showPicker()" @change="populateArrivalDate()"
                                                ref="departure_date" :value="flightInfo.departure_date"
                                                placeholder="Departure Date" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_date">Arrival Date:</label>
                                            <input type="date" class="form-control" id="arrival_date"
                                                onfocus="this.showPicker()" :value="flightInfo.arrival_date"
                                                ref="arrival_date" placeholder="Arrival Date" required>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check" style="margin-top:30px;">
                                            <input class="form-check-input" type="checkbox" @change="checkSameDay()"
                                                value="" ref="same_day" id="flexCheckChecked" checked>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                Arrives Same Day
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_time">Departure Time:</label>
                                            <input class="form-control" type="time" id="departure_time" ref="departure_time"
                                                placeholder="Departure Time" step="3600" min="00:00" max="23:59"
                                                pattern="[0-2][0-9]:[0-5][0-9]"
                                                :value="flightInfo.departure_time" required />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_time">Arrival Time:</label>
                                            <input class="form-control" type="time" id="arrival_time" ref="arrival_time"
                                                placeholder="Arrival Time" step="3600" min="00:00" max="23:59"
                                                :value="flightInfo.arrival_time"
                                                pattern="[0-2][0-9]:[0-5][0-9]" required />
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" @click="removeDepatureFlight()"
                                            class="btn bg-gradient-warning"><i class="fa fa-minus" aria-hidden="true"></i>
                                            Remove Flight Leg</button>
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <button type="button" @click="addDepartureFlight()" class="btn bg-gradient-info"><i
                                            class="fa fa-plane" aria-hidden="true"></i> Add New Departure Flight
                                        Leg</button>
                                </div>
                            </div>


                            <div class="row">
                                <h5>Return Flight</h5>
                            </div>
                            <div class="row" v-for="flightInfo in returnFlightData">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="departure_city">Originating City</label>
                                            <select2 ref="ret_origin_airport" :data="airportList3" :value="flightInfo.origin_airport.id">
                                            </select2>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="destination">Destination</label>
                                            <select2 ref="ret_destination_airport" :data="airportList4" :value="flightInfo.destination_airport.id">
                                            </select2>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="airline">Airline</label>
                                    <select2 ref="ret_airline" :value="flightInfo.airline" :data="airlineList" >
                                    </select2>
                                </div>


                                <div class="form-group">
                                    <label for="flight_number">Flight Number:</label>
                                    <input type="text" class="form-control" id="flight_number" ref="ret_flight_number"
                                        placeholder="Flight Number" v-model="flightInfo.airline_flight_number"
                                        required>
                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_date">Departure Date:</label>
                                            <input type="date" class="form-control" id="departure_date"
                                                onfocus="this.showPicker()" @change="populateArrivalDate2()"
                                                ref="ret_departure_date" :value="flightInfo.departure_date"
                                                placeholder="Departure Date" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_date">Arrival Date:</label>
                                            <input type="date" class="form-control" id="arrival_date"
                                                onfocus="this.showPicker()" ref="ret_arrival_date"
                                                placeholder="Arrival Date" :value="flightInfo.arrival_date"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check" style="margin-top:30px;">
                                            <input class="form-check-input" type="checkbox" @change="checkSameDay2()"
                                                value="" v-model="same_day2" id="flexCheckChecked" checked>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                Arrives Same Day
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_time">Departure Time:</label>
                                            <input class="form-control" type="time" id="departure_time"
                                                ref="ret_departure_time" step="3600" min="00:00" max="23:59"
                                                pattern="[0-2][0-9]:[0-5][0-9]" placeholder="Departure Time"
                                                :value="flightInfo.departure_time" required />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_time">Arrival Time:</label>
                                            <input class="form-control" type="time" id="arrival_time" ref="ret_arrival_time"
                                                placeholder="Arrival Time" step="3600" min="00:00" max="23:59"
                                                pattern="[0-2][0-9]:[0-5][0-9]"
                                                :value="flightInfo.arrival_time" required />
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <button type="button" @click="removeReturnFlight()"
                                            class="btn bg-gradient-warning"><i class="fa fa-minus" aria-hidden="true"></i>
                                            Remove Flight Leg</button>
                                    </div>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <button type="button" @click="addReturnFlight()" class="btn bg-gradient-info"><i
                                            class="fa fa-plane" aria-hidden="true"></i> Add New Return Flight Leg</button>
                                </div>
                            </div>


                            <div v-if="showError" class="invalid-feedback-flight-add">
                                {{ error.message }}
                            </div>
                            <button type="submit" class="btn bg-gradient-success" @click.prevent="UpdateFlights()">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                                Update Program Flights
                            </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useRoute } from 'vue-router';
import axios from "axios";
import store from "@/store/index.js";
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";
import { DataTable } from "simple-datatables";
import { Select2 } from "select2-vue-component";
import { reactive, ref } from "vue";


export default {
    el: '#tabs',
    inheritAttrs: false,
    components: {
        VsudAlert,
        VsudSnackbar,
        Select2
    },
    data() {
        return {
            activetab: '1',
            snackbar: null,
        }
    },
    setup() {
        let tripsList = ref([]);
        let originating_airports = [];
        let destination_airports = [];
        let airportList = ref([]);
        let airportList2 = ref([]);
        let airportList3 = ref([]);
        let airportList4 = ref([]);



        let departureFlightData = reactive([]);
        let departureFlightData2 = reactive([]);
        let returnFlightData = reactive([]);
        let trip_id = ref("");
        const route = useRoute();
        const paramId = route.params.id;

        let departureFlightTotal = ref(1);
        let returnFlightTotal = ref(1);

        //get flight details for program
        var newApiUrl = store.state.apiUrl + 'inbound_program/' + paramId + '/inbound_program_flight';
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
            //departureFlightTotal.value = result.data.departure_flights.length;
            //returnFlightTotal.value = result.data.return_flights.length;




            result.data.departure_flights.forEach((flightItem, index) => {

                departureFlightData.push(flightItem);
                departureFlightData2.push(flightItem);
                //console.log(flightItem);
            })


            result.data.return_flights.forEach((flightItem, index) => {

                returnFlightData.push(flightItem);
            //console.log(flightItem);
            })


            //console.log(departureFlightData);
            //console.log(returnFlightData);



            //console.log(result.data.return_flights);

            trip_id.value = result.data.departure_flights[0].inbound_program_id;

        }).catch(e => {


            console.error(e)
        })



        let airlineList = [{ label: 'Choose Airline', value: '0' }, { label: 'Aegean Airlines', value: 'Aegean Airlines' }, { label: 'Aer Lingus', value: 'Aer Lingus' }, { label: 'Aeroflot', value: 'Aeroflot' }, { label: 'Aerolineas Argentinas', value: 'Aerolineas Argentinas' }, { label: 'Aeromexico', value: 'Aeromexico' }, { label: 'Air Arabia', value: 'Air Arabia' }, { label: 'Air Astana', value: 'Air Astana' }, { label: 'Air Austral', value: 'Air Austral' }, { label: 'Air Baltic', value: 'Air Baltic' }, { label: 'Air Belgium', value: 'Air Belgium' }, { label: 'Air Canada', value: 'Air Canada' }, { label: 'Air Caraibes', value: 'Air Caraibes' }, { label: 'Air China', value: 'Air China' }, { label: 'Air Corsica', value: 'Air Corsica' }, { label: 'Air Dolomiti', value: 'Air Dolomiti' }, { label: 'Air Europa', value: 'Air Europa' }, { label: 'Air France', value: 'Air France' }, { label: 'Air India', value: 'Air India' }, { label: 'Alaska Airlines', value: 'Alaska Airlines' }, { label: 'Alitalia', value: 'Alitalia' }, { label: 'Allegiant', value: 'Allegiant' }, { label: 'American Airlines', value: 'American Airlines' }, { label: 'British Airways', value: 'British Airways' }, { label: 'Brussels Airlines', value: 'Brussels Airlines' }, { label: 'Cathay Pacific', value: 'Cathay Pacific' }, { label: 'China Airlines', value: 'China Airlines' }, { label: 'Delta', value: 'Delta' }, { label: 'easyJet', value: 'easyJet' }, { label: 'Egyptair', value: 'Egyptair' }, { label: 'Emirates', value: 'Emirates' }, { label: 'Ethiopian Airlines', value: 'Ethiopian Airlines' }, { label: 'Etihad', value: 'Etihad' }, { label: 'flydubai', value: 'flydubai' }, { label: 'Gulf Air', value: 'Gulf Air' }, { label: 'Hawaiian Airlines', value: 'Hawaiian Airlines' }, { label: 'Hong Kong Airlines', value: 'Hong Kong Airlines' }, { label: 'Japan Airlines', value: 'Japan Airlines' }, { label: 'JetBlue', value: 'JetBlue' }, { label: 'KLM', value: 'KLM' }, { label: 'Korean Air', value: 'Korean Air' }, { label: 'Lufthansa', value: 'Lufthansa' }, { label: 'Qatar Airways', value: 'Qatar Airways' }, { label: 'Regional Express', value: 'Regional Express' }, { label: 'Ryanair', value: 'Ryanair' }, { label: 'Saudia', value: 'Saudia' }, { label: 'Singapore Airlines', value: 'Singapore Airlines' }, { label: 'South African Airways', value: 'South African Airways' }, { label: 'Southwest', value: 'Southwest' }, { label: 'Spirit', value: 'Spirit' }, { label: 'SWISS', value: 'SWISS' }, { label: 'Turkish Airlines', value: 'Turkish Airlines' }, { label: 'United', value: 'United' }, { label: 'Virgin Atlantic', value: 'Virgin Atlantic' }];

        //get trip list
        var newApiUrl = store.state.apiUrl + 'inbound_program';
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            console.log(result.data);

            result.data.inbound_programs.forEach((tripItem, index) => {

                try {
                    tripsList.value.push({ id: tripItem.id, name: tripItem.origin_country + ' - ' + tripItem.program_location.city });
                }
                catch (err) {
                    console.log(err.message);
                }




            })


        }).catch(e => {


            console.error(e)
        })



        //get Airport list
        var newApiUrl = store.state.apiUrl + 'airport';
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            result.data.airports.forEach((airportItem, index) => {

                    airportList.value.push({ value: parseInt(airportItem.id), label: airportItem.code + ' - ' + airportItem.city });


            })



            //need different array for each select2
            airportList2.value = airportList.value;
            airportList3.value = airportList.value;
            airportList4.value = airportList.value;




        }).catch(e => {


            console.error(e)
        })



        return {
            departureFlightData,
            departureFlightData2,
            returnFlightData,
            trip_id,
            tripsList,
            airlineList,
            airportList,
            airportList2,
            airportList3,
            airportList4,
            departureFlightTotal,
            returnFlightTotal,
            flight_number: "",
            arrival_time: "",
            departure_time: "",
            arrival_date: "",
            departure_date: "",
            "same_day": true,
            flight_number2: "",
            arrival_time2: "",
            departure_time2: "",
            arrival_date2: "",
            departure_date2: "",
            "same_day2": true,
            showError: false,
            error: {
                message: "",
            }

        }


    },
    methods: {
        addFlight() {

            for (let i = 0; i < this.departureFlightTotal; i++) {

                let flight_leg = i + 1;

                let leg_trip_type = "departure";

                let departure_date = this.$refs.departure_date[i].value;

                let arrival_date = this.$refs.arrival_date[i].value;

                let origin_airport = this.$refs.origin_airport[i].$data.hoveringValue;

                let destination_airport = this.$refs.destination_airport[i].$data.hoveringValue;

                let departure_time = this.$refs.departure_time[i].value;
                let arrival_time = this.$refs.arrival_time[i].value;

                let flight_number = this.$refs.flight_number[i].value;

                let airline = this.$refs.dep_airline[i].$data.hoveringValue;//dep_airline

                this.addFlightLeg(this.trip_id, flight_leg, leg_trip_type, airline, flight_number, origin_airport, destination_airport, departure_date, arrival_date, departure_time, arrival_time);

            }



            for (let i = 0; i < this.returnFlightTotal; i++) {

                let flight_leg = i + 1;

                let leg_trip_type = "return";

                let departure_date = this.$refs.ret_departure_date[i].value;

                let arrival_date = this.$refs.ret_arrival_date[i].value;

                let origin_airport = this.$refs.ret_origin_airport[i].$data.hoveringValue;

                let destination_airport = this.$refs.ret_destination_airport[i].$data.hoveringValue;

                let departure_time = this.$refs.ret_departure_time[i].value;
                let arrival_time = this.$refs.ret_arrival_time[i].value;

                let flight_number = this.$refs.ret_flight_number[i].value;

                let airline = this.$refs.ret_airline[i].$data.hoveringValue;//dep_airline

                //console.log(airline, flight_leg, this.trip_id, leg_trip_type, departure_date, arrival_date, origin_airport, destination_airport, departure_time, arrival_time, flight_number);

                this.addFlightLeg(this.trip_id, flight_leg, leg_trip_type, airline, flight_number, origin_airport, destination_airport, departure_date, arrival_date, departure_time, arrival_time);



            }

            this.$router.push({ path: "/flights/view", replace: true });
            this.$forceUpdate();

        },
        addDepartureFlight() {
            if (this.departureFlightTotal > 0) {
                this.departureFlightTotal = this.departureFlightTotal + 1;
                this.$forceUpdate();
            }
        },
        removeDepatureFlight() {
            if (this.departureFlightTotal > 1) {
                this.departureFlightTotal = this.departureFlightTotal - 1;
                this.$forceUpdate();
            }
        },
        addReturnFlight() {
            if (this.returnFlightTotal > 0) {
                this.returnFlightTotal = this.returnFlightTotal + 1;
                this.$forceUpdate();
            }
        },
        removeReturnFlight() {
            if (this.returnFlightTotal > 1) {
                this.returnFlightTotal = this.returnFlightTotal - 1;
                this.$forceUpdate();
            }

        },
        checkSameDay() {
            if (this.same_day == false) {
                this.arrival_date = "";
                this.$forceUpdate();
            }
        },
        populateArrivalDate() {
            console.log('Here');
            console.log(this.same_day);
            console.log(this.departure_date);
            if (this.same_day == true) {

                this.arrival_date = this.departure_date;
                this.$forceUpdate();

            }

        },
        checkSameDay2() {
            if (this.same_day2 == false) {
                this.arrival_date2 = "";
                this.$forceUpdate();
            }
        },
        populateArrivalDate2() {
            console.log('Here');
            console.log(this.same_day2);
            console.log(this.departure_date2);
            if (this.same_day2 == true) {

                this.arrival_date2 = this.departure_date2;
                this.$forceUpdate();

            }

        },
        addFlightLeg(trip_id, flight_index, leg_type, airline, flight_number, origin_airport_id, dest_airport_id, departure_date, arrival_date, departure_time, arrival_time) {

            var newApiUrl = store.state.apiUrl + 'trip/' + trip_id + '/trip_flight';
            axios.post(newApiUrl, {
                "flight_index": flight_index,
                "type": leg_type,
                "airline": airline,
                "airline_code": airline,
                "airline_flight_number": flight_number,
                "origin_airport_id": origin_airport_id,
                "destination_airport_id": dest_airport_id,
                "departure_date": departure_date,
                "departure_time": departure_time,
                "arrival_date": arrival_date,
                "arrival_time": arrival_time
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(r => {
                const result = r;

                this.snackbar = "added";
                this.$forceUpdate();


            }).catch(e => {


                console.error(e)
            })




        },


        addCoordinator() {

            console.log(this.program_id);
            this.trip.coordinators.push(this.person);


            var newApiUrl = store.state.apiUrl + 'trip/' + this.program_id + '/add_user/' + this.person;
            axios.post(newApiUrl, {}, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(r => {
                const result = r;

                console.log(result.data);

                this.snackbar = "added";


            }).catch(e => {


                console.error(e)
            })






            this.$forceUpdate();
        }

    }

    ,
    mounted() {

        //this.$forceUpdate();
        console.log('Mounted');
        console.log(this.departureFlightData2);

        this.$forceUpdate();

        //let newArrayObj = this.departureFlightData2;

        //console.log(newArrayObj[1].airline_code);
        //console.log(newArrayObj.content);
        //console.log(newArrayObj.content[0][0]);


        // for (let i = 0; i < this.departureFlightData.length; i++) {
        //     console.log('Inside Mounted');
        // console.log(this.departureFlightData[i]);
        // }





    },
};
</script>



<style>
.invalid-feedback-flight-add {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 40px !important;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}


.select2-container {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100%
}

.select2-container .select2-container-dropdown {
    position: absolute
}

.select2-container .select2-selection--single {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none
}

.select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    padding-left: 8px;
    padding-right: 20px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
}

.select2-container .select2-selection--single .select2-selection__clear {
    position: relative
}

.select2-container .select2-selection--multiple {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    min-height: 32px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none
}

.select2-container .select2-selection--multiple .select2-selection__rendered {
    display: inline-block;
    overflow: hidden;
    padding-left: 8px;
    text-overflow: ellipsis;
    white-space: nowrap
}

.select2-container .select2-search--inline {
    float: left
}

.select2-container .select2-search--inline .select2-search__field {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border: none;
    font-size: 100%;
    margin-top: 5px;
    padding: 0
}

.select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button {
    -webkit-appearance: none
}

.select2-dropdown {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    display: block;
    position: absolute;
    left: -100000px;
    width: 100%;
    z-index: 1051
}

.select2-results {
    display: block
}

.select2-results__options {
    list-style: none;
    margin: 0;
    padding: 0
}

.select2-results__option {
    padding: 6px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none
}

.select2-results__option[aria-selected] {
    cursor: pointer
}

.select2-container--open .select2-dropdown {
    left: 0
}

.select2-container--open .select2-dropdown--above {
    border-bottom: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0
}

.select2-container--open .select2-dropdown--below {
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0
}

.select2-search--dropdown {
    display: block;
    padding: 4px
}

.select2-search--dropdown .select2-search__field {
    padding: 4px;
    width: 100%;
    -webkit-box-sizing: border-box;
    box-sizing: border-box
}

.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button {
    -webkit-appearance: none
}

.select2-search--dropdown.select2-search--hide {
    display: none
}

.select2-close-mask {
    border: 0;
    margin: 0;
    padding: 0;
    display: block;
    position: fixed;
    left: 0;
    top: 0;
    min-height: 100%;
    min-width: 100%;
    height: auto;
    width: auto;
    opacity: 0;
    z-index: 99;
    background-color: #fff
}

.select2-hidden-accessible {
    border: 0 !important;
    clip: rect(0 0 0 0) !important;
    height: 1px !important;
    margin: -1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    width: 1px !important
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: 700
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #999
}

.select2-container--default .select2-selection--single .select2-selection__placeholder__option {
    display: none
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #888 transparent;
    border-style: solid;
    border-width: 5px 4px 0;
    height: 0;
    left: 50%;
    margin-left: -4px;
    margin-top: -2px;
    position: absolute;
    top: 50%;
    width: 0
}

.select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: #eee;
    cursor: default
}

.select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear {
    display: none
}

.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #888;
    border-width: 0 4px 5px
}

.select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: text
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    list-style: none;
    margin: 0;
    padding: 0 5px;
    width: 100%
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
    list-style: none
}

.select2-container--default .select2-selection--multiple .select2-selection__placeholder {
    color: #999;
    margin-top: 5px;
    float: left
}

.select2-container--default .select2-selection--multiple .select2-selection__placeholder__option {
    display: none
}

.select2-container--default .select2-selection--multiple .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: 700;
    margin-top: 5px;
    margin-right: 10px
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #999;
    cursor: pointer;
    display: inline-block;
    font-weight: 700;
    margin-right: 2px
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #333
}

.select2-container--default.select2-container--focused .select2-selection--multiple {
    border: solid #000 1px;
    outline: 0
}

.select2-container--default:not(.select2-container--open) .select2-focused .select2-selection--multiple,
.select2-container--default:not(.select2-container--open) .select2-focused .select2-selection--single {
    border: solid #000 1px;
    outline: 0
}

.select2-container--default.select2-container--disabled .select2-selection--multiple {
    background-color: #eee;
    cursor: default
}

.select2-container--default.select2-container--disabled .select2-selection__choice__remove {
    display: none
}

.select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple,
.select2-container--default.select2-container--open.select2-container--above .select2-selection--single {
    border-top-left-radius: 0;
    border-top-right-radius: 0
}

.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple,
.select2-container--default.select2-container--open.select2-container--below .select2-selection--single {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #aaa
}

.select2-container--default .select2-search--inline .select2-search__field {
    background: 0 0;
    border: none;
    outline: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-appearance: textfield
}

.select2-container--default .select2-results>.select2-results__options {
    max-height: 200px;
    overflow-y: auto
}

.select2-container--default .select2-results__option[role=group] {
    padding: 0
}

.select2-container--default .select2-results__option[aria-disabled=true] {
    color: #999
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #ddd
}

.select2-container--default .select2-results__option .select2-results__option {
    padding-left: 1em
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__group {
    padding-left: 0
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -1em;
    padding-left: 2em
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -2em;
    padding-left: 3em
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -3em;
    padding-left: 4em
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -4em;
    padding-left: 5em
}

.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option {
    margin-left: -5em;
    padding-left: 6em
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #5897fb;
    color: #fff
}

.select2-container--default .select2-results__group {
    cursor: default;
    display: block;
    padding: 6px;
    color: gray
}

select2.material {
    display: inline-block;
    width: 300px
}

select2.material>.select2-container {
    padding-bottom: 1.29688em;
    vertical-align: inherit
}

select2.material>.select2-container .selection {
    padding: .4375em 0;
    border-top: .84375em solid transparent;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: baseline;
    -ms-flex-align: baseline;
    align-items: baseline;
    width: 100%;
    height: auto
}

select2.material .select2-container--default .select2-selection--multiple,
select2.material .select2-container--default .select2-selection--single {
    width: 100%;
    border: 0;
    border-radius: 0;
    height: 24px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box
}

select2.material .select2-container--default .select2-selection--multiple::before,
select2.material .select2-container--default .select2-selection--single::before {
    content: ' ';
    display: block;
    position: absolute;
    bottom: 1.65em;
    background-color: #ddd;
    height: 1px;
    width: 100%
}

select2.material .select2-container--default .select2-selection--multiple::after,
select2.material .select2-container--default .select2-selection--single::after {
    content: ' ';
    display: block;
    position: absolute;
    bottom: 1.63em;
    background-color: #5a419e;
    height: 2px;
    width: 0%;
    left: 50%;
    -webkit-transition: none;
    transition: none
}

select2.material .select2-container--default .select2-selection--multiple .select2-selection__rendered,
select2.material .select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-left: 1px;
    line-height: inherit
}

select2.material .select2-container--default .select2-selection--multiple .select2-selection__placeholder,
select2.material .select2-container--default .select2-selection--single .select2-selection__placeholder {
    display: block;
    color: rgba(0, 0, 0, .38);
    -webkit-transition: -webkit-transform .3s;
    transition: -webkit-transform .3s;
    transition: transform .3s;
    transition: transform .3s, -webkit-transform .3s;
    position: absolute;
    -webkit-transform-origin: 0 21px;
    transform-origin: 0 21px;
    left: 0;
    top: 20px
}

select2.material .select2-container--default .select2-container--open {
    left: 0;
    bottom: 1.6em
}

select2.material .select2-container--default .select2-selection__placeholder__option {
    -webkit-transform: translateY(-1.5em) scale(.75) perspective(100px) translateZ(.001px);
    transform: translateY(-1.5em) scale(.75) perspective(100px) translateZ(.001px);
    width: 133.33333%
}

select2.material .select2-container--default .select2-selection__arrow {
    top: 20px
}

select2.material .select2-container--default .select2-focused .select2-selection--multiple::after,
select2.material .select2-container--default .select2-focused .select2-selection--single::after,
select2.material .select2-container--default.select2-container--open .select2-selection--multiple::after,
select2.material .select2-container--default.select2-container--open .select2-selection--single::after {
    -webkit-transition: width .3s cubic-bezier(.12, 1, .77, 1), left .3s cubic-bezier(.12, 1, .77, 1);
    transition: width .3s cubic-bezier(.12, 1, .77, 1), left .3s cubic-bezier(.12, 1, .77, 1);
    width: 100%;
    left: 0
}

select2.material .select2-container--default .select2-dropdown {
    border-radius: 0;
    border: 0;
    -webkit-box-shadow: 0 5px 5px rgba(0, 0, 0, .5);
    box-shadow: 0 5px 5px rgba(0, 0, 0, .5)
}

select2.material .select2-container--default .select2-results__option--highlighted[aria-selected],
select2.material .select2-container--default .select2-results__option[aria-selected=true] {
    background-color: rgba(0, 0, 0, .04);
    color: #000
}

select2.material .select2-container--default .select2-results__option[aria-selected=true] {
    color: #ff5722
}

select2.material .select2-container--default.select2-container--disabled .select2-selection--multiple,
select2.material .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: transparent
}

select2.material .select2-container--default.select2-container--disabled .select2-selection--multiple::before,
select2.material .select2-container--default.select2-container--disabled .select2-selection--single::before {
    background-image: -webkit-gradient(linear, left top, right top, color-stop(0, rgba(0, 0, 0, .26)), color-stop(33%, rgba(0, 0, 0, .26)), color-stop(0, transparent));
    background-image: linear-gradient(to right, rgba(0, 0, 0, .26) 0, rgba(0, 0, 0, .26) 33%, transparent 0);
    background-size: 4px 1px;
    background-repeat: repeat-x;
    background-color: transparent;
    background-position: 0 bottom
}

select2.material.ng-invalid.ng-touched .select2-container--default .select2-selection--multiple::after,
select2.material.ng-invalid.ng-touched .select2-container--default .select2-selection--multiple::before,
select2.material.ng-invalid.ng-touched .select2-container--default .select2-selection--single::after,
select2.material.ng-invalid.ng-touched .select2-container--default .select2-selection--single::before {
    background-color: red
}

select2.material:not(.select2-container--open) .select2-focused .select2-selection--multiple,
select2.material:not(.select2-container--open) .select2-focused .select2-selection--single {
    border: 0
}

select2.material .select2-subscript-wrapper {
    position: absolute;
    top: calc(100% - 1.72917em);
    font-size: 75%
}

@supports (-moz-appearance:none) {

    select2.material .select2-container--default .select2-selection--multiple,
    select2.material .select2-container--default .select2-selection--single {
        height: 26px
    }
}

@supports (-ms-scroll-limit:0) {

    select2.material .select2-container--default .select2-selection--multiple,
    select2.material .select2-container--default .select2-selection--single {
        height: 25px
    }
}

/*!
 * "Fork me on GitHub" CSS ribbon v0.2.3 | MIT License
 * https://github.com/simonwhitaker/github-fork-ribbon-css
*/
.github-fork-ribbon {
    width: 12.1em;
    height: 12.1em;
    position: absolute;
    overflow: hidden;
    top: 0;
    right: 0;
    z-index: 9999;
    pointer-events: none;
    font-size: 13px;
    text-decoration: none;
    text-indent: -999999px
}

.github-fork-ribbon.fixed {
    position: fixed
}

.github-fork-ribbon:active,
.github-fork-ribbon:hover {
    background-color: rgba(0, 0, 0, 0)
}

.github-fork-ribbon:after,
.github-fork-ribbon:before {
    position: absolute;
    display: block;
    width: 15.38em;
    height: 1.54em;
    top: 3.23em;
    right: -3.23em;
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg)
}

.github-fork-ribbon:before {
    content: "";
    padding: .38em 0;
    background-color: #a00;
    background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), to(rgba(0, 0, 0, .15)));
    background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15));
    background-image: -moz-linear-gradient(top, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15));
    background-image: -ms-linear-gradient(top, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15));
    background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15));
    background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15));
    -webkit-box-shadow: 0 .15em .23em 0 rgba(0, 0, 0, .5);
    -moz-box-shadow: 0 .15em .23em 0 rgba(0, 0, 0, .5);
    box-shadow: 0 .15em .23em 0 rgba(0, 0, 0, .5);
    pointer-events: auto
}

.github-fork-ribbon:after {
    content: attr(data-ribbon);
    color: #fff;
    font: 700 1em "Helvetica Neue", Helvetica, Arial, sans-serif;
    line-height: 1.54em;
    text-decoration: none;
    text-shadow: 0 -.08em rgba(0, 0, 0, .5);
    text-align: center;
    text-indent: 0;
    padding: .15em 0;
    margin: .15em 0;
    border-width: .08em 0;
    border-style: dotted;
    border-color: #fff;
    border-color: rgba(255, 255, 255, .7)
}

.github-fork-ribbon.left-bottom,
.github-fork-ribbon.left-top {
    right: auto;
    left: 0
}

.github-fork-ribbon.left-bottom,
.github-fork-ribbon.right-bottom {
    top: auto;
    bottom: 0
}

.github-fork-ribbon.left-bottom:after,
.github-fork-ribbon.left-bottom:before,
.github-fork-ribbon.left-top:after,
.github-fork-ribbon.left-top:before {
    right: auto;
    left: -3.23em
}

.github-fork-ribbon.left-bottom:after,
.github-fork-ribbon.left-bottom:before,
.github-fork-ribbon.right-bottom:after,
.github-fork-ribbon.right-bottom:before {
    top: auto;
    bottom: 3.23em
}

.github-fork-ribbon.left-top:after,
.github-fork-ribbon.left-top:before,
.github-fork-ribbon.right-bottom:after,
.github-fork-ribbon.right-bottom:before {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    -ms-transform: rotate(-45deg);
    -o-transform: rotate(-45deg);
    transform: rotate(-45deg)
}</style>
