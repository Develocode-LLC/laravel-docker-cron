<template>
    <div class="container-fluid p-2">
        <div class="row">
            <div class="card col-12 mx-auto">
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-center fs-2">
                            Optional Cancellation Insurance

                        </h6>
                    </div>
                </div>
                <div class="row p-4">
                    <div class="col-12 ">
                        <p class="">Policy Details</p>
                        <a class="nav-link mb-0 px-0 py-1 active"
                            href="https://drive.google.com/file/d/1T9LpQEs1bCKx0edQvL80h8947Bx8_RI0/view?usp=sharing">See
                            policy brochure here.</a>
                    </div>
                </div>
                <div class="row p-4">
                    <div class="col-12">
                        <p class="block text-md  "><strong>BASIC:</strong> This policy offers a 100% refund in the
                            event of
                            cancellation due to: emergency
                            illness; injury or death to you, a family member or travel companion; financial default; a
                            terrorist incident; jury duty; home made uninhabitable by fire, wind, storm, flood or
                            vandalism; quarantine; auto accident on way to airport; job termination; canceled leave for
                            active duty military, police or firefighters.</p>
                        <p class="block text-md">
                            <strong>ELITE:</strong> This policy offers a 100% refund in the event of cancellation due
                            to: emergency illness; injury or death to you, a family member or travel companion;
                            financial default; a terrorist incident; jury duty; home made uninhabitable by fire, wind,
                            storm, flood or vandalism; quarantine; auto accident on way to airport; job termination;
                            canceled leave for active duty military, police or firefighters. It will refund you 75% of
                            program cost if you decide to cancel for any other reason not specified above. You will only
                            receive the Cancel For Any Reason Benefit if policy is purchased within 20 days of your
                            initial deposit. <strong>THIS MUST BE PURCHASED AT THE TIME OF DEPOSIT IN ORDER TO BE
                                ELIGIBLE FOR THIS POLICY.</strong>

                        </p>
                    </div>
                </div>
                <div class="row p-4">
                    <i class="text-sm text-muted p-2 mb-2">The following benefits are also included in both
                        policies:</i>
                    <div class="col-8 mx-auto">
                        <table class="table ">

                            <tbody>
                                <tr>
                                    <td>Trip Cancellation</td>
                                    <td>Trip cost up to $25,000</td>
                                </tr>
                                <tr>
                                    <td>Travel Delay</td>
                                    <td>Up to $2,000 ($200 daily limit)</td>
                                </tr>
                                <tr>
                                    <td>Baggage Delay</td>
                                    <td>Up to $500 in clothing/personal items</td>
                                </tr>
                                <tr>
                                    <td>Trip Interruption</td>
                                    <td>100% of trip cost</td>
                                </tr>
                                <tr>
                                    <td>Cancel for Any Reason</td>
                                    <td>75% of trip cost if purchased at time of deposit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <form @submit.prevent="submit">
                            <p class="text-center p-2">Optional Cancellation Insurance*
                            </p>
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="has_optional_cancellation_insurance">Would you like to purchase an
                                            Optional Cancellation Insurance
                                            policy? </label>
                                        <select class="form-control" v-model="formData.has_optional_cancellation_insurance"
                                            id="has_optional_cancellation_insurance">
                                            <option :value="true">Yes</option>
                                            <option :value="false">No</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="formData.has_optional_cancellation_insurance">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cancellation_type">Would you like to
                                            purchase an
                                            Optional Cancellation Insurance
                                            policy? </label>
                                        <select class="form-control" v-model="formData.cancellation_type"
                                            id="cancellation_type">
                                            <option value="basic">BASIC</option>
                                            <option value="elite">ELITE</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="formData.has_optional_cancellation_insurance">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <p class="lead text-sm text-center"><i>
                                                This will be added to your cart at time of
                                                deposit.
                                            </i> </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">


                                <div class="col-md-4 d-flex justify-content-center w-100">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg w-100">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { toast } from 'vue3-toastify';

export default {
    data() {
        return {
            formData: {
                has_optional_cancellation_insurance: false,
                cancellation_type: "basic" // or elite
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
         * POST /api/v1/user/{user_id}/trip/{trip_id}/cancellation_insurance
         */
        async submit() {
            var user = JSON.parse(localStorage.getItem("user"));

            var newApiUrl = this.$store.state.apiUrl + `user/${user.id}/trip/${this.tripList.id}/cancellation_insurance`;
            await axios.post(
                newApiUrl,
                {
                    type: this.formData.has_optional_cancellation_insurance ? this.formData.cancellation_type : 'none'
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.token
                    }
                }
            ).then((result) => {

                toast.success('Optional Cancellation Policy added!', { position: toast.POSITION.BOTTOM_CENTER })
            }).catch((e) => {

            })
            /** TODO - API  */
        },
        async getOptCancellation() {
            var user = JSON.parse(localStorage.getItem("user"));

            var newApiUrl = this.$store.state.apiUrl + `user/${user.id}/trip/${this.tripList.id}/cancellation_insurance`;
            await axios.get(
                newApiUrl,
                {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            ).then((result) => {

            }).catch((e) => {

            })
            /** TODO - API  */
        },
    },
    beforeMount() {
        this.fetchTrips();
    }
}
</script>