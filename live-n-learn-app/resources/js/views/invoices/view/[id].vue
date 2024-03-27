<template>
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-8 col-sm-10 mx-auto">
        <form class action="index.html" method="post">
          <div class="card my-sm-5">
            <div class="card-header text-center">
              <div class="row justify-content-between">
                <div class="col-md-4 text-start">
                  <img class="mb-2 w-25 p-2" src="../../../assets/img/logo-ct.png" alt="Logo" />
                  <h6>Live N Learn</h6>
                  <p class="text-secondary">
                    PO Box 42214
                    <br />Cincinnati, OH 45242
                    <br />tel: +1 800 409 4319
                  </p>
                </div>
                <div class="col-lg-3 col-md-7 text-md-end text-start mt-5">
                  <h6 class="d-block mt-2 mb-0">Billed to: {{ invoice.recipient ? invoice.recipient.full_name : '' }}</h6>
                  <p class="text-secondary">
                    {{ invoice.recipient ? invoice.recipient.address_1 : '' }}
                    <br />{{ invoice.recipient ? invoice.recipient.city : '' }},  {{ invoice.recipient ? invoice.recipient.state_province : '' }} {{ invoice.recipient ? invoice.recipient.postal_code : '' }}
                  </p>
                </div>
              </div>
              <br />
              <div class="row justify-content-md-between">
                <div class="col-md-4 mt-auto">
                  <h6 class="mb-0 text-start text-secondary">Invoice no</h6>
                  <h5 class="text-start mb-0">{{ invoice.invoice_number }}</h5>
                </div>
                <div class="col-lg-5 col-md-7 mt-auto">
                  <div class="row mt-md-5 mt-4 text-md-end text-start">
                    <div class="col-md-6">
                      <h6 class="text-secondary mb-0">Invoice date:</h6>
                    </div>
                    <div class="col-md-6">
                      <h6 class="text-dark mb-0">{{ invoice.issue_date }}</h6>
                    </div>
                  </div>
                  <div class="row text-md-end text-start">
                    <div class="col-md-6">
                      <h6 class="text-secondary mb-0">Due date:</h6>
                    </div>
                    <div class="col-md-6">
                      <h6 class="text-dark mb-0">{{ invoice.due_date }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table text-right">
                      <thead class="bg-default">
                        <tr>
                          <th scope="col" class="pe-2 text-start ps-2">Description</th>
                          <th scope="col" class="pe-2" colspan="3"></th>
                          <th scope="col" class="pe-2">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="invoice_item in invoice.invoice_items">
                          <td class="text-start">{{ invoice_item.name }}</td>
                          <td class="ps-4">{{ invoice_item.description }}</td>
                          <td class="ps-4" colspan="2"></td>
                          <td class="ps-4">$ {{ invoice_item.line_total }}</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th></th>
                          <th></th>
                          <th class="h5 ps-4" colspan="2">Total</th>
                          <th colspan="1" class="text-right h5 ps-4">$ {{ invoice.subtotal }}</th>
                        </tr>
                        <tr>
                          <th></th>
                          <th></th>
                          <th class="h5 ps-4" colspan="2">Amount Paid</th>
                          <th colspan="1" class="text-right h5 ps-4">$ {{ invoice.amount_paid }}</th>
                        </tr>
                        <tr>
                          <th></th>
                          <th></th>
                          <th class="h5 ps-4" colspan="2">Amount Due</th>
                          <th colspan="1" class="text-right h5 ps-4">$ {{ invoice.amount_due }}</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

        <list-payments :reloadInvoice="fetchInvoice"/>
      </div>
    </div>
  </div>

</template>

<script>
  import VsudButton from "@/components/VsudButton.vue";
  import axios from "axios";
  import store from "@/store/index.js";
  import { ref } from "vue";
  import ListPayments from "@/views/invoices/payments/ListPayments.vue";

export default {
  name: "Invoice",
  components: {
    VsudButton,
    ListPayments
  },
  setup() {
      let invoice = ref({});

      return {
        invoice
      }
  },
  methods: {
      async fetchInvoice() {

          let invoice_id = this.$route.params.id;
          var newApiUrl = store.state.apiUrl + 'invoice/' + invoice_id;

          await axios.get(newApiUrl, {
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json',
                  'Authorization': 'Bearer ' + localStorage.token
              }
          }).then(result => {
              this.invoice = result.data.invoice;
          }).catch(error => {
              console.error(error)
          })
      }
  },
  async mounted() {
      await this.fetchInvoice();
  },
};
</script>
