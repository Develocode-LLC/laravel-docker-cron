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
                          <h5 class="mb-0">Invoices</h5>
                      </div>
                      <div class="col-6">
                          <a class="btn bg-gradient-success float-end" href="/invoices/add">
                              <i class="fa fa-file-invoice" aria-hidden="true"></i> Create Invoice
                          </a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="table-responsive">
            <table id="invoice-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Invoice Number</th>
                  <th>Recipient</th>
                  <th>Issue Date</th>
                  <th>Due Date</th>
                  <th>Amount Due</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

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

export default {
  name: "DataTables",
  components: { },
  setup() {
      let invoiceList = ref([]);

      return {
        invoiceList
      }
  },
    methods: {
        async fetchInvoices() {
            var newApiUrl = store.state.apiUrl + 'invoice';

            await axios.get(newApiUrl, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {
                this.invoiceList = result.data.invoices;
            }).catch(error => {
                console.error(error)
            })
        },
        async loadDataTable() {
            let invoiceRows = new Array();

            const invoiceSearchDatatable = new DataTable("#invoice-search", {
                searchable: true,
                fixedHeight: true,
            });

            await this.fetchInvoices();

            this.invoiceList.forEach((invoice) => {

                let btnViewInvoice =   `<a class="btn btn-success" href="/invoices/${invoice.id}">
                                        <i class="fa fa-file-invoice" aria-hidden="true"></i> View Invoice
                                    </a>`;

                let rowArray = new Array(invoice.invoice_number, `${invoice.recipient.full_name} (${invoice.recipient.account_number})`, invoice.issue_date, invoice.due_date, invoice.amount_due.toString(), btnViewInvoice);

                invoiceRows.push(rowArray);
            });

            invoiceSearchDatatable.insert({data: invoiceRows});
        },
        createInvoice() {

        }
    },
    async mounted() {
        await this.loadDataTable();
    }
};
</script>
<style>
.ml-1 {
  margin-left: 10px !important;
}
</style>
