<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Create New Trip</h5>
            <p class="mb-0 text-sm">
              Use this tool to add an upcoming Trip here
            </p>
          </div>
          <div class="row" style="margin: 10px">
            <form @submit.prevent="submit">
              <div class="form-group">
                <label for="school">School</label>
                <select
                  class="form-select"
                  id="school"
                  v-model="formdata.school"
                  @change="updateSchool()"
                >
                  <option value="">Select School</option>
                  <option
                    v-for="(name, id) in schoolList"
                    :value="name.id"
                    :label="name.name"
                  >
                    {{ name.name }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label for="strip_type">Trip Itinerary</label>
                <select
                  class="form-select"
                  id="trip_itenary"
                  v-model="formdata.trip_itenary"
                  @change="updateItinerary()"
                >
                  <option value="">Select Trip Itinerary</option>
                  <option
                    v-for="itinerary in itineraryList"
                    :value="itinerary.id"
                    :label="itinerary.title"
                  >
                    {{ itinerary.title }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label for="trip_title">Trip Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="trip_title"
                  placeholder="Trip Title"
                  v-model="formdata.title"
                />
              </div>
              <div class="row" v-show="showItinerary">
                <!-- <div class="form-group">
                  <label for="Itinerary_name">Itinerary Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="Itinerary_name"
                    placeholder="Itinerary Name"
                    v-model="itineraryData.description"
                  />
                </div> -->
                <div class="form-group">
                  <label for="trip_code">Itinerary Code</label>
                  <input
                    type="text"
                    class="form-control"
                    id="Itinerary_code"
                    placeholder="Itinerary Code"
                    v-model="itineraryData.code"
                  />
                </div>

                <div class="form-group">
                  <label for="trip_code"><b>Itinerary Overview</b></label>
                </div>

                <div
                  class="row overview-row"
                  v-for="n in parseInt(overviewTotal)"
                  :key="n"
                >
                <div class="col-md-2 col-12">
                    <div class="form-group">
                        <label for="trip_description" style="display: block">{{ n }}: Image</label>
                        <!-- <button @click="showGallery(n-1)" type="button" class="btn bg-gradient-success"><i
                            class="fa fa-image" aria-hidden="true"></i>
                        Choose Image</button> -->
                        <div class="col-md-6 col-12">
                                <img :src="itineraryData.overview[n-1].media_file.uri" title="Hello World"  class="img-fluid img-thumbnail" />
                        </div>

                    </div>
                </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="trip_title" style="display: block"
                        >Day {{ n }}: Title</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter Title"
                        v-model="itineraryData.overview[n - 1].title"
                        ref="overview_title"
                      />
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="trip_description" style="display: block"
                        >Day {{ n }}: Description</label
                      >
                      <textarea
                        class="form-control"
                        id="trip_description"
                        rows="4"
                        v-model="itineraryData.overview[n - 1].content"
                        placeholder="Enter Description here"
                      ></textarea>
                    </div>
                  </div>

                  <div class="col-md-2 col-12">
                    <div class="form-group" style="margin-top: 25px !important">
                      <button
                        type="button"
                        @click="removeOverview()"
                        class="btn bg-gradient-warning"
                      >
                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                      </button>
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label for="strip_type">Trip Type</label>
                <select
                  class="form-select"
                  id="trip_type"
                  v-model="formdata.trip_type"
                >
                  <option value=""></option>
                  <option value="travel">Travel</option>
                  <option value="homestay">Travel + Homestay</option>
                  <option value="homestay classes">Homestay + Classes</option>
                </select>
              </div>

              <div class="form-group" style="display: none">
                <label for="trip_description">Description</label>
                <textarea
                  class="form-control"
                  id="trip_description"
                  rows="3"
                  placeholder="Enter Program Description here"
                  v-model="formdata.description"
                ></textarea>
              </div>
              <div class="form-group">
                <label for="origin_city">Departure City</label>
                <select
                  class="form-select"
                  id="origin_city"
                  v-model="formdata.start_city"
                >
                  <option value="">Select City</option>
                  <option
                    v-for="(name, id) in departureList"
                    :value="name.id"
                    :label="name.name"
                    :key="{ id }"
                  >
                    {{ name.name }}
                  </option>
                </select>
              </div>

              <div class="row" v-for="idx in parseInt(destinationTotal)" :key="idx">
                <div class="col-12 col-md-10">
                  <div class="form-group">
                    <label for="origin_city">Destination</label>
                    <select
                      class="form-select"
                      id="destination"
                      ref="destination"
                      v-model="formdata.destinations[idx - 1]"
                    >
                      <option selected value="">Select Destination</option>
                      <option
                        v-for="(name, id) in destinationList"
                        :value="name.id"
                        :label="name.name"
                        v-bind:key="id"
                      >
                        {{ name.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-2 align-bottom">
                  <div class="form-group">
                    <label for="origin_city" style="display: block"
                      >&nbsp;</label
                    >
                    <button
                      @click="removeDestination(idx)"
                      type="button"
                      class="btn bg-gradient-warning"
                    >
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-12">
                  <button
                    type="button"
                    @click="addNewDestination()"
                    class="btn bg-gradient-success"
                  >
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Add
                    Additional Destination
                  </button>
                </div>
                <div class="col-4">
                  <!-- <button type="button" @click="updateDestination()" class="btn bg-gradient-warning"><i
                                            class="fa fa-map-marker" aria-hidden="true"></i> Update Locations
                                        Destination</button> -->
                </div>
              </div>

              <div class="form-group">
                <label for="trip_cost">Total Trip Price($)</label>
                <input
                  type="text"
                  class="form-control"
                  id="trip_cost"
                  v-model="formdata.total_cost"
                  placeholder="Trip Price $00.00"
                  required
                />
              </div>

              <div class="form-group">
                <label for="trip_cost">Optional Cancellation Insurance</label>
              </div>

              <div class="form-group">
                <label for="trip_cost">Basic($)</label>
                <input
                  type="number"
                  class="form-control"
                  id="basic_cost"
                  v-model="formdata.basic_cost"
                  placeholder="Basic Price $00.00"
                  step="any"
                  required
                />
              </div>

              <div class="form-group">
                <label for="trip_cost">Elite($)</label>
                <input
                  type="number"
                  class="form-control"
                  id="elite_cost"
                  v-model="formdata.elite_cost"
                  placeholder="Elite Price $00.00"
                  step="any"
                  required
                />
              </div>

              <div class="form-group">
                <label for="start_date">Departure Date:</label>
                <input
                  type="date"
                  class="form-control"
                  id="start_date"
                  onfocus="this.showPicker()"
                  v-model="formdata.start_date"
                  @change="calculateDaysBtwnDates()"
                  placeholder="Departure Date"
                  required
                />
              </div>

              <div class="form-group">
                <label for="end_date">Return Date:</label>
                <input
                  type="date"
                  class="form-control"
                  id="end_date"
                  onfocus="this.showPicker()"
                  placeholder="Return Date"
                  @change="calculateDaysBtwnDates()"
                  v-model="formdata.end_date"
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

              <div class="form-group">
                <label for="trip_seats">Min Group Size</label>
                <input
                  type="number"
                  class="form-control"
                  id="trip_seats_min"
                  placeholder="Min Group Size"
                  v-model="formdata.total_seats_min"
                  min="1"
                  step="1"
                  required
                />
              </div>

              <div class="form-group">
                <label for="trip_seats">Max Group Size</label>
                <input
                  type="number"
                  class="form-control"
                  id="trip_seats"
                  placeholder="Max Group Size"
                  v-model="formdata.total_seats"
                  min="1"
                  step="1"
                  required
                />
              </div>

              <div class="form-group">
                <label for="end_date">Registration Deadline:</label>
                <input
                  type="date"
                  class="form-control"
                  id="registration_cutoff_date"
                  onfocus="this.showPicker()"
                  placeholder="Registration Deadline"
                  v-model="formdata.registration_cutoff_date"
                  required
                />
              </div>

              <div class="form-group">
                <label for="trip_seats">Trip ID</label>
                <input
                  type="text"
                  class="form-control"
                  id="trip_id_prefix"
                  placeholder="Enter Trip ID"
                  v-model="trip_id_prefix"
                />
              </div>

              <div v-if="showError" class="invalid-feedback2">
                {{ error.message }}
              </div>

              <button
                type="submit"
                @click="addProgram()"
                class="btn bg-gradient-success"
              >
              <i class="fa fa-save"></i> Add New Trip
              </button>
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
    let schoolList = ref([]);
    let itineraryList = ref([]);

    let itineraryImageData = ref();
    let showUploadedImages = ref(false);
    let imagesTotal = ref(0);

    let itineraryData = ref({});

    let departureList = ref([]);
    let destinationList = ref([]);

    let destinationTotal = ref(1);
    let overviewTotal = ref(0);
    let showItinerary = ref(false);
    let trip_id_prefix = ref("");
    //get locations list
    var newApiUrl = store.state.apiUrl + "location";
    axios
      .get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((result) => {

        result.data.locations.forEach(item => {
          if (item.country == "United States") {
            departureList.value.push({ id: item.id, name: item.name });
          } else {
            destinationList.value.push({ id: item.id, name: item.country });
          }
        });
      })
      .catch((error) => {
        console.error(error);
      });

    //get schools list
    var newApiUrl = store.state.apiUrl + "school";
    axios
      .get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((result) => {

        result.data.schools.forEach(item => {
          schoolList.value.push({ id: item.id, code: item.code, name: item.name });
        });
      })
      .catch((error) => {
        console.error(error);
      });

    //get itinerary list
    var newApiUrl = store.state.apiUrl + "master_itinerary";
    axios
      .get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((result) => {

        result.data.itineraries.forEach(item => {
          itineraryList.value.push({ id: item.id, title: item.title });
        });
      })
      .catch((error) => {
        console.error(error);
      });

    return {
      itineraryImageData,
      imagesTotal,
      showUploadedImages,
      departureList,
      overviewTotal,
      itineraryData,
      itineraryList,
      destinationList,
      showItinerary,
      schoolList,
      destinationTotal: 1,
      trip_id_prefix: "",
      formdata: {
        title: "",
        school: "",
        originCity: 0,
        destinations: [],
        description: "",
        start_city: "",
        trip_type: "",
        trip_itenary: "",
        dest_city: [],
        total_cost: 0.0,
        basic_cost: 0.0,
        elite_cost: 0.0,
        start_date: "",
        trip_id_prefix: "",
        end_date: "",
        total_number_of_days: "",
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
    addNewDestination() {
      this.destinationTotal++;
      this.$forceUpdate();
    },
    removeDestination(index) {

      this.formdata.destinations.splice(index, 1);
      this.destinationTotal--;

      if (this.destinationTotal === 0) this.addNewDestination();

      this.$forceUpdate();
    },
    updateSchool(event) {
      let selected_school = this.schoolList.find(({ id }) => id === this.formdata.school);

      this.trip_id_prefix = selected_school.code.toString() + "-";
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
          Authorization: `Bearer ${localStorage.token}`,
          },
        })
        .then((result) => {
          console.log(result.data);

          let selected_school = this.schoolList.find(({ id }) => id === this.formdata.school);

          this.itineraryData = result.data.itinerary;

          this.trip_id_prefix = `${selected_school.code}-${result.data.itinerary.code}-`;

          let itinerary_destinsations = result.data.itinerary.destinations;

          this.destinationTotal = itinerary_destinsations.length;
          this.formdata.destinations = itinerary_destinsations.map(({id}) => id);

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
    addProgram() {
      var newApiUrl = this.$store.state.apiUrl + "trip";
      axios
        .post(
          newApiUrl,
          {
            school_id: this.formdata.school,
            title: this.formdata.title,
            description: this.formdata.title,
            origination_location_id: this.formdata.start_city,
            destinations: this.formdata.destinations,
            prefix: this.trip_id_prefix,
            total_cost: Number(this.formdata.total_cost).toFixed(2),
            basic_cost: Number(this.formdata.basic_cost).toFixed(2),
            elite_cost: Number(this.formdata.elite_cost).toFixed(2),
            start_date: this.formdata.start_date,
            end_date: this.formdata.end_date,
            min_available_seats: this.formdata.total_seats_min,
            max_available_seats: this.formdata.total_seats,
            type: this.formdata.trip_type,
            registration_cutoff_date: this.formdata.registration_cutoff_date,
            code: this.trip_id_prefix

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
          console.log(r.data);
          console.log('trip added');
          //trip.id

          this.addProgramItinerary(r.data.trip.id);
        })
        .catch((e) => {
          console.log(e);
          console.log(e.message);

          this.showError = true;

          //message
          this.error.message = e.message;
        });
    },

addProgramItinerary(program_id) {
      var newApiUrl = this.$store.state.apiUrl + "trip/" + program_id + "/itinerary/" + this.formdata.trip_itenary + "/assign";
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
          const result = r.data;

          this.$router.push({ path: "/trips/view", replace: true });
        })
        .catch((e) => {
          console.log(e);
          console.log(e.message);

          this.showError = true;

          //message
          this.error.message = e.message;
        });
    }
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
