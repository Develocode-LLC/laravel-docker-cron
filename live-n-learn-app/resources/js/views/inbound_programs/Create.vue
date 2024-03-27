<template>
    <div class="py-4 container-fluid">
      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Create New Inbound Program</h5>
              <p class="mb-0 text-sm">
                Use this tool to add an upcoming Inbound Program here
              </p>
            </div>
            <div class="row" style="margin: 10px">
              <form @submit.prevent="submit">
                <div class="form-group">
                  <label for="origin_city">Program Location</label>
                  <select
                    class="form-select"
                    id="program_location"
                    ref="program_location"
                  >
                    <option selected value="">Select Program Location</option>
                    <option
                      v-for="(name, id) in locationsList"
                      :value="name.id"
                      :label="name.name"
                      v-bind:key="id"
                    >
                      {{ name.name }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="inbound_partner">Inbound Partner</label>
                  <select
                    class="form-select"
                    id="inbound_partner"
                    ref="inbound_partner"
                  >
                    <option selected value="">Select Partner</option>
                    <option
                      v-for="(name, id) in inboundPartnerList"
                      :value="name.id"
                      :label="name.name"
                      v-bind:key="id"
                    >
                      {{ name.name }}
                    </option>
                  </select>
                </div>
  
                <div class="form-group">
                  <label for="country_of_origin">Country of Origin</label>
                  <select
                    class="form-select"
                    id="country_of_origin"
                    ref="country_of_origin"
                    v-model="country_of_origin"
                  >
                    <option selected value="">Select Country</option>
                    <option
                      v-for="(name, id) in countriesList"
                      :value="name.id"
                      :label="name.name"
                      v-bind:key="id"
                    >
                      {{ name.name }}
                    </option>
                  </select>
                </div>
  
                <div class="form-group">
                  <label for="national_language">National Language</label>
                  <input
                    type="text"
                    class="form-control"
                    id="national_language"
                    placeholder="Enter Language"
                    v-model="national_language"
                  />
                </div>
  
                <div class="form-group">
                  <label for="max_participants">Max Number of Participants</label>
                  <input
                    type="number"
                    class="form-control"
                    id="trip_seats"
                    placeholder="Max Number of Participants"
                    v-model="formdata.max_participants"
                    min="1"
                    step="1"
                    required
                  />
                </div>
  
                <!-- <div class="form-group">
                                  <label for="trip_title">Trip Title</label>
                                  <input type="text" class="form-control" id="trip_title" placeholder="Trip Title"
                                      v-model="formdata.title">
                              </div> -->
  
                <div class="form-group">
                  <label for="program_year">Program Year:</label>
  
                  <input
                    class="form-control"
                    type="number"
                    id="program_year"
                    v-model="formdata.program_year"
                    placeholder="Enter Program Year"
                    min="1900"
                    max="2099"
                    step="1"
                  />
                </div>
  
                <div class="form-group">
                  <label for="start_date">Program Start Date:</label>
                  <input
                    type="date"
                    class="form-control"
                    id="start_date"
                    @change="calculateDaysBtwnDates()"
                    onfocus="this.showPicker()"
                    v-model="formdata.start_date"
                    placeholder="Departure Date"
                    required
                  />
                </div>
  
                <div class="form-group">
                  <label for="end_date">Program End Date:</label>
                  <input
                    type="date"
                    class="form-control"
                    id="end_date"
                    onfocus="this.showPicker()"
                    placeholder="Return Date"
                    v-model="formdata.end_date"
                    @change="calculateDaysBtwnDates()"
                    required
                  />
                </div>
  
                <div class="form-group">
                  <label for="trip_seats">Total Number of Days</label>
                  <input
                    type="number"
                    class="form-control"
                    id="total_number_of_days"
                    placeholder="Total Number of Days"
                    v-model="formdata.total_number_of_days"
                    min="1"
                    step="1"
                    readonly
                    required
                  />
                </div>
  
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                      <select class="form-select" id="type" v-model="person">
                        <option value="Select Coordinator">
                          Choose local Coordinators
                        </option>
                        <option
                          v-for="(name, id) in coordinatorsList"
                          :value="name.name"
                          :label="name.name"
                          v-bind:key="id"
                        >
                          {{ name.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                      <label>&nbsp;&nbsp;</label>
                      <button
                        @click="addCoordinator()"
                        type="button"
                        class="btn bg-gradient-success"
                      >
                        <i class="fa fa-user" aria-hidden="true"></i> Add
                        Coordinator to Trip
                      </button>
                    </div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                      <label>Selected Coordinators</label>
                      <ul id="array-rendering">
                        <li v-for="item in trip.coordinators" v-bind:key="item">
                          {{ item }}
                        </li>
                      </ul>
                    </div>
                  </div>
  
                  <div v-if="showError" class="invalid-feedback2">
                    {{ error.message }}
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <button
                    type="submit"
                    @click="addInboundProgram()"
                    class="btn bg-gradient-success"
                  >
                    Add New Inbound Program
                  </button>
                </div>
              </form>
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
  import moment from "moment";
  
  export default {
    name: "DataTables",
    setup() {
      let itineraryImageData = ref();
      let showUploadedImages = ref(false);
      let imagesTotal = ref(0);
      let locationsList = ref([]);
      let coordinatorsList = ref([]);
      let destinationsList = ref([]);
      let countriesList = ref([]);
      let inboundPartnerList = ref([]);
      let destinationTotal = ref(1);
      let itineraryData = ref({});
      let overviewTotal = ref(0);
      let showItinerary = ref(false);
      let schoolList = ref([]);
      let itineraryList = ref([]);
      let trip_id_prefix = ref("");
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
            if (item.country != "United States") {
              locationsList.value.push({ id: item.id, name: item.name });
            } else {
              if (
                !countriesList.value.some(
                  (country) => country.name === item.country
                )
              ) {
                destinationsList.value.push({ id: item.id, name: item.country });
                countriesList.value.push({ id: item.id, name: item.country });
              }
            }
          });
        })
        .catch((e) => {
          console.error(e);
        });
  
      //get partner list
      var newApiUrl = store.state.apiUrl + "partner";
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
  
          result.data.partners.forEach((partnerItem, index) => {
            if (partnerItem.type == "Inbound" || partnerItem.type == "Both") {
              try {
                inboundPartnerList.value.push({
                  id: partnerItem.id,
                  name: partnerItem.name,
                });
              } catch (err) {
                console.log(err.message);
              }
            }
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
  
      return {
        itineraryImageData,
        national_language: "",
        country_of_origin: "",
        imagesTotal,
        showUploadedImages,
        coordinatorsList,
        locationsList,
        overviewTotal,
        itineraryData,
        itineraryList,
        destinationsList,
        countriesList,
        inboundPartnerList,
        showItinerary,
        schoolList,
        person: "Select Coordinator",
        destinationTotal: 1,
        trip_id_prefix: "",
        trip: {
          coordinators: [],
          checklist: [],
          payments: [],
        },
        formdata: {
          title: "",
          school: "",
          originCity: 0,
          destinationCity: 0,
          max_participants: 0,
          total_number_of_days: "",
          description: "",
          program_year: "2024",
          start_city: "",
          trip_type: "",
          trip_itenary: "",
          dest_city: [],
          cost: 0.0,
          start_date: "",
          trip_id_prefix: "",
          end_date: "",
          total_seats: "",
          total_seats_min: "",
          registration_cutoff_date: "",
        },
        showError: false,
        error: {
          message: "",
        },
      };
    },
    methods: {
      addNewDestination() {
        this.destinationTotal++;
        this.$forceUpdate();
      },
      parseDate(start, end) {
        return moment(start, "YYYY.MM.DD HH:mm").diff(
          moment(end, "YYYY.MM.DD HH:mm"),
          "days"
        );
      },
      calculateDaysBtwnDates() {
        if (this.formdata.start_date > "" && this.formdata.end_date > "") {
          this.formdata.total_number_of_days = this.parseDate(
            this.formdata.end_date,
            this.formdata.start_date
          );
          this.$forceUpdate();
        }
      },
      addCoordinator() {
        this.trip.coordinators.push(this.person);
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
      updateSchool(event) {
        console.log(this.formdata.school);
        this.trip_id_prefix = this.formdata.school.toString() + "-";
        this.$forceUpdate();
      },
      updateItinerary(event) {
        console.log("You selected: " + this.formdata.trip_itenary);
  
        //get itinerary list item
        var newApiUrl =
          store.state.apiUrl + "master_itinerary/" + this.formdata.trip_itenary;
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
  
            this.itineraryData = result.data.itinerary;
  
            this.trip_id_prefix =
              this.formdata.school.toString() +
              "-" +
              result.data.itinerary.code +
              "-";
  
            this.overviewTotal = result.data.itinerary.overview.length;
  
            this.itineraryImageData = result.data.itinerary.images;
  
            this.imagesTotal = result.data.itinerary.images.length;
  
            this.showItinerary = true;
  
            if (this.imagesTotal > 0) {
              this.showUploadedImages = true;
            }
  
            this.$forceUpdate();
          })
          .catch((e) => {
            console.error(e);
          });
      },
      removeDestination(index) {
        console.log(index);
        this.destinationTotal--;
        this.$forceUpdate();
        this.destinationsList.splice(index, 1);
        if (index === 0) this.addNewDestination();
      },
      addInboundProgram() {
        this.destinationsList = [];
  
        this.$router.push({ path: "/inbound_programs/list", replace: true });
      },
    },
    mounted() {
      // eslint-disable-next-line no-unused-vars
    },
  };
  </script>
  
  <style>
  .overview-row {
    margin-bottom: 20px;
  }
  
  .img-flex {
    display: flex;
  }
  
  .img-preview {
    float: left;
    display: flex;
    width: 130px !important;
    padding: 3px;
  }
  </style>