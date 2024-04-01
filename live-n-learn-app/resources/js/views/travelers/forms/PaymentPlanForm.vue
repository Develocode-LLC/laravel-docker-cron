<template>
    <form class="container-fluid" @submit.prevent="submit">
        <div class="row">
            <div class="col-md-10 card mx-auto">
                <div class="row mb-4">
                    <div class="col-8 mx-auto">
                        <h6 class="text-center fs-2">Payment Plans</h6>

                        <i class="text-sm text-muted">Payments will be processed through Stripe, a secure online payment
                            processor. In your Live N Learn account please click on the button that says Make Payments
                            and you
                            will be redirected to Pay Simple. All payments must be made by ACH transfer with your
                            checking
                            account. You may also mail a check to Live N Learn at PO Box 42214, Cincinnati, OH
                            45242.</i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Payment Plan <i class="text-danger">*</i>
                                <p class='text-xxs'>please select</p>
                            </label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_plan_type" id="payment_plan_auto"
                                    v-model="formData.payment_plan_type" value="automated">
                                <label class="custom-control-label text-lg" for="payment_plan_auto">Automatic
                                    Payments</label>
                                <div class="row">
                                    <i class="text-sm text-muted"> After initial $250 deposit, payments will be divided into
                                        monthly installments and deducted from the payment method used for your initial
                                        payment, finalizing around 45 days prior to departure. Select this method to avoid
                                        late fees and spread payments out over a longer time.</i>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_plan"
                                    id="payment_plan_dual_payment" v-model="formData.payment_plan_type"
                                    value="dual_payment">
                                <label class="custom-control-label text-lg" for="payment_plan_dual_payment">Dual Payment
                                    Plan</label>
                                <div class="row">
                                    <i class="text-sm text-muted"> After the initial $250 deposit, your remaining balance
                                        will be split into two payments. The first half of the remaining balance is due 90
                                        days after deposit and the final balance due 110 days prior to departure.
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-8 mx-auto">
                        <ul>
                            <li>
                                <p class="text-muted text-sm">
                                    <strong>If your trip registration deadline is greater than 365 days prior to trip
                                        departure:</strong> After the $250 deposit, you must pay half of the remaining
                                    balance
                                    90 days after the registration deadline and full payment 90 days before departure.
                                </p>
                            </li>
                            <li>
                                <p class="text-muted text-sm">
                                    <strong>If your trip registration deadline is less than 365 days prior to trip
                                        departure:</strong> After the $250 deposit, you must pay half of the remaining
                                    balance by November 15 and full payment 90 days before departure.
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Payment Method <i class="text-danger">*</i></label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method_type" id="payment_method"
                                    v-model="formData.payment_method_type" value="stripe">
                                <label class="custom-control-label" for="payment_method_online">I will pay online via
                                    Credit Card </label>
                                <div class="row">
                                    <i class="text-sm text-muted">(Note: A service charge will be added on all credit
                                        cards.)</i>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method_type"
                                    id="payment_method_mail" v-model="formData.payment_method_type" value="check">
                                <label class="custom-control-label" for="payment_method_mail">I will mail in a physical
                                    check to Live N Learn at PO Box 42214, Cincinnati, OH 45242. </label>
                                <div class="row">
                                    <i class="text-sm text-muted"> Payment must be received by due date.</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                Submit
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</template>
<script>
import axios from 'axios'
import store from '@/store';

export default {


    data() {

        return {

            formData: {
                payment_plan_type: "Automatic Payments", // or Dual Payment Plan
                payment_method_type: "online" // or mail
            },
            tripList: null
        }
    },
    methods: {
        async fetchTrips() {
            var user = JSON.parse(localStorage.getItem("user"));

            var newApiUrl = this.$store.state.apiUrl + "user_with_trips/" + user.id;


            await axios.get(newApiUrl, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {
                console.log(result.data);
                this.tripList = result.data.user.trips[0];
            }).catch(error => {
                console.error(error)
            })
        },
        /**
         * 
            Dennis
            POST /api/v1/user/{user_id}/trip/{trip_id}/set_payment_plan
            Body: {"payment_plan_type": "automated|dual_payment", "payment_method_type": "stripe|check",}
         */
        async submit() {
            var user = JSON.parse(localStorage.getItem("user"));
            console.log('Send off data', this.formData, this.tripList.id)
            var newApiUrl = store.state.apiUrl + `user/${user.id}/trip/${this.tripList.id}/set_payment_plan`;

            console.log(this.formData, newApiUrl)
            // return;
            await axios.post(newApiUrl,
                this.formData,
                {
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: "Bearer " + localStorage.token,
                    },
                }
            ).then((result) => {
                console.log(result)
            }).catch((e) => {
                console.log(e)
            })
        },
    },
    beforeMount() {
        this.fetchTrips();
    }
}
</script>
<style scoped></style>