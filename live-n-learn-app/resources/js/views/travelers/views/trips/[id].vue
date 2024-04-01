<template>
    <div class="py-2 container-fluid">
      <div class="mt-2 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">View My Trip Details</h5>
              <p class="mb-0 text-sm">{{ title }}</p>
            </div>
            <div class="row" style="margin: 10px">
              <div class="col-12">
                <div id="tabs" class="container">
                  <div class="tabs">
                    <a
                      v-on:click="activetab = '1'"
                      v-bind:class="[activetab === '1' ? 'active' : '']"
                      ><i class="fa fa-plane" aria-hidden="true"></i> Trip
                      Details</a
                    >


                    <a
                      v-on:click="activetab = '9'"
                      v-bind:class="[activetab === '9' ? 'active' : '']"
                      ><i class="fa fa-user" aria-hidden="true"></i> Group Leaders({{ trip_group_leaders.length }})
                    </a>
                    <a
                      v-if="trip_type == 'homestay'"
                      v-on:click="activetab = '4'"
                      v-bind:class="[activetab === '4' ? 'active' : '']"
                      ><i class="fa fa-users" aria-hidden="true"></i> Host
                      Families</a
                    >

                    <!-- <a
                      v-on:click="activetab = '5'"
                      v-bind:class="[activetab === '5' ? 'active' : '']"
                      ><i class="fa fa-list" aria-hidden="true"></i> Trip Forms</a
                    > -->

                    <a
                      v-on:click="activetab = '6'"
                      v-bind:class="[activetab === '6' ? 'active' : '']"
                      ><i class="fa fa-calendar" aria-hidden="true"></i>
                      Itinerary</a
                    >

                    <a
                      v-on:click="activetab = '7'"
                      v-bind:class="[activetab === '7' ? 'active' : '']"
                      ><i class="fa fa-credit-card" aria-hidden="true"></i>
                      Payments</a
                    >

                    <a
                      v-on:click="activetab = '8'"
                      v-bind:class="[activetab === '8' ? 'active' : '']"
                      ><i class="fa fa-plane" aria-hidden="true"></i> Trip
                      Flights</a
                    >
                  </div>

                  <div class="content">
                    <div v-if="activetab === '1'" class="tabcontent">
                      <div class="row" style="margin: 10px">
                        <h4>Trip Details - {{ title }}</h4>
                        <form @submit.prevent="submit">
                          <div class="form-group">
                            <label for="trip_title">Trip Title</label>
                            <input
                              type="text"
                              class="form-control"
                              id="trip_title"
                              placeholder="Trip Title"
                              v-model="title" readonly
                            />
                          </div>
                          <div class="form-group">
                            <label for="trip_type">Trip Type</label>
                            <input
                              type="text"
                              class="form-control"
                              id="trip_type"
                              placeholder="Trip Type"
                              v-model="trip_type" readonly
                            />
                          </div>
                          <div class="form-group">
                            <label for="trip_description">Description</label>
                            <textarea
                              class="form-control"
                              id="trip_description"
                              rows="3"
                              placeholder="Enter Program Description here"
                              v-model="description" readonly
                            ></textarea>
                          </div>
                          <div class="form-group">
                            <label for="origin_city">Originating City</label>

                            <select
                              class="form-select"
                              id="origin_city"
                              v-model="start_city"  disabled="true"
                            >
                              <option value="">Select City</option>
                              <option
                                v-for="(name, id) in locationsList"
                                :value="name.id"
                                :label="name.name"
                                :key="id"
                              >
                                {{ name.name }}
                              </option>
                            </select>
                          </div>

                          <div
                            class="row"
                            v-for="n in parseInt(destinationTotal)"
                            :key="n"
                          >
                            <div class="col-12">
                              <div class="form-group">
                                <label for="origin_city">Destination</label>
                                <select
                                  class="form-select"
                                  id="destination"
                                  ref="destination"
                                  v-model="destinationList[n - 1]"  disabled="true"
                                >
                                  <option selected value="">
                                    Select Destination
                                  </option>
                                  <option
                                    v-for="(name, id) in locationsList"
                                    :value="name.id"
                                    :label="name.name"
                                    :key="id"
                                  >
                                    {{ name.name }}
                                  </option>
                                </select>
                              </div>
                            </div>

                          </div>

                          <div class="form-group">
                            <label for="trip_cost">Total Trip Cost($)</label>
                            <input
                              type="number"
                              class="form-control"
                              id="trip_cost"
                              v-model="total_cost"
                              placeholder="Trip Cost $00.00"
                              step="any"
                              required readonly
                            />
                          </div>

                          <div class="form-group">
                            <label for="start_date">Start Date:</label>
                            <input
                              type="date"
                              class="form-control"
                              onfocus="this.showPicker()"
                              id="start_date"
                              v-model="start_date"
                              placeholder="Start Date"
                              required readonly
                            />
                          </div>

                          <div class="form-group">
                            <label for="end_date">End Date:</label>
                            <input
                              type="date"
                              class="form-control"
                              onfocus="this.showPicker()"
                              id="end_date"
                              placeholder="End Date"
                              v-model="end_date"
                              required readonly
                            />
                          </div>



                          <div class="row">
                            <div class="form-group">
                              <label for="trip_prefix">Trip ID</label>
                              <input
                                type="text"
                                class="form-control"
                                id="trip_id"
                                placeholder="Trip ID"
                                v-model="trip_id" readonly
                              />
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="end_date"
                              >Registration Cutoff Date:</label
                            >
                            <input
                              type="date"
                              class="form-control"
                              id="registration_cutoff_date"
                              onfocus="this.showPicker()"
                              placeholder="Registration Cutoff Date"
                              v-model="registration_cutoff_date"
                              required readonly
                            />
                          </div>

                        </form>

                        <!-- <div class="row">
                              <pre>
                          {{ formdata }}
                        </pre>

                          </div> -->
                      </div>
                    </div>
                    <div v-if="activetab === '2'" class="tabcontent">
                      <div class="table-responsive">
                        <h4>Travelers - (Total {{ travelersList.length }})</h4>
                        <table
                          id="datatable-lc"
                          border="1"
                          class="table table-flush"
                        >
                          <thead class="thead-light">
                            <tr>
                              <th>Fname</th>
                              <th>Lname</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(data, id) in travelersList" :key="id">
                              <td style="text-align: left">
                                {{ data.first_name }}
                              </td>
                              <td style="text-align: left">
                                {{ data.last_name }}
                              </td>
                              <td>
                                <a
                                  class="btn btn-success"
                                  :href="'/traveler/' + data.id"
                                  ><i class="fa fa-user" aria-hidden="true"></i>
                                  View Traveler Details</a
                                >
                              </td>
                              <td>
                                <button
                                  class="btn btn-warning"
                                  @click="removeCoordinator(data.id)"
                                >
                                  <i class="fa fa-minus" aria-hidden="true"></i>
                                  Remove
                                </button>
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <!-- <table id="datatable-search" class="table table-flush">
                                                  <thead class="thead-light">
                                                      <tr>
                                                          <th>Student Name</th>
                                                          <th>Amount Remaining</th>
                                                          <th>Checklist Completed%</th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>

                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <tr>
                                                          <td class="text-sm font-weight-normal">Yaw Tandoh</td>
                                                          <td class="text-sm font-weight-normal">$600.00</td>
                                                          <td class="text-sm font-weight-normal">80%</td>
                                                          <td class="text-sm font-weight-normal"><button
                                                                  class="btn btn-success"><i class="fa fa-user"
                                                                      aria-hidden="true"></i> Student Info</button></td>
                                                          <td class="text-sm font-weight-normal"><button
                                                                  class="btn btn-success"><i class="fa fa-th-list"
                                                                      aria-hidden="true"></i> CheckList</button></td>
                                                          <td class="text-sm font-weight-normal"><button
                                                                  class="btn btn-success"><i class="fa fa-credit-card"
                                                                      aria-hidden="true"></i> Payments</button></td>
                                                      </tr>

                                                  </tbody>
                                              </table> -->
                      </div>
                    </div>
                    <div v-if="activetab === '3'" class="tabcontent">
                      <div class="row">
                        <h4>
                          Local Coordinators (Total
                          {{ trip_local_coordinator.length }})
                        </h4>
                        <div class="form-group">
                          <label for="country">Choose local Coordinators:</label>
                          <select class="form-select" id="type" v-model="person">
                            <option value="Select Coordinator">
                              Select Coordinator
                            </option>
                            <option
                              v-for="(name, id) in coordinatorsList"
                              :value="name.id"
                              :label="name.name"
                              :key="id"
                            >
                              {{ name.name }}
                            </option>
                          </select>
                        </div>

                        <div class="form-group">
                          <button
                            @click="addCoordinator()"
                            type="button"
                            class="btn bg-gradient-success"
                          >
                            <i class="fa fa-user" aria-hidden="true"></i> Add
                            Coordinator to Trip
                          </button>
                        </div>
                        <!-- <div class="form-group">
                          {{ userRows }}
                        </div> -->
                        <!-- <div class="row">
                          <li v-for="message in userRows" :key="message">
                            <span v-html="message"></span>
                          </li>
                        </div> -->
                        <div class="table-responsive">
                          <h4>Assigned Local Coordinators to Trip</h4>

                          <table
                            id="datatable-lc"
                            class="table table-flush"
                            border="1"
                          >
                            <thead class="thead-light">
                              <tr>
                                <th>Fname</th>
                                <th>Lname</th>
                                <th></th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="(data, id) in trip_local_coordinator"
                                :key="id"
                              >
                                <td>{{ data.first_name }}</td>
                                <td>{{ data.last_name }}</td>
                                <td>
                                  <a
                                    class="btn btn-success"
                                    :href="'/coordinator/' + data.id"
                                    ><i class="fa fa-user" aria-hidden="true"></i>
                                    View User Details</a
                                  >
                                </td>
                                <td>
                                  <button
                                    class="btn btn-warning"
                                    @click="removeCoordinator(data.id)"
                                  >
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                    Remove
                                  </button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div v-if="activetab === '9'" class="tabcontent">
                      <div class="row">
                        <h4>
                          Group Leaders (Total
                          {{ trip_group_leaders.length }})
                        </h4>

                        <div class="table-responsive">

                          <table
                            id="datatable-lc"
                            class="table table-flush"
                            border="1"
                          >
                            <thead class="thead-light">
                              <tr>
                                <th>Fname</th>
                                <th>Lname</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr
                                v-for="(data, id) in trip_group_leaders"
                                :key="id"
                              >
                                <td>{{ data.first_name }}</td>
                                <td>{{ data.last_name }}</td>
                                <td>
                                  <a
                                    class="btn btn-success"
                                    href="#" style="pointer-events: none; display: inline-block;"
                                    ><i class="fa fa-envelope" aria-hidden="true"></i>
                                    Send Message</a
                                  >
                                </td>

                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div v-if="activetab === '4'" class="tabcontent">
                      <div class="table-responsive">
                        <h4>Host Families</h4>
                        <!-- <table id="datatable-search" class="table table-flush">
                                                  <thead class="thead-light">
                                                      <tr>
                                                          <th>Family</th>
                                                          <th>Matched Student</th>

                                                          <th></th>
                                                          <th></th>

                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                      <tr>
                                                          <td class="text-sm font-weight-normal">Yaw Tandoh</td>
                                                          <td class="text-sm font-weight-normal">Hulk Hogan</td>
                                                          <td class="text-sm font-weight-normal"><button
                                                                  class="btn btn-success"><i class="fa fa-compress"
                                                                      aria-hidden="true"></i> View Matches</button></td>
                                                          <td class="text-sm font-weight-normal"><button
                                                                  class="btn btn-success"><i class="fa fa-arrow-circle-right"
                                                                      aria-hidden="true"></i> Assign Student</button></td>
                                                      </tr>

                                                  </tbody>
                                              </table> -->
                      </div>
                    </div>
                    <div v-if="activetab === '5'" class="tabcontent">
                      <div class="row">
                        <h4>Trip Forms</h4>
                        <!-- <div class="form-group">
                          <label for="country">Choose Checklist Parameter:</label>
                          <select
                            class="form-select"
                            id="type"
                            v-model="checklists"
                          >
                            <option value="">Select Checklist</option>
                            <option value="Passport">Passport</option>
                            <option value="Covid Immunization">
                              Covid Immunization
                            </option>
                          </select>
                        </div>

                        <div class="form-group">
                          <button
                            @click="addChecklist()"
                            type="button"
                            class="btn bg-gradient-success"
                          >
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            Add Checklist to Trip
                          </button>
                        </div>
                        <div class="form-group">
                          {{ trip.checklist }}
                        </div> -->
                      </div>
                    </div>

                    <div v-if="activetab === '8'" class="tabcontent">
                      <div class="row">
                        <h4>Trip Flights</h4>
                      </div>
                      <div class="row">
                        <div class="card">
                          <div class="row">
                            <div
                              v-for="flightInfo in flightsList"
                              class="p-3 card-body border-radius-lg"
                            >
                              <div class="d-flex">
                                <div>
                                  <div
                                    class="text-center shadow shadow-none icon icon-shape bg-danger-soft border-radius-md"
                                  >
                                    <i
                                      :class="getDynamicClassColor(flightInfo.id)"
                                      aria-hidden="true"
                                    ></i>
                                  </div>
                                </div>
                                <div class="ms-3">
                                  <div class="numbers">
                                    <h6 class="mb-1 text-sm text-dark">
                                      {{ flightInfo.title }}
                                    </h6>
                                    <span class="text-sm"
                                      ><b
                                        >{{ flightInfo.airline }}
                                        {{ flightInfo.flight_number }}</b
                                      ></span
                                    >
                                    <br />

                                    <span class="text-sm"
                                      >{{ flightInfo.origin_city }} -
                                      {{ flightInfo.destination_city }}</span
                                    >
                                    <br />
                                    <span class="text-sm"
                                      ><b>Departure:</b>
                                      {{ flightInfo.departure_date_time }}</span
                                    >
                                    <br />
                                    <span class="text-sm"
                                      ><b>Arrival:</b>
                                      {{ flightInfo.arrival_date_time }}</span
                                    >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div v-if="activetab === '6'" class="tabcontent">
                      <div class="row">
                        <h4>Trip Itinerary</h4>
                      </div>
                      <div class="row">
                        <div class="card">
                          <div class="card-header pb-0">
                            <h6>Itinerary overview</h6>
                          </div>
                          <div class="card-body p-3">
                            <div class="row"></div>
                            <div


                              v-for="(item, index) in itineraryList"
                              class="timeline timeline-one-side"
                            >
                              <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                  <i class="text-dark text-gradient">
                                    {{ index + 1 }}</i
                                  >
                                </span>
                                <div class="timeline-content">
                                  <h6
                                    class="text-dark text-sm font-weight-bold mb-0"
                                  >
                                    Day {{ index + 1 }} -
                                    Activity
                                  </h6>
                                  <div class="row">
                                    <img v-if="item.media_file != null"
                        :src="item.media_file.uri"
                        class="img-fluid img-thumbnail" style="margin:3px;"
                      />
                                  </div>
                                  <p
                                    class="text-secondary font-weight-bold text-xs mt-1 mb-0"
                                  >
                                    {{ item.title }}
                                  </p>
                                  <p>
                                    <small>{{ item.content }}</small>
                                  </p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div v-if="activetab === '7'" class="tabcontent">
                      <div class="row">
                        <h4>Payments</h4>

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

    <div class="position-fixed bottom-1 end-1 z-index-2">
      <vsud-snackbar
        v-if="snackbar === 'info'"
        title="Live N Learn - Notifications"
        description="Trip ID has been created."
        icon="ni ni-check-bold"
        color="success"
        icon-color="white"
        :close-handler="closeSnackbar"
      />

      <vsud-snackbar
        v-if="snackbar === 'warning'"
        title="Live N Learn - Notifications"
        description="The Trip ID has already been created."
        icon="ni ni-check-bold"
        color="white"
        icon-color="info"
        :close-handler="closeSnackbar"
      />

      <vsud-snackbar
        v-if="snackbar === 'updated'"
        title="Live N Learn - Notifications"
        description="Program details have been updated."
        icon="ni ni-check-bold"
        color="white"
        icon-color="success"
        :close-handler="closeSnackbar"
      />

      <vsud-snackbar
        v-if="snackbar === 'added'"
        title="Live N Learn - Notifications"
        description="User has been added to the trip."
        icon="ni ni-check-bold"
        color="success"
        icon-color="white"
        :close-handler="closeSnackbar"
      />

      <vsud-snackbar
        v-if="snackbar === 'removed'"
        title="Live N' Learn - Notifications"
        description="User has been removed from the trip."
        icon="ni ni-check-bold"
        color="success"
        icon-color="white"
        :close-handler="closeSnackbar"
      />
    </div>
  </template>

  <style>
  /* Import Google Font */
  @import url(https://fonts.googleapis.com/css?family=Nunito+Sans);

  h1,
  h2,
  h3,
  h4 {
    font-family: "Montserrat" !important;
  }

  /* RESET */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 620px;
    min-width: 420px;
    margin: 40px auto;
    font-family: "Nunito Sans", Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    color: #888;
  }

  /* Style the tabs */
  .tabs {
    overflow: hidden;
    margin-bottom: -2px;
    /* hide bottom border */
    margin-left: 24px;
  }

  .tabs a {
    float: left;
    cursor: pointer;
    padding: 0.65em 0.65em !important;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    border-right: none;
    background-color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
  }

  .tabs a:last-child {
    border-right: 1px solid #ccc;
  }

  /* Change background color of tabs on hover */
  .tabs a:hover {
    background-color: #aaa;
    color: #fff;
  }

  /* Styling for active tab */
  .tabs a.active {
    background-color: #fff;
    color: #484848;
    border-bottom: 2px solid #fff;
    cursor: default;
  }

  /* Style the tab content */
  .tabcontent {
    padding: 30px 50px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 4px 4px 8px #e1e1e1;
  }

  .tabcontent td {
    padding: 0.3em 0.4em;
    color: #484848;
  }

  .tabcontent td.legend {
    color: #888;
    font-weight: bold;
    text-align: right;
  }

  .tabcontent .map {
    height: 173px;
    width: 220px;
    background: #d3eafb;
    margin-left: 60px;
    border: 1px solid #ccc;
    border-radius: 10px;
  }

  .data {
    width: 120px;
  }
  </style>

  <script>
  import { useRoute } from "vue-router";
  import axios from "axios";
  import store from "@/store/index.js";
  import { ref } from "vue";
  import VsudAlert from "@/components/VsudAlert.vue";
  import VsudSnackbar from "@/components/VsudSnackbar.vue";
  import { DataTable } from "simple-datatables";

  export default {
    name: "DataTables",
    el: "#tabs",
    inheritAttrs: false,
    components: {
      VsudAlert,
      VsudSnackbar,
    },
    data() {
      return {
        activetab: "1",
        snackbar: null,
      };
    },
    setup() {
      let tripList = ref([]);
      let coordinatorsList = ref([]);
      let groupLeaderList = ref([]);
      let studentList = ref([]);
      let formdata = {};
      let tripsRows = Array();
      const route = useRoute();
      const paramId = route.params.id;
      let userRows = Array();

      const activetab = ref("1");
      let destinationTotal = ref(1);
      const max_available_seats = ref();
      const min_available_seats = ref();
      const title = ref("");
      const description = ref("");
      const total_cost = ref();
      const start_date = ref("");
      const end_date = ref("");
      const total_seats = ref("");
      const trip_id_prefix = ref("");
      const trip_id = ref("");
      const registration_cutoff_date = ref("");
      const start_city = ref("");
      const dest_city = ref("");
      const program_id = ref();
      const trip_type = ref("");
      const trip_local_coordinator = ref([]);
      const trip_group_leaders = ref([]);
      let locationsList = ref([]);
      let itineraryList = ref([]);
      let travelersList = ref([]);
      let flightsList = ref([]);
      let destinationList = ref([]);
      const destination_location_id = ref();
      const origination_location_id = ref();

      let person = ref("Select Coordinator");
      let person2 = ref("Select Group Leader");
      let checklists = ref();
      let payment = ref();

      //get locations list
      var newApiUrl = store.state.apiUrl + "location";
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

          result.data.locations.forEach((item, index) => {
            locationsList.value.push({
              id: item.id,
              name: item.name + "(" + item.country + ")",
            });
          });
        })
        .catch((e) => {
          console.error(e);
        });

      //get coordinator list
      var newApiUrl = store.state.apiUrl + "user?class=local_coordinator";
      //var newApiUrl = store.state.apiUrl + 'user';
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

          const users = [];

          result.data.users.forEach(function (useritem) {
            coordinatorsList.value.push({
              id: useritem.id,
              name: useritem.first_name + " " + useritem.last_name,
            });
          });
        })
        .catch((e) => {
          console.error(e);
        });


        //get group leader list
      var newApiUrl = store.state.apiUrl + "user?class=group_leader";
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

          const users = [];

          result.data.users.forEach(function (useritem) {
              groupLeaderList.value.push({
              id: useritem.id,
              name: useritem.first_name + " " + useritem.last_name,
            });
          });
        })
        .catch((e) => {
          console.error(e);
        });

      //get student list
      var newApiUrl = store.state.apiUrl + "user?class=traveler";
      //var newApiUrl = store.state.apiUrl + 'user';
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

          const users = [];

          console.log("Students");
          console.log(result.data.users);

          result.data.users.forEach(function (useritem) {
            studentList.value.push({
              id: useritem.id,
              name: useritem.first_name + " " + useritem.last_name,
            });
          });
        })
        .catch((e) => {
          console.error(e);
        });

      //get trip Info
      var newApiUrl = store.state.apiUrl + "trip/" + paramId;
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
          console.log("trip details");
          console.log(result);
          program_id.value = paramId;
          title.value = result.data.trip.title;
          description.value = result.data.trip.description;
          total_cost.value = result.data.trip.total_cost.toFixed(2);
          max_available_seats.value = result.data.trip.max_available_seats;
          min_available_seats.value = result.data.trip.min_available_seats;
          start_date.value = result.data.trip.start_date;
          end_date.value = result.data.trip.end_date;
          trip_type.value = result.data.trip.type;
          total_seats.value = result.data.trip.available_seats;
          trip_id_prefix.value = result.data.trip.prefix;
          trip_id.value = result.data.trip.code;
          registration_cutoff_date.value =
            result.data.trip.registration_cutoff_date;
          dest_city.value = result.data.trip.destination_location_id;
          start_city.value = result.data.trip.origination_location_id;
          destinationTotal.value = result.data.trip.destinations.length;
          trip_local_coordinator.value = result.data.trip.local_coordinators;
          trip_group_leaders.value = result.data.trip.group_leaders;

          result.data.trip.departure_flight.forEach(function (flightItem) {
            let origin_airport_id = flightItem.origin_airport_id.toString();

            let destination_airport_id =
              flightItem.destination_airport_id.toString();

            let rowArray = {
              id: flightItem.trip_id,
              title: result.data.trip.title,
              airline: flightItem.airline,
              flight_number: flightItem.airline_flight_number,
              origin_city: flightItem.origin_airport.city,
              destination_city: flightItem.destination_airport.city,
              departure_date_time:
                flightItem.departure_date + " " + flightItem.departure_time,
              arrival_date_time:
                flightItem.arrival_date + " " + flightItem.arrival_time,
              date: flightItem.departure_date,
            };
            flightsList.value.push(rowArray);
          });

          result.data.trip.return_flight.forEach(function (flightItem) {
            let origin_airport_id = flightItem.origin_airport_id.toString();

            let destination_airport_id =
              flightItem.destination_airport_id.toString();

            let rowArray = {
              id: flightItem.trip_id,
              title: result.data.trip.title,
              airline: flightItem.airline,
              flight_number: flightItem.airline_flight_number,
              origin_city: flightItem.origin_airport.city,
              destination_city: flightItem.destination_airport.city,
              departure_date_time:
                flightItem.departure_date + " " + flightItem.departure_time,
              arrival_date_time:
                flightItem.arrival_date + " " + flightItem.arrival_time,
              date: flightItem.departure_date,
            };

            flightsList.value.push(rowArray);
          });

          //sort array
          flightsList.value.sort((a, b) => (a.date > b.date ? 1 : -1));
          itineraryList.value = result.data.trip.itinerary;
          travelersList.value = result.data.trip.travelers;

          if (result.data.trip.destinations != null) {
            for (let i = 0; i < result.data.trip.destinations.length; i++) {
              destinationList.value.push(result.data.trip.destinations[i].id);
            }
          }
          console.log(result.data);

          //populate local cordinators table
          result.data.trip.local_coordinators.forEach(function (useritem) {
            let linkBtn =
              '<a class="btn btn-success" href="#admins/' +
              useritem.id +
              '"><i class="fa fa-user" aria-hidden="true"></i> View User Details</a>';

            let rowArray = new Array(
              useritem.first_name + " " + useritem.last_name
            );

            try {
              userRows.push(rowArray);
            } catch (err) {
              console.log(err.message);
            }
          });
        })
        .catch((e) => {
          console.error(e);
        });

      return {
        userRows,
        travelersList,
        max_available_seats,
        min_available_seats,
        itineraryList,
        flightsList,
        locationsList,
        studentList,
        destinationList,
        coordinatorsList,
        groupLeaderList,
        destinationTotal,
        activetab: "1",
        trip_type,
        title,
        description,
        total_cost,
        start_date,
        registration_cutoff_date,
        start_city,
        dest_city,
        end_date,
        total_seats,
        trip_id,
        activetab,
        program_id,
        person,
        person2,
        checklists,
        trip_id_prefix,
        payment,
        trip: {
          coordinators: [],
          checklist: [],
          payments: [],
        },
        trip_local_coordinator,
        trip_group_leaders,
      };
    },
    methods: {
      getDynamicClassColor(id) {
        let arrIndex = id % 5;

        let classColors = [
          "text-lg fa fa-plane text-primary text-gradient opacity-10",
          "text-lg fa fa-plane text-success text-gradient opacity-10",
          "text-lg fa fa-plane text-danger text-gradient opacity-10",
          "text-lg fa fa-plane text-warning text-gradient opacity-10",
          "text-lg fa fa-plane text-info text-gradient opacity-10",
        ];

        return classColors[arrIndex];
      },
      addNewDestination() {
        this.destinationTotal++;
        this.$forceUpdate();
      },
      updateDestination() {
        this.destinationsList = [];

        for (let i = 0; i < this.destinationTotal; i++) {
          if (this.$refs.destination[i].value !== undefined) {
            this.destinationsList.push(this.$refs.destination[i].value);
          }
        }

        console.log(this.destinationsList);
      },
      removeDestination(index) {
        console.log(index);
        this.destinationTotal--;
        this.$forceUpdate();
        this.destinationsList.splice(index, 1);
        if (index === 0) this.addNewDestination();
      },
      addGroupLeader() {
        var newApiUrl =
          store.state.apiUrl +
          "trip/" +
          this.program_id +
          "/add_user/" +
          this.person2;
        axios
          .post(
            newApiUrl,
            {},
            {
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.token,
              },
            }
          )
          .then((result) => {
            this.trip_group_leaders.push(result.data.user);

            this.snackbar = "added";
          })
          .catch((e) => {
            console.error(e);
          });

        this.$forceUpdate();
      },
      addCoordinator() {
        var newApiUrl =
          store.state.apiUrl +
          "trip/" +
          this.program_id +
          "/add_user/" +
          this.person;
        axios
          .post(
            newApiUrl,
            {},
            {
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.token,
              },
            }
          )
          .then((result) => {
            this.trip_local_coordinator.push(result.data.user);

            this.snackbar = "added";
          })
          .catch((e) => {
            console.error(e);
          });

        this.$forceUpdate();
      },
      removeCoordinator(id, index) {
        var newApiUrl =
          store.state.apiUrl + "trip/" + this.program_id + "/remove_user/" + id;
        axios
          .post(
            newApiUrl,
            {},
            {
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.token,
              },
            }
          )
          .then((result) => {
            let newList = this.trip_local_coordinator.filter(
              (data) => data.first_name !== result.data.user.first_name
            );

            this.trip_local_coordinator = newList;

            this.snackbar = "removed";
          })
          .catch((e) => {
            console.error(e);
          });

        this.$forceUpdate();
      },
      closeSnackbar() {
        this.snackbar = null;
      },
      addChecklist() {
        this.trip.checklist.push(this.checklists);
        this.$forceUpdate();
      },
      addPayment() {
        this.trip.payments.push(this.payment);
        this.$forceUpdate();
      },
      updateProgram() {
        this.destinationsList = [];

        for (let i = 0; i < this.destinationTotal; i++) {
          if (this.$refs.destination[i].value !== undefined) {
            this.destinationsList.push(this.$refs.destination[i].value);
          }
        }

        var newApiUrl = this.$store.state.apiUrl + "trip/" + this.program_id;
        axios
          .put(
            newApiUrl,
            {
              title: this.title,
              description: this.description,
              origination_location_id: this.start_city,
              destinations: this.destinationsList,
              type: this.trip_type,
              prefix: this.trip_id_prefix,
              total_cost: this.cost,
              start_date: this.start_date,
              end_date: this.end_date,
              available_seats: this.total_seats,
              registration_cutoff_date: this.registration_cutoff_date,
            },
            {
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.token,
              },
            }
          )
          .then((r) => {
            const result = r.data;

            this.snackbar = "updated";

            //this.$router.push({ path: '/trips/view', replace: true });
          })
          .catch((e) => {
            console.log(e.message);
            console.error(e.response.data);
            this.showError = true;
            this.error.message = e.response.data.message;
          });
      },

      generateTripID() {
        if (this.trip_id > "") {
          console.log("Here");
          console.log(this.trip_id);
          this.snackbar = "warning";
        } else {
          var newApiUrl = store.state.apiUrl + "activate_trip/" + this.program_id;
          axios
            .post(
              newApiUrl,
              {},
              {
                headers: {
                  "Content-Type": "application/json",
                  Accept: "application/json",
                  Authorization: "Bearer " + localStorage.token,
                },
              }
            )
            .then((r) => {
              const result = r;

              console.log(result.data.trip);

              this.snackbar = "info";

              this.trip_id = result.data.trip.code;

              VsudSnackbar.description =
                result.data.trip.code + " has been created";
            })
            .catch((e) => {
              console.error(e);
            });
        }
      },
    },

    mounted() {},
  };
  </script>
