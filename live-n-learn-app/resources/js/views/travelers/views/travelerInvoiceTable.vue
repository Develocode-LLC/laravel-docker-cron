<template>
  <div class="py-4 container-fluid">

    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn - User Invoices</h5>

          </div>

          <div class="row ml-2">
            <div class="col-4">
              <a class="btn btn-success" href="/flights/add"><i class="fa fa-plus" aria-hidden="true"></i> Add
                New Flight </a>
            </div>
          </div>

          <div class="table-responsive">
            <table id="datatable-flights" class="table table-flush">
              <thead class="thead-light">
                <!-- Airline Flight Number Originating City Destination Departure Time Arrival Time -->
                <tr>
                  <th>Invoice #</th>
                  <th>Issue Date</th>
                  <th>Due Date</th>
                  <th>Subtotal</th>
                  <th>Amount Due</th>
                  <!-- <th>Destination</th>
                  <th>Departure Time</th>
                  <th>Arrival Time</th> -->
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data, index) in invoiceData" :key="index">
                  <td>{{ data.invoice_number }}</td>
                  <td>{{ data.issue_date }}</td>
                  <td>{{ data.due_date }}</td>
                  <td>${{ data?.subtotal.toLocaleString("en-US") }}</td>
                  <td>${{ data?.amount_due.toLocaleString("en-US") }}</td>
                  <td>
                    <button type="button" class="btn btn-success"
                      @click="$router.push({ path: `/invoices/${data.id}` })">View Invoice</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import axios from "axios";
export default {
  name: 'travelerInvoiceTable',
  setup() {

  },
  data() {
    return {
      invoiceData: {}
    }
  },
  methods: {
    async getInvoiceData() {
      var user = JSON.parse(localStorage.getItem("user"));
      var childId = localStorage.getItem("childrenId");
      var newApiUrl = "";
      if (user.class === 'traveler') {
        newApiUrl =
          this.$store.state.apiUrl +
          "user/" +
          user.id +
          "/invoice"
      } else {
        newApiUrl =
          this.$store.state.apiUrl +
          "user/" +
          childId +
          "/invoice"
      }
      console.log(newApiUrl);
      // return;
      await axios
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

          this.invoiceData = result.invoices;
        })
        .catch((e) => {
          this.showError = true;
          console.log(e)
        });
    },
  },
  beforeMount() {
    this.getInvoiceData()
  }
}
</script>
