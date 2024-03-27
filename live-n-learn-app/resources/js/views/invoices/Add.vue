<template>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-md-8 col-sm-10 mx-auto">
          <form class action="index.html" method="post">
            <div class="card my-sm-5">
              <div class="card-header text-center">
                <div class="row justify-content-between">
                    <div class="col-12 text-md-end">
                        <button
                            type="button"
                            class="btn bg-gradient-success"
                            @click="createInvoice"
                            >
                            Create Invoice
                        </button>
                    </div>
                </div>
                <div class="row justify-content-between">
                  <div class="col-md-4 text-start">
                    <img class="mb-2 w-25 p-2" src="../../assets/img/logo-ct.png" alt="Logo" />
                    <h6>Live N Learn</h6>
                    <p class="text-secondary">
                      PO Box 42214
                      <br />Cincinnati, OH 45242
                      <br />tel: +1 800 409 4319
                    </p>
                  </div>
                  <div class="col-lg-3 col-md-7 text-md-end text-start mt-5">
                    <div class="form-group">
                        <label for="recipient">Recipient</label>
                        <select
                            class="form-select"
                            id="recipient"
                            v-model="recipient"
                        >
                            <option value="0">Select Recipient</option>
                            <option
                                v-for="(recipient, id) in recipientList"
                                :value="recipient.id"
                                :label="recipient.full_name"
                                :key="{ id }"
                            >
                                {{ recipient.full_name }}
                            </option>
                        </select>
                    </div>
                    <!-- <h6 class="d-block mt-2 mb-0">Billed to: {{ invoice.recipient ? invoice.recipient.full_name : '' }}</h6>
                    <p class="text-secondary">
                      {{ invoice.recipient ? invoice.recipient.address_1 : '' }}
                      <br />{{ invoice.recipient ? invoice.recipient.city : '' }},  {{ invoice.recipient ? invoice.recipient.state_province : '' }} {{ invoice.recipient ? invoice.recipient.postal_code : '' }}
                    </p> -->
                  </div>
                </div>
                <br />
                <div class="row justify-content-md-between">
                  <div class="col-md-4 mt-auto">
                    <!-- <h6 class="mb-0 text-start text-secondary">Invoice no</h6>
                    <h5 class="text-start mb-0">{{ invoice.invoice_number }}</h5> -->
                  </div>
                  <div class="col-lg-5 col-md-7 mt-auto">
                    <div class="row mt-md-5 mt-4 text-md-end text-start">
                      <div class="col-md-6">
                        <h6 class="text-secondary mb-0">Invoice date:</h6>
                      </div>
                      <div class="col-md-6">
                        <h6 class="text-dark mb-0">{{ moment().format('MM/DD/YYYY') }}</h6>
                      </div>
                    </div>
                    <div class="row text-md-end text-start">
                      <div class="col-md-6">
                        <h6 class="text-secondary mb-0">Due date:</h6>
                      </div>
                      <div class="col-md-6">
                        <h6 class="text-dark mb-0">
                            <input
                            type="date"
                            class="form-control"
                            id="due_date"
                            placeholder="Due Date"
                            onfocus="this.showPicker()"
                            v-model="dueDate"
                            required
                            />
                        </h6>
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
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>


                          <tr v-for="idx in parseInt(invoiceItemTotal)" :key="idx">
                            <td class="text-start">
                                <input
                                type="text"
                                class="form-control"
                                id="item_name"
                                placeholder="Enter an Item Name"
                                v-model="invoiceItems[idx - 1].name"
                                required
                                />
                            </td>
                            <td class="ps-4" colspan="3">
                                <input
                                type="text"
                                class="form-control"
                                id="item_description"
                                placeholder="Enter an Item Description"
                                v-model="invoiceItems[idx - 1].description"
                                required
                                />
                            </td>
                            <td class="ps-4">
                                <input
                                type="text"
                                class="form-control"
                                id="amount"
                                placeholder="Amount"
                                @change="updateSubtotal()"
                                v-model="invoiceItems[idx - 1].line_total"
                                required
                                />
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn bg-gradient-warning"
                                    @click="removeInvoiceLineItem(idx - 1)"
                                >
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                          </tr>
                          <tr>
                            <td class="ps-4" colspan="6">
                                <button
                                    type="button"
                                    class="btn bg-gradient-success w-100"
                                    @click="addInvoiceLineItem()"
                                >
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Line Item
                                </button>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th class="h5 ps-4" colspan="2">Total</th>
                            <th colspan="1" class="text-right h5 ps-4">$ {{ subtotal }}</th>
                            <th></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    import VsudButton from "@/components/VsudButton.vue";
    import axios from "axios";
    import store from "@/store/index.js";
    import { ref } from "vue";
    import moment from "moment";
  
  export default {
    name: "Invoice",
    created: function () {
        this.moment = moment;
    },
    components: {
      VsudButton,
    },
    setup() {
        let formData = ref({});
        let invoiceItems = ref([{"name": "", "description": "", "line_total": 0}]);
        let invoiceItemTotal = ref(1);
        let recipientList = ref([]);
        let dueDate = ref("");
        let recipient = ref(0);
        let subtotal = ref(0);
        let invoice = ref({});
  
      return {
        formData: {
            invoice_items: [],
            recipient_id: 0,
            due_date: ""
        },
        invoiceItems,
        recipientList,
        invoiceItemTotal,
        dueDate,
        recipient,
        invoice,
        subtotal
      };
    },
    methods: {
        async fetchRecipients() {
            var newApiUrl = store.state.apiUrl + 'user?class=traveler';

            await axios.get(newApiUrl, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {
                this.recipientList = result.data.users;
            }).catch(error => {
                console.error(error)
            })
        },
        addInvoiceLineItem() {
            this.invoiceItemTotal++;
            this.invoiceItems.push({"name": "", "description": "", "line_total": 0});
            this.$forceUpdate();
        },
        updateSubtotal() {
            this.subtotal = this.invoiceItems.reduce(
                (invoiceSum, invoice) => parseFloat(invoiceSum) + parseFloat(invoice.line_total),
                0,
            );
            this.$forceUpdate();
        },
        async createInvoice() {

          let newApiUrl = `${store.state.apiUrl}invoice/`;
          this.formData = {
            recipient_id: this.recipient,
            due_date: this.dueDate,
            invoice_items: this.invoiceItems
          };

          await axios.post(newApiUrl, this.formData, {
              headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json',
                  'Authorization': 'Bearer ' + localStorage.token
              }
          }).then(result => {
            this.$router.go(-1)
          }).catch(error => {
              console.error(error)
          })
        },
        removeInvoiceLineItem(index) {
            this.invoiceItems.splice(index, 1);
            this.invoiceItemTotal--;
            this.updateSubtotal();
            
            if (this.invoiceItemTotal === 0) this.addInvoiceLineItem();
            
            this.$forceUpdate();
        },
        
    },
    async mounted() {
        await this.fetchRecipients();
    },
  };
  </script>
  