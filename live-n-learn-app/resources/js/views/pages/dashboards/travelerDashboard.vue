<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-lg-12 position-relative z-index-2">
        <div class="mb-4 card card-plain">
          <div class="p-3 card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="d-flex flex-column h-100">
                  <h2 class="mb-0 font-weight-bolder">Trip Details</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Time Until Trip
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        {{ timeUntiTrip }} Days
                        <!-- <span class="text-success text-sm font-weight-bolder"
                          >+55%</span
                        > -->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Action Items
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        1
                        <!-- <span class="text-success text-sm font-weight-bolder"
                          >70%</span
                        > -->
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-bell-55 text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Group Messages
                      </p>
                      <h5 class="font-weight-bolder mb-0">
                        27
                        <span class="text-danger text-sm font-weight-bolder"
                          >3 new!</span
                        >
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div
                      class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md"
                    >
                      <i
                        class="ni ni-email-83 text-lg opacity-10"
                        aria-hidden="true"
                      ></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="col-xl-4 col-sm-6">
            <div class="card">
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-8">
                    <div class="numbers">
                      <p class="text-sm mb-0 text-capitalize font-weight-bold">
                        Payments Due
                      </p>
                      <h5 class="font-weight-bolder mb-0" ref="amount_due">
                        ${{
                          amount_due
                        }}
                      </h5>
                    </div>
                  </div>
                  <div class="col-4 text-end">
                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                      <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-lg-12">
                <div class="d-flex flex-column h-100">
                  <p class="mb-1 pt-2 text-bold">Trip at a glance</p>
                  <h3 class="font-weight-bolder text-success">
                    {{ tripData[0]?.title }}
                  </h3>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">Traveler</p>
                      </div>
                      <div class="row">
                        <p class="mb-2">{{ userData?.full_name }}</p>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">Departure Date</p>
                      </div>
                      <div class="row">
                        <p class="mb-2">{{ tripData[0]?.start_date }}</p>
                      </div>
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">Return Date</p>
                      </div>
                      <div class="row">
                        <p class="mb-2">{{ tripData[0]?.end_date }}</p>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">
                          Group Leader
                        </p>
                      </div>
                      <div class="row">
                        <div class="col-10 mb-2">
                          {{ tripData[0]?.group_leaders[0]?.full_name ?? 'No Group Leader' }}

                          <div class="col-2" v-if="tripData[0]?.group_leaders[0]">
                            <a class="btn btn-success" href="#"><i class="fa fa-envelope" aria-hidden="true"></i> </a>
                          </div>
                        </div>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">
                          Originating City
                        </p>
                      </div>
                      <div class="row">
                        <p class="mb-2">{{ tripData[0]?.origination.city }}</p>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                    <div class="col-lg-6">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">
                          Destination
                        </p>
                      </div>
                      <div class="row">
                        <p class="mb-2">
                          {{ tripData[0]?.destinations[0].city }}
                        </p>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                    <div class="col-lg-12">
                      <div class="row">
                        <p class="text-sm font-weight-bolder my-0">
                          Days Until Departure
                        </p>
                      </div>
                      <div class="row">
                        <p class="mb-2">
                          {{ timeUntiTrip }} Days
                        </p>
                      </div>
                      <!-- <p class="mb-2">Trip Date - 06/07/2024</p> -->
                    </div>
                  </div>

                  <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                    View Trip Details
                    <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mb-lg-0 mb-4 mt-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-flex flex-column h-100">
                    <p class="mb-1 pt-2 text-bold">Registration Forms</p>
                    <div class="row">
                      <div class="table-responsive">
                        <table id="datatable-search" class="table table-flush">
                          <thead class="thead-light">
                            <tr>
                              <th>Name</th>
                              <th>Status</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-sm font-weight-normal">
                                Traveler Info
                              </td>
                              <td class="text-sm font-weight-normal text-danger">
                                Incomplete
                              </td>
                              <td>
                                <span class="btn btn-success"
                                  @click="$router.push({ path: '/travelers/program/form_traveler' })">View/Edit
                                  Details</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm font-weight-normal">
                                Health Form
                              </td>
                              <td class="text-sm font-weight-normal text-danger">
                                Incomplete
                              </td>
                              <td>
                                <span class="btn btn-success"
                                  @click="$router.push({ path: '/travelers/program/form_health' })">View/Edit
                                  Details</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm font-weight-normal">
                                Passport
                              </td>
                              <td class="text-sm font-weight-normal text-danger">
                                Incomplete
                              </td>
                              <td>
                                <span class="btn btn-success"
                                  @click="$router.push({ path: '/travelers/program/passport' })">View/Edit Details</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="text-sm font-weight-normal">
                                Additonal Info
                              </td>
                              <td class="text-sm font-weight-normal text-danger">
                                Incomplete
                              </td>
                              <td>
                                <span class="btn btn-success"
                                  @click="$router.push({ path: '/travelers/program/additional' })">View/Edit
                                  Details</span>
                              </td>
                            </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-lg-12 mb-lg-0 mb-4 mt-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-flex flex-column h-100">
                    <p class="mb-1 pt-2 text-bold">Learn about your host!</p>
                    <div class="row">
                      <div
                        class="col-lg-4 aspect-square h-3"
                        style="aspect-ratio: 1/1"
                      >
                        <img
                          src="../../../assets/img/placeholderprofile.jpg"
                          height="80px"
                          width="80px"
                          class=""
                          style="border-radius: 40px"
                        />
                      </div>
                      <div class="col-lg-4 mt-2">
                        <div class="row">
                          <p class="text-sm font-weight-bolder my-0">Name</p>
                        </div>
                        <div class="row">
                          <p class="mb-2">The Does</p>
                        </div>
                      </div>
                      <div class="col-lg-4 mt-2">
                        <div class="row">
                          <p class="text-sm font-weight-bolder my-0">Likes</p>
                        </div>
                        <div class="row">
                          <ul style="list-style-type: none">
                            <li>Soccer</li>
                            <li>Hiking</li>
                            <li>Bike Riding</li>
                            <li>Grilling</li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <a
                      class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                      href="javascript:;"
                    >
                      View Hosts Details
                      <i
                        class="fas fa-arrow-right text-sm ms-1"
                        aria-hidden="true"
                      ></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <div class="col-lg-5 col-md-6">
        <div class="card">
          <div class="card-header pb-0">
            <h6>Itinerary overview</h6>
            <!-- <p class="text-sm">
              <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
              <span class="font-weight-bold">24%</span> this month
            </p> -->
          </div>
          <div class="card-body p-3">
            <div class="timeline timeline-one-side">
              <div class="timeline-block mb-3" v-for="(data, index) in this.tripData[0]?.itinerary" :key="index">
                <!-- {{ data }} -->
                <!-- test -->
                <span class="timeline-step">
                  <i class="text-dark text-gradient"> {{ index + 1 }}</i>
                </span>
                <div class="timeline-content">
                  <h6 class="text-dark text-sm font-weight-bold mb-0">
                    {{ data.title }}
                  </h6>
                  <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                    {{ data.content }}
                  </p>
                </div>
              </div>
            </div>
            <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
              View Full Itinerary
              <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <!-- <div class="col-lg-12 mb-lg-0 mt-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-12">
                  <div class="d-flex flex-column h-100">
                    <p class="mb-1 pt-2 text-bold">Payments</p>

                    <a
                      class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                      href="javascript:;"
                    >
                      View Payment Details
                      <i
                        class="fas fa-arrow-right text-sm ms-1"
                        aria-hidden="true"
                      ></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
    <div class="row mt-4"></div>
  </div>
