<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Your Prefered Payment Methods</h5>
            <p class="mb-0 text-sm">Use this to set your payment method</p>
          </div>
          <div class="row">
            <stripe-payment-method :form-function="formType" />
            <stripe-ach-payment-method />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { useRoute } from "vue-router";
import axios from "axios";
import stripePaymentMethod from "@/components/stripePaymentMethod.vue";
import stripeAchPaymentMethod from "@/components/stripeACHPaymentMethod.vue"
import { ref } from Vue;

export default {
  components: { stripePaymentMethod, stripeAchPaymentMethod },
  setup() {
    let formType = ref("store");

    console.log("This is from the paymentMethod.vue", formType.value);

    return {
      formType
    }
  },
  // el: "#tabs",
  // data() {
  //   return {
  //     activetab: "1",
  //     formdata: {
  //       title: "",
  //       description: "",
  //       start_city: "",
  //       dest_city: "",
  //       cost: 0.0,
  //       start_date: "",
  //       end_date: "",
  //       total_seats: "",
  //       person: "",
  //       checklists: "",
  //       trip: {
  //         coordinators: [],
  //         checklist: [],
  //       },
  //     },
  //     form: "store",
  //   };
  // },
  methods: {
    addCoordinator() {
      this.formdata.trip.coordinators.push(this.formdata.person);
    },
    addChecklist() {
      this.formdata.trip.checklist.push(this.formdata.checklists);
    },
  },

  mounted() {
    const route = useRoute();
    const paramId = route.params.id;

    console.log(paramId);
  },
};
</script>

<style>
/* Import Google Font */
@import url(https://fonts.googleapis.com/css?family=Nunito+Sans);

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
  padding: 12px 24px;
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