<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Add Inbound Flight</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to add a Flight
                        </p>
                    </div>
                    <div class="row" style="margin: 10px">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="destination">Program Name</label>
                                <select class="form-select">
                                    <option value="">Select Program</option>
                                    <!-- <option v-for="(name, id) in tripsList" :value="name.id" :label="name.name">
                                        {{ name.name }}</option> -->
                                </select>
                            </div>
                            <div class="row">
                                <h5>Departure Flight</h5>
                            </div>
                            <div class="row" v-for="n in parseInt(departureFlightTotal)" :key="n">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="departure_city">Originating City</label>
                                            <select class="form-select" ref="origin_airport">
                                                <option value="">Select Airport</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="destination">Destination</label>
                                            <select class="form-select" ref="destination_airport">
                                                <option value="">Select Airport</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="airline">Airline</label>
                                    <select class="form-select" ref="airline">
                                        <option value="">Select Airline</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="flight_number">Flight Number:</label>
                                    <input type="text" class="form-control" id="flight_number" ref="flight_number"
                                        placeholder="Flight Number" required>
                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_date">Departure Date:</label>
                                            <input type="date" class="form-control" id="departure_date"
                                                onfocus="this.showPicker()" @change="populateArrivalDate()"
                                                ref="departure_date" placeholder="Departure Date" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_date">Arrival Date:</label>
                                            <input type="date" class="form-control" id="arrival_date"
                                                onfocus="this.showPicker()" ref="arrival_date"
                                                placeholder="Arrival Date" required>
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
                                            <input class="form-control" type="time" id="departure_time"
                                                ref="departure_time" placeholder="Departure Time" required />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_time">Arrival Time:</label>
                                            <input class="form-control" type="time" id="arrival_time" ref="arrival_time"
                                                placeholder="Arrival Time" required />
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
                            <div class="row" v-for="n in parseInt(returnFlightTotal)" :key="n">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="departure_city">Originating City</label>
                                            <select class="form-select" ref="ret_origin_airport">
                                                <option value="">Select Airport</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="destination">Destination</label>
                                            <select class="form-select" ref="ret_destination_airport">
                                                <option value="">Select Airport</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="airline">Airline</label>
                                    <select class="form-select" ref="ret_airline">
                                        <option value="">Select Airline</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="flight_number">Flight Number:</label>
                                    <input type="text" class="form-control" id="flight_number" ref="ret_flight_number"
                                        placeholder="Flight Number" required>
                                </div>


                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="departure_date">Departure Date:</label>
                                            <input type="date" class="form-control" id="departure_date"
                                                onfocus="this.showPicker()" @change="populateArrivalDate2()"
                                                ref="ret_departure_date" placeholder="Departure Date" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_date">Arrival Date:</label>
                                            <input type="date" class="form-control" id="arrival_date"
                                                onfocus="this.showPicker()" ref="ret_arrival_date"
                                                placeholder="Arrival Date" required>
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
                                                ref="ret_departure_time" placeholder="Departure Time" required />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="arrival_time">Arrival Time:</label>
                                            <input class="form-control" type="time" id="arrival_time"
                                                ref="ret_arrival_time" placeholder="Arrival Time" required />
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
                            <button type="submit" class="btn bg-gradient-success" @click.prevent="addFlight()">
                                <i class="fa fa-plane" aria-hidden="true"></i>
                                Add New Inbound Flight
                            </button>
                        </form>
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
import { ref } from 'vue';
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";
import { DataTable } from "simple-datatables";


export default {
    name: "DataTables",
    el: '#tabs',
    inheritAttrs: false,
    components: {
        VsudAlert,
        VsudSnackbar,
    },
    data() {
        return {
            activetab: '1',
            snackbar: null,
        }
    },
    setup() {
        let tripsList = ref([]);



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

            console.log(result.data.trips);

            result.data.trips.forEach((tripItem, index) => {



                try {
                    tripsList.value.push({ id: tripItem.id, name: tripItem.title });
                }
                catch (err) {
                    console.log(err.message);
                }




            })


        }).catch(e => {


            console.error(e)
        })

        return {
            tripsList,
            departureFlightTotal: 1,
            returnFlightTotal: 1,
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

                console.log(this.$refs.departure_date[i].value);



                }

        },
        addDepartureFlight() {
            if (this.departureFlightTotal > 0){
                this.departureFlightTotal = this.departureFlightTotal + 1;
                this.$forceUpdate();
            }
        },
        removeDepatureFlight() {
            if (this.departureFlightTotal > 1){
            this.departureFlightTotal = this.departureFlightTotal - 1;
            this.$forceUpdate();
            }
        },
        addReturnFlight() {
            if (this.returnFlightTotal > 0){
            this.returnFlightTotal = this.returnFlightTotal + 1;
            this.$forceUpdate();
            }
        },
        removeReturnFlight() {
            if (this.returnFlightTotal > 1){
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



    },
};
</script>

<style>
.invalid-feedback-flight-add {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}</style>
