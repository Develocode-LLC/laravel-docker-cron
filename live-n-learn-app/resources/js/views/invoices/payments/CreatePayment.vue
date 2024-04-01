<template>
    <div class="col">
        <button type="button" class="btn bg-gradient-success float-end" data-bs-toggle="modal"
            data-bs-target="#createPaymentModal">
            <i class="fa fa-money-bill" aria-hidden="true"></i> Add Payment
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createPaymentModal" tabindex="-1" role="dialog" aria-labelledby="createPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPaymentModalLabel">Create Payment</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="isAdmin">

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select class="form-select" id="payment_method" v-model="formdata.payment_method">
                                    <option value="">Select Payment Method</option>
                                    <option value="ach">ACH</option>
                                    <option value="cash">Cash</option>
                                    <option value="check">Check</option>
                                    <option value="credit">Credit</option>
                                    <option value="other">Other</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="payment_date">Date</label>
                                <input type="date" class="form-control" id="payment_date" onfocus="this.showPicker()"
                                    placeholder="Payment Date" v-model="formdata.date" required />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Amount">Amount</label>
                                <input type="text" class="form-control" id="amount" placeholder="Amount"
                                    v-model="formdata.amount">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="payment_notes" rows="3" placeholder="Enter Notes here"
                                    v-model="formdata.notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" v-else>
                    <stripePaymentMethod :userId="userData.id" :invoiceId="invoice_id" />
                </div>
                <div class="modal-footer" v-if="isAdmin">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn bg-gradient-primary" @click="confirmPayment()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import store from "@/store/index.js";
import bootstrap from "bootstrap/dist/js/bootstrap";
import VsudButton from "@/components/VsudButton.vue";
import { ref } from "vue";
import stripePaymentMethod from "@/components/stripePaymentMethod.vue";

export default {
    name: "CreatePayment",
    props: {
        reloadInvoice: {
            type: Function,
        },
        reloadPayments: {
            type: Function,
        },
        isAdmin: {
            type: Boolean,
        },
        user: {
            type: String,
        }
    },
    components: {
        stripePaymentMethod
    },
    emits: [],
    setup() {

    },
    data() {
        return {
            formdata: {
                payment_method: "",
                date: "",
                amount: "",
                notes: ""
            },
            userData: JSON.parse(this.user),
            invoice_id: this.$route.params.id
        };
    },
    methods: {
        async confirmPayment() {

            let newApiUrl = `${store.state.apiUrl}invoice/${this.invoice_id}/invoice_payment`;

            await axios.post(newApiUrl, this.formdata, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {
                console.log(result)

                var myModalEl = document.getElementById('createPaymentModal')
                var modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()

                // $emit('reload')

                this.reloadInvoice();
                this.reloadPayments();
            }).catch(error => {
                console.error(error)
            })
        },

    },
};
</script>
