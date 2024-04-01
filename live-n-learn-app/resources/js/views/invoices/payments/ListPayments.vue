<template>
  <div class="py-4 container-fluid">

    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <div class="container">
              <div class="row">
                <div class="col-6">
                  <h5 class="mb-0">Payments</h5>
                </div>
                <div class="col-6">
                  <!-- <a class="btn bg-gradient-success float-end" href="#invoices/add">
                                <i class="fa fa-file-invoice" aria-hidden="true"></i> Create Invoice
                            </a> -->

                  <create-payment @reloadInvoice="reloadInvoice" @reloadPayments="refreshPaymentList" :user="localUser"
                    :isAdmin="isAdmin" />
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table id="payment-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Date</th>
                  <th>Payment Method</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>

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
import { DataTable } from "simple-datatables";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from 'vue';
import CreatePayment from "@/views/invoices/payments/CreatePayment.vue";

//   const paymentSearchDatatable = new DataTable("#payment-search", {
//         searchable: true,
//         fixedHeight: true,
//     });

export default {
  name: "ListPayments",
  props: {
    reloadInvoice: {
      type: Function,
    }
  },
  components: {
    CreatePayment
  },
  setup() {
    let paymentList = ref([]);
    let paymentSearchDatatable;
    const isAdmin = ref()
    const localUser = localStorage.getItem('user');
    return {
      paymentList,
      paymentSearchDatatable,
      isAdmin,
      localUser,
    }
  },
  methods: {
    async fetchInvoicePayments() {
      let invoice_id = this.$route.params.id;
      let newApiUrl = `${store.state.apiUrl}invoice/${invoice_id}/invoice_payment`;

      await axios.get(newApiUrl, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + localStorage.token
        }
      }).then(result => {
        this.paymentList = result.data.invoice_payments;
      }).catch(error => {
        console.error(error)
      })
    },
    async loadDataTable() {
      let paymentRows = new Array();

      this.paymentSearchDatatable = new DataTable("#payment-search", {
        searchable: true,
        fixedHeight: true,
      });

      await this.fetchInvoicePayments();

      this.paymentList.forEach((payment) => {
        let rowArray = new Array(payment.date, payment.payment_method.toUpperCase(), `$${payment.amount.toFixed(2)}`);

        paymentRows.push(rowArray);
      });

      this.paymentSearchDatatable.insert({ data: paymentRows });
    },
    async refreshPaymentList() {
      let paymentRows = new Array();

      await this.fetchInvoicePayments();

      this.paymentList.forEach((payment) => {
        let rowArray = new Array(payment.date, payment.payment_method.toUpperCase(), `$${payment.amount.toFixed(2)}`);

        paymentRows.push(rowArray);
      });

      this.paymentSearchDatatable.destroy();
      this.paymentSearchDatatable = new DataTable("#payment-search", {
        searchable: true,
        fixedHeight: true,
      });
      this.paymentSearchDatatable.insert({ data: paymentRows });
    }
  },
  async mounted() {
    await this.loadDataTable();

    if (this.localUser.role === "administrator") {
      this.isAdmin = true;
    } else {
      this.isAdmin = false;
    }

  }
};
</script>
<style>
.ml-1 {
  margin-left: 10px !important;
}
</style>
  