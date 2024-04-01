<template>
    <form class="container-fluid " @submit.prevent="submit">
        <div class="row p-4">
            <div class="col-md-12 card mx-auto">
                <h6 class="fs-4 text-center mb-4">Traveler Additional Information</h6>
                <div class="row p-4">
                    <div class="col-12">
                        <div class="form-group">

                            <label class="form-control-label">Have you hosted with Live N Learn before?</label>
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" v-model="formData.prior_host"
                                    name="prior_host" id="prior_host_true" :value="1" />
                                <label class="custom-control-label" for="prior_host_true">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="formData.prior_host"
                                    name="prior_host" id="prior_host_false" :value="0" />
                                <label class="custom-control-label" for="prior_host_false">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-4" v-if="formData.prior_host">
                    <div class="col-6 p-2 ">
                        <div class="form-group">
                            <label class="form-control-label" for="year_hosted">If yes, In what year did your family
                                host a
                                student with Live
                                N
                                Learn?</label>
                            <input type="text" id="year_hosted" class="form-control" :disabled="!formData.prior_host" />
                        </div>
                    </div>
                </div>
                <div class="row p-4">
                    <div class="col-12">
                        <div class="form-group">

                            <label class="form-control-label">Do you feel comfortable riding a bike?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="formData.rides_bike"
                                    name="bike_rider" id="bike_rider_true" :value="1" />
                                <label class="custom-control-label" for="bike_rider_true">Yes</label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input" type="radio" v-model="formData.rides_bike"
                                    name="bike_rider" id="bike_rider_false" value="0" />
                                <label class="custom-control-label" for="bike_rider_false">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- colleg credit information -->
                <div class="row p-4">
                    <div class="col-6">
                        <div class="form-check form-switch">

                            <input class="form-check-input" type="checkbox" v-model="formData.college_credit_info"
                                name="college_credit_info" id="college_credit_info_true"
                                @change="sendCollegeCreditEmail" />
                            <label class="form-control-label">College Credit?</label>
                            <p class="info text-muted">
                                Are you interested in receiving more information
                                about how you can earn college credit for
                                participating
                                in this trip?
                            </p>
                        </div>

                    </div>
                </div>
                <!-- scholarship -->
                <div class="row p-4">
                    <div class="col-6">
                        <div class="form-check form-switch">

                            <input class="form-check-input" type="checkbox" v-model="formData.scholarships_info"
                                name="college_credit_info" id="college_credit_info_true"
                                @change="sendScholarshipEmail" />
                            <label class="form-control-label">Scholarships?</label>
                            <p class="info text-muted">
                                Are you interested in receiving more information
                                about how you can earn a scholarship toward your
                                trip?
                            </p>
                        </div>

                    </div>
                </div>
                <!-- submit button -->
                <div class="row p-4 mx-auto">
                    <div class="col-12">
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
import axios from "axios";

import { nextTick } from "vue";
import { toast } from 'vue3-toastify';
export default {

    data() {
        return {
            formData: {
                prior_host: 0,
                hosted_year: "",
                rides_bike: 0,
                college_credit_info: false,
                scholarships_info: false,
            },
        };
    },
    beforeMount() {
        this.getUserData()
    },
    methods: {
        async getUserData() {

            var user = JSON.parse(localStorage.getItem("user"));
            var newApiUrl = this.$store.state.apiUrl + "user_with_trips/" + user.id;
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
                    this.userData = result.user;
                    this.formData.rides_bike = result.user.rides_bike;
                    console.log(result.user.previously_hosted, "got user data")
                    if (result.user.previously_hosted === null) {
                        this.formData.previously_hosted = false;
                    } else {
                        this.formData.previously_hosted = result.user.previously_hosted;
                    }





                })
                .catch((e) => {
                    this.showError = true;

                    this.error.message = e
                });
        },
        sendScholarshipEmail(e) {
            if (this.formData.scholarships_info) {
                console.log('send email')
                toast.success("Email sent!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

            }


        }, sendCollegeCreditEmail(e) {
            if (this.formData.college_credit_info) {
                console.log('send email')
                toast.success("Email sent!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

            }


        },

        submit() {
            console.log("validation required");
            console.log("data", this.formData);
        },
    },
};
</script>
<style>
.info {
    font-size: 0.75rem;
}

.info-sm {
    font-size: 0.5rem;
    margin: 0;
    padding: 0;
    white-space: pre;
}

.ml-4 {
    margin-left: 4rem;
}
</style>
