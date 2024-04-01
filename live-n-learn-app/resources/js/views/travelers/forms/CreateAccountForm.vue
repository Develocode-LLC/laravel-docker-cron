<template>
    <form @submit.prevent="submit" class="shadow-md rounded m-4 p-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="trip_id"> Trip Id </label>
                    <input type="text" class="form-control" id="trip_id" placeholder="trip Id"
                        v-model="formData.trip_id" required disabled />
                    <small v-if="showError && formData.trip_id.length <= 0" id="traveler_fname-error"
                        class="form-text text-danger text-sm font-weight-light">{{ error.message }}</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="traveler_fname"> Traveler First Name </label>
                    <input type="text" :class="{
        'error-input':
            showError &&
            formData.traveler_fname.length <= 0,
    }" class="form-control" id="traveler_fname" placeholder="First Name"
                        v-model="formData.traveler_fname" required />
                    <small v-if="showError && formData.traveler_fname.length <= 0" id="traveler_fname-error"
                        class="form-text text-danger text-sm font-weight-light">{{ error.message }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="traveler_lname" class="">
                        Traveler Last Name
                    </label>
                    <input type="text" class="form-control" id="traveler_lname" placeholder="Last Name"
                        v-model="formData.traveler_lname" required />
                    <small v-if="showError && formData.traveler_lname.length <= 0" id="lname-error"
                        class="form-text text-danger text-sm font-weight-light">
                        {{ error.message }}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="traveler_email"> Traveler Email </label>
                    <input type="traveler_email" class="form-control" id="email" placeholder="user@example.com"
                        v-model="formData.traveler_email" required />
                    <small v-if="showError && formData.traveler_email.length <= 0" id="lname-error"
                        class="form-text text-danger text-sm font-weight-light">
                        {{ error.message }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="traveler_phone" class="">
                        Traveler Phone
                    </label>
                    <input type="tel" class="form-control" id="traveler_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                        placeholder="555-555-5555" v-model="formData.traveler_phone" required />
                    <small v-if="showError && formData.traveler_phone.length <= 0" id="lname-error"
                        class="form-text text-danger text-sm font-weight-light">
                        {{ error.message }}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_email"> Parent/Guardian's Email </label>
                    <input type="pgemail" class="form-control" id="parent_email" placeholder="user@example.com"
                        v-model="formData.parent_email" required />
                    <small v-if="showError && formData.parent_email.length <= 0" id="lname-error"
                        class="form-text text-danger text-sm font-weight-light">
                        {{ error.message }}</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="parent_phone" class="">
                        Parent/Guardian's Phone
                    </label>
                    <input type="tel" class="form-control" id="parent_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                        placeholder="555-555-5555" v-model="formData.parent_phone" required />
                    <small v-if="showError && formData.parent_phone.length <= 0" id="lname-error"
                        class="form-text text-danger text-sm font-weight-light">
                        {{ error.message }}</small>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-center">
            <button type="submit" class="btn bg-gradient-success submit-btn w-50" @click.prevent="createAccount()">
                <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
                Create Account
            </button>
        </div>
    </form>
</template>
<script>
import axios from "axios";
import { ref } from "vue";
import store from "@/store/index.js";
export default {
    setup() {
        let tripList = ref([]);
        let newApiUrl = store.state.apiUrl + "trip";

        axios
            .get(newApiUrl, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer" + localStorage.token,
                },
            })
            .then((result) => {
                result.data.trips.forEach((trip) => {
                    console.log(trip);
                    //tripList.push(trip.id);
                });
            });
    },
    data() {
        return {
            showError: false,
            error: {
                message: "",
            },
            formData: {
                trip_id: "",
                traveler_fname: "",
                traveler_lname: "",
                traveler_email: "",
                traveler_phone: "",
                parent_name: "",
                parent_email: "",
                parent_phone: "",
            },
        };
    },
    methods: {
        checkForEmpty(obj) {
            for (let key in obj) {
                if (obj.hasOwnProperty(key) && obj[key] === "") {
                    this.showError = true;
                    this.error.message = "Field Is Required";
                }
            }
        },
        createAccount() {
            const newApiURL = this.$store.state.apiUrl + "";

            if (this.checkForEmpty(this.formData)) {
                this.showError = true;

                return;
            }

            console.log("Send data", this.formData);
        },
    },
};
</script>
<style>
.ml-4 {
    margin-left: 1rem;
}

.submit-btn {
    width: 80%;
}

.error-input {
    border: 0.2rem solid red !important;
}

.error-input:focus {
    border: 0.2rem solid red !important;
}
</style>
