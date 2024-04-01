<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-lg-12 position-relative z-index-2">
        <div class="mb-4 card card-plain">
          <div class="p-3 card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="d-flex flex-column h-100">
                  <h2 class="mb-0 font-weight-bolder">Program Statistics</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-2">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ router.params.year ?? "Select Year" }}
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="/dashboards/dashboard-default/2024">2024</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/dashboards/dashboard-default/2023">2023</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/dashboards/dashboard-default/2022">2022</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-sm-2">
            <button type="button" @click="scrollToClass('.outbound-heading')" class="btn btn-info w-100">
              <i class="fa fa-plane" aria-hidden="true"></i> Outbound
            </button>
          </div>
          <div class="col-12 col-sm-2">
            <button class="btn btn-warning w-100" type="button" @click="scrollToClass('.inbound-heading')">
              <i class="fa fa-plane" aria-hidden="true"></i> Inbound
            </button>
          </div>
        </div>

        <div class="mobile-responsive" v-show="outbound">
          <div class="row">
            <div class="col-lg-6">
              <div class="d-flex flex-column h-100">
                <h2 class="mb-0 font-weight-bolder outbound-heading">
                  Outbound
                </h2>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 mx-auto m-2" v-for="trip in filteredOutboundArray" v-bind:key="trip">
              <div class="card">
                <div class="p-3 pb-0 card-header">
                  <div class="d-flex align-items-center">
                    <h6 class="mb-0">{{ trip.name }} -{{ trip.trip_code }}</h6>
                  </div>
                </div>

                <div class="p-3 card-body">
                  <div class="row">
                    <div class="text-center col-12 col-sm-5 mt-5">
                      <h4 class="font-weight-bold text-center">
                        <i class="fa fa-users text-black p-2"></i><span class="text-info">
                          {{ trip.total_travelers }}</span><span class="fs-6 d-block text-body text-uppercase">Number of
                          Travelers</span>
                      </h4>
                    </div>
                    <div class="col-12 col-sm-7 px-xs-0">
                      <div class="table-responsive">
                        <table class="table mb-0 align-items-center">
                          <tbody>
                            <tr>
                              <td>
                                <div class="px-2 py-0 d-flex">
                                  <span class="badge bg-gradient-primary me-2">&nbsp;</span>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">
                                      Number of Group Leaders
                                    </h6>
                                  </div>
                                </div>
                              </td>
                              <td class="text-sm text-center align-middle">
                                <span class="text-xs font-weight-bold">
                                  {{ trip.group_leaders }}
                                </span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="px-2 py-0 d-flex">
                                  <span class="badge bg-gradient-secondary me-3">&nbsp;</span>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Male Travelers</h6>
                                  </div>
                                </div>
                              </td>
                              <td class="text-sm text-center align-middle">
                                <span class="text-xs font-weight-bold">
                                  {{ trip.male_travelers }}
                                </span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="px-2 py-0 d-flex">
                                  <span class="badge bg-gradient-info me-3">&nbsp;</span>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">
                                      Number of Female Travelers
                                    </h6>
                                  </div>
                                </div>
                              </td>
                              <td class="text-sm text-center align-middle">
                                <span class="text-xs font-weight-bold">
                                  {{ trip.female_travelers }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="px-2 py-0 d-flex">
                                  <span class="badge bg-gradient-success me-3">&nbsp;</span>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">
                                      Number of Male Group leaders:
                                    </h6>
                                  </div>
                                </div>
                              </td>
                              <td class="text-sm text-center align-middle">
                                <span class="text-xs font-weight-bold">
                                  {{ trip.male_leaders }}</span>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <div class="px-2 py-0 d-flex">
                                  <span class="badge bg-gradient-warning me-3">&nbsp;</span>
                                  <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">
                                      Number of Female Group leaders
                                    </h6>
                                  </div>
                                </div>
                              </td>
                              <td class="text-sm text-center align-middle">
                                <span class="text-xs font-weight-bold">
                                  {{ trip.female_leaders }}</span>
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
      </div>
    </div>
    <div class="mobile-responsive" v-show="inbound">
      <div class="row">
        <div class="col-lg-6">
          <div class="d-flex flex-column h-100">
            <h2 class="mb-0 font-weight-bolder inbound-heading">Inbound</h2>
          </div>
        </div>

        <div class="col-12 col-md-12">
          <div class="card">
            <div class="p-3 pb-0 card-header">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Total Host Families</h6>
              </div>
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">15</h6>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center">
                <tbody>
                  <tr v-for="(trip, index) in inboundTrips" :key="index">
                    <td class="w-30">
                      <div class="px-2 py-1 d-flex align-items-center">
                        <div class="ms-4">
                          <p class="mb-0 text-xs font-weight-bold">Location:</p>
                          <h6 class="mb-0 text-sm">
                            {{ trip.location }}
                          </h6>
                        </div>
                      </div>
                    </td>

                    <td>
                      <div class="text-center">
                        <p class="mb-0 text-xs font-weight-bold">
                          State/Province:
                        </p>
                        <h6 class="mb-0 text-sm">
                          {{ trip.state_province }}
                        </h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="mb-0 text-xs font-weight-bold">Country:</p>
                        <h6 class="mb-0 text-sm">
                          {{ trip.country }}
                        </h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="mb-0 text-xs font-weight-bold">
                          Total HF completed:
                        </p>
                        <h6 class="mb-0 text-sm">
                          {{ trip.hf_completed }}
                        </h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="mb-0 text-xs font-weight-bold">
                          Total HF in Progress:
                        </p>
                        <h6 class="mb-0 text-sm">
                          {{ trip.hf_inprogress }}
                        </h6>
                      </div>
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
</template>
<script>
import Card from "@/examples/Cards/Card.vue";
import ActiveUsersChart from "@/examples/Charts/ActiveUsersChart.vue";
import GradientLineChart from "@/examples/Charts/GradientLineChart.vue";
import Globe from "@/examples/Globe.vue";

import US from "@/assets/img/icons/flags/US.png";
import DE from "@/assets/img/icons/flags/DE.png";
import GB from "@/assets/img/icons/flags/GB.png";
import BR from "@/assets/img/icons/flags/BR.png";
import SP from "@/assets/img/icons/flags/spain.png";
import FR from "@/assets/img/icons/flags/france.png";
import axios from "axios";
import store from "@/store/index.js";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

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
    const outboundTrips = ref([
      {
        name: "Cincy to Multiple Trips to Africa and Spain",
        trip_code: "cvgXNT5QC",
        trip_type: "Travel",
        total_travelers: "15",
        male_travelers: "5",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2024-01-29"),
        end_date: new Date("2024-02-08"),
      },
      {
        name: "Cincy to Multiple Trips to Africa and Spain",
        trip_code: "cvgXNT5QC",
        trip_type: "Travel",
        total_travelers: "15",
        male_travelers: "5",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2023-01-29"),
        end_date: new Date("2023-02-08"),
      },
      {
        name: "Cincinnati to Paris",
        trip_code: "DS6N14DD",
        trip_type: "HOMESTAY",
        total_travelers: "20",
        male_travelers: "10",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2024-02-01"),
        end_date: new Date("2024-02-15"),
      },
      {
        name: "Welcome to Jurassic Park",
        trip_code: "IA3TN0",
        trip_type: "TRAVEL",
        total_travelers: "15",
        male_travelers: "5",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2024-02-01"),
        end_date: new Date("2024-02-09"),
      },
      {
        name: "Barcelona to New York",
        trip_code: "",
        trip_type: "TRAVEL",
        total_travelers: "20",
        male_travelers: "10",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2024-03-01"),
        end_date: new Date("2024-03-08"),
      },
      {
        name: "Experience Spain like never before",
        trip_code: "SDRZLS",
        trip_type: "TRAVEL",
        total_travelers: "15",
        male_travelers: "5",
        female_travelers: "10",
        group_leaders: "5",
        female_leaders: "5",
        male_leaders: "1",
        beginning_date: new Date("2024-03-01"),
        end_date: new Date("2024-03-22"),
      },
    ]);
    const inboundTrips = ref([
      {
        location: "Rabat",
        state_province: "Rabat Province",
        country: "Morroco",
        hf_completed: "15",
        hf_inprogress: "30",
      },
      {
        location: "San Jose",
        state_province: "San Jose Province",
        country: "Costa Rica",
        hf_completed: "5",
        hf_inprogress: "3",
      },
    ]);

    return {
      outboundTrips,
      inboundTrips,
    };
  },
  methods: {
    scrollToClass(className) {
      if (className == ".inbound-heading") {
        this.outbound = false;
        this.inbound = true;
      }

      if (className == ".outbound-heading") {
        this.outbound = true;
        this.inbound = false;
      }
      this.$forceUpdate();
    },
  },
  computed: {
    filteredOutboundArray() {
      const yearParam = parseInt(this.$route.params.year, 10);
      console.log(yearParam);
      if (isNaN(yearParam)) {
        return this.outboundTrips;
      } else {
        return this.outboundTrips.filter((item) => {
          const itemYear = item.beginning_date.getUTCFullYear(); // Adjust as per your object structure
          console.log(itemYear);

          return itemYear === yearParam;
        });
      }
    },
  },
};
</script>