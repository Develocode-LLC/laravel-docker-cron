<template>
    <form class="container-fluid  " @submit.prevent="submit">
        <div class="row ">
            <div class="col-md-10 card mx-auto">
                <h6 class="fs-4 text-center mb-4">Passport Upload Form</h6>

                <div class="row">

                    <div class="col-6 mx-auto ">
                        <div class="form-group ">
                            <label class="form-control-label">Do you have a passport that is valid for at least 6
                                months after the return date of the trip?</label>

                            <div class="form-check  ">
                                <input class="form-check-input" type="radio" name="valid_passport"
                                    id="valid_passport_yes" :value="true" v-model="formData.passport_valid" />
                                <label class="" for="valid_passport_yes">Yes, it is valid at least 6 months after return
                                    date of trip</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="valid_passport"
                                    id="valid_passport_no" :value="false" v-model="formData.passport_valid" />
                                <label class="" for="valid_passport_no">No</label>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- passport issue data -->
                <div class="row" v-if="formData.passport_valid">
                    <div class="col-6 col-md-6 mx-auto">
                        <div class="form-group">

                            <label class="form-control-label">
                                Passport Issue Date
                            </label>
                            <input class="form-control" type="date" id="passport_issue_date"
                                v-model="formData.passport_issue_date" />
                        </div>
                    </div>
                </div>


                <!-- Passport Expiration date -->
                <div class="row" v-if="formData.passport_valid">
                    <div class="col-6 col-md-6 mx-auto">
                        <div class="form-group">

                            <label class="form-control-label">
                                Passport Expiration
                            </label>
                            <input class="form-control" type="date" id="passport_expiration_date"
                                v-model="formData.passport_expiration_date" @change="validatePassportDate" />


                        </div>
                    </div>
                </div>
                <!-- no passport  -->
                <div class="row" v-if="!formData.passport_valid">
                    <div class="col-6 mx-auto">
                        <p class="text-left w-100 block">
                            Please apply for your passport and submit no later than 110 days before departure. Visit
                            <ins>
                                <a class="text-underline"
                                    href="https://travel.state.gov/content/travel/en/passports/how-apply.html"
                                    target="_blank">here</a>

                            </ins> for more information on how to apply.
                        </p>
                    </div>
                </div>
                <!-- expired passport warning -->
                <div class="row" v-if="formData.passport_date_valid === false">
                    <div class="col-6 col-md-6 mx-auto">
                        <p class=" text-left w-100 block">
                            Passports must be valid for at least 6 months after the return date. Please renew
                            your passport and submit no later than 110 days before departure.
                        </p>
                    </div>
                </div>
                <!-- passport image shown if valid passport available -->
                <div class="row p-2 mx-auto" v-if="formData.passport_valid">
                    <div class="col-12 ">
                        <div class="form-group">
                            <img height="500" :src="passport_image" alt="Image of Traveler passport">
                        </div>
                    </div>
                </div>
                <!-- File upload -->
                <div class="row p-2" v-if="!formData.passport_valid">
                    <div class="col-6 mx-auto">
                        <div class="form-group">

                            <label for="passportFile">Upload Passport File:</label>
                            <input :disabled="!formData.passport_valid || !formData.passport_date_valid"
                                class="form-control" type="file" id="passportFile" @change="handlePassportUpload" />
                        </div>

                    </div>
                </div>


                <div class="row p-4">
                    <div class="col-4 mx-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg w-100"
                                :disabled="formData.passport_valid">
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
import { reactive, ref } from "vue";
import store from "@/store/index.js";
import axios from "axios";
import moment from "moment";
import { nextTick } from "vue";
import { toast } from 'vue3-toastify';

// import { nextTick } from "vue";
export default {
    data() {
        return {
            // currentDate: "",
            userData: null,
            passport_image: null,
            formData: {
                passport_valid: false,
                passport_date_valid: false,



                passport_issue_date: "",
                passport_expiration_date: "",
                passport_file: null,
            },
        };
    },
    beforeMount() {
        this.getUserData();

    },
    onMounted() {

        this.validatePassportDate()
    },
    methods: {
        async submit() {
            var user = JSON.parse(localStorage.getItem("user"));
            // POST /api/v1/user/{user_id}/upload_passport
            const postPassportAPI = this.$store.state.apiUrl + `user/${user.id}/upload_passport`;
            if (this.passport_valid === false || this.passport_date_valid === false) {
                // add toastify

                toast.error("passport not valid", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });


            }
            await axios.post(postPassportAPI, {
                passport: this.formData.passport_file,
                passport_issue_date: this.formData.passport_issue_date,
                passport_expiration_date: this.formData.passport_expiration_date,


            }, {

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.token,
                }
            }).then(r => {
                toast.success("Passport updated!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

            })



        },

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
                    this.formData.passport_issue_date = result.user.passport_issue_date;
                    this.formData.passport_expiration_date = result.user.passport_expiration_date;
                    console.log(result.user.passport_file_location)
                    this.passport_image = result.user.passport_uri;

                    nextTick(() => {
                        this.validatePassportDate();
                    })

                })
                .catch((e) => {
                    this.showError = true;

                    this.error.message = e
                });
        },

        handlePassportUpload(event) {
            this.formData.passport_file = event.target.files[0];
        },
        validatePassportDate() {
            try {
                const tripEndDate = this.userData.trips[0].end_date;

                const passportExpirationDate = moment(this.formData.passport_expiration_date);
                const returnDate = moment(tripEndDate);

                const diff = passportExpirationDate.diff(returnDate, 'months');

                console.log(diff)

                if (diff <= 6) {
                    console.log('passport invalid')

                    this.formData.passport_valid = false;
                    this.formData.passport_date_valid = false;

                } else {
                    console.log('passport valid')

                    this.formData.passport_valid = true;
                    this.formData.passport_date_valid = true;
                }
            } catch (e) {

                this.error.message = 'Error Validating passport dates'
                this.showError = true;
            }

        },
        formatDate(date) {
            if (!date) return;
            const year = date.getFullYear();
            let month = (1 + date.getMonth()).toString().padStart(2, "0");
            let day = date.getDate().toString().padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
    },
};
</script>