</template>
<script>
import Card from "@/examples/Cards/Card.vue";
import ActiveUsersChart from "@/examples/Charts/ActiveUsersChart.vue";
import GradientLineChart from "@/examples/Charts/GradientLineChart.vue";
import Globe from "@/examples/Globe.vue";
import axios from "axios";
import store from "@/store/index.js";
import { ref, onMounted, onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import moment from "moment";
import { CountUp } from "countup.js";

export default {
  name: "DashboardDefault",
  components: {
    Card,
    ActiveUsersChart,
    GradientLineChart,
    Globe,
  },

  setup() {
    const router = useRoute();
    onBeforeMount(() => {
      // this.getUserData();
      return;
    });
    onMounted(() => {
      // console.log("Hello World");
    });

    return {
      outbound: true,
      inbound: false,
      router,
      stats: {
        iconBackground: "bg-gradient-success",
        money: {
          title: "Outbound: Total Travellers",
          value: "0",
          percentage: "+0%",
          iconClass: "ni ni-money-coins",
        },
        users: {
          title: "Inbound: Total Host Families",
          value: "0",
          percentage: "+0%",
          iconClass: "ni ni-world",
        },
        clients: {
          title: "Total Program Payments this year",
          value: "+3,462",
          percentage: "-2%",
          iconClass: "ni ni-paper-diploma",
          percentageColor: "text-danger",
        },
        sales: {
          title: "Total Sales",
          value: "$103,430",
          percentage: "+5%",
          iconClass: "ni ni-cart",
        },
      },
    };
  },
  data() {
    return {
      userData: {},
      tripData: {},
      itineraryData: {},
      timeUntiTrip: "",
      invoiceData: {},
      childrenData: {},
      amount_due: "0.00"
    };
  },
  methods: {
    getDaysUntilDeparture(trip_date) {

      var start = moment(moment().date(), "YYYY-MM-DD");
      var end = moment(trip_date, "YYYY-MM-DD");

      //Difference in number of days
      return moment.duration(start.diff(end)).asDays();
    },
    getUserData() {
      var user = JSON.parse(localStorage.getItem("user"));

      var newApiUrl = this.$store.state.apiUrl + "user_with_trips/" + user.id;

      axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((r) => {
          const result = r.data;
          console.log(result);
          if (result.user.class === 'traveler') {
            this.tripData = result.user.trips;
            this.userData = result.user;
          } else if (result.user.class === 'parent') {
            this.tripData = result.user.children[0]?.trips;
            this.userData = result.user.children[0];
            this.childrenData = result.user.children;
            localStorage.setItem('childrenId', this.childrenData[0].id)

          }

          localStorage.setItem('tripData', this.tripData[0].id);
          //for date dif
          const tripDate = moment(this.tripData[0]?.start_date);

          //const daysToTrip = getDaysUntilDeparture(tripDate);

          const now = moment(new Date());
          console.log(tripDate, now);
          const diff = tripDate.diff(now, "days", true);
          console.log(diff);

          this.timeUntiTrip = Math.round(diff);

          this.getInvoiceData();
          // this.itineraryData = result.user.trips[0].itinerary[0];

          // this.$router.push({
          //   path: "/dashboards/dashboard-default",
          //   replace: true,
          // });
        })
        .catch((e) => {
          this.showError = true;

          console.log(e)
        });
    },
    getInvoiceData() {
      var user = JSON.parse(localStorage.getItem("user"));
      var newApiUrl = "";
      if (user.role === 'traveler') {
        newApiUrl =
          this.$store.state.apiUrl +
          "user/" +
          user.id +
          "/trip/" +
          this.tripData[0]?.id +
          "/invoice";
      } else {
        newApiUrl =
          this.$store.state.apiUrl +
          "user/" +
          this.childrenData[0]?.id +
          "/trip/" +
          this.tripData[0]?.id +
          "/invoice";
      }
      console.log(newApiUrl);
      // return;
      axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((r) => {
          const result = r.data;
          console.log(result);

          this.invoiceData = result.invoice;
          this.amount_due = result.invoice?.amount_due.toLocaleString("en-US");
        })
        .catch((e) => {
          this.showError = true;
          console.log(e)
        });
    },
  },
  beforeMount() {
    this.getUserData();
  },
  mounted() {
    const amount_due_el = this.$refs.amount_due
    const countUp = new CountUp(amount_due_el
      , this.amount_due
    );
    // this.amount_due = countUp;
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  },
  computed: {
    // timeUntiTrip() {
    //   const tripDateFromNow = moment(this.tripData[0].start_date).fromNow();
    //   const now = moment.date();
    //   console.log(tripDateFromNow, now);
    //   return;
    //   const diff = now.diff(tripDateFromNow, "days", true);
    //   return diff;
    // },
  },
};
</script>
