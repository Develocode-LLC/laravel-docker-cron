<template>
    <form class="shadow-md rounded m-4 p-4" @submit.prevent="submit">
        <div class="row">
            <h6 class="fs-4">Passport</h6>
            <div class="col-md-4">
                <div class="form-group">
                    <small class="fs-6"
                        >Do you have a passport that is valid for at least 6
                        months after the return date of the trip?</small
                    >
                    <div class="form-check mb-3 mt-3">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="valid_passport"
                            id="valid_passportYes"
                            :value="true"
                            :v-model="formData.passport_valid"
                        />
                        <label class="" for="valid_passportYes"
                            >Yes, it is valid at least 6 months after return
                            date of trip</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="valid_passport"
                            id="valid_passportNo"
                            :value="false"
                            :v-model="formData.passport_valid"
                        />
                        <label class="" for="valid_passportNo">No</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="example-date-input" class="form-control-label"
                        >What is the Date of Issue of your passport?
                    </label>
                    <input
                        class="form-control"
                        type="date"
                        value="2018-11-23"
                        id="passport_issue_date"
                        :v-model="formData.passport_issue_date"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="example-date-input" class="form-control-label"
                        >What is the Date of Expiration of your passport?
                    </label>
                    <input
                        class="form-control"
                        type="date"
                        :value="currentDate"
                        id="passport_expiration_date"
                        :v-model="formData.passport_expiration_date"
                        @change="validatePassportDate"
                    />
                </div>
            </div>
        </div>
        <div class="row" v-if="formData.passport_valid">
            <div class="col-md-12">
                <label for="passportFile">Upload Passport File:</label>
                <input
                    class="form-control"
                    type="file"
                    id="passportFile"
                    @change="handlePassportUpload"
                />
            </div>
        </div>
        <div class="row mt-4">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg w-100">
                    Submit
                </button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    data() {
        return {
            currentDate: "",
            formData: {
                passport_valid: false,
                passport_issue_date: "",
                passport_expiration_date: "",
                passport_file: null,
            },
        };
    },
    mounted() {
        this.getCurrentDate();
    },
    methods: {
        submit() {
            console.log("validation required");
            console.log("data", this.formData);
        },
        handlePassportUpload(event) {
            this.formData.passport_file = event.target.files[0];
        },
        validatePassportDate(e) {
            console.log(e.target.value);
            this.formData.passport_expiration_date = e.target.value;
            const selectedDate = new Date(e.target.value);
            const today = new Date();
            const sixMonthsFromToday = new Date();
            sixMonthsFromToday.setMonth(today.getMonth()) + 6;

            if (selectedDate < sixMonthsFromToday) {
                this.formData.passport_valid = false;
                console.log(
                    "Passport expiration date must be at least 6 months from today.",
                    selectedDate,
                    sixMonthsFromToday,
                    this.formData.passport_expiration_date
                );
            } else {
                this.formData.passport_valid = true;
            }
        },
        getCurrentDate() {
            const today = new Date();
            // today.setMonth(today.getMonth());
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            this.currentDate = `${year}-${month}-${day}`;
        },
    },
};
</script>
