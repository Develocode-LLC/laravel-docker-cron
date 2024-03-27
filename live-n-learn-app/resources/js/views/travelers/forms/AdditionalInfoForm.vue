<template>
    <form class="shadow-md rounded m-4 p-4" @submit.prevent="submit">
        <div class="row">
            <h6 class="fs-2 text-center">Traveler Additional Information</h6>
            <div class="col-md-12">
                <div class="form-group d-flex">
                    <label class="fs-6"
                        >Have you hosted with Live N Learn before?<span
                            class="text-danger p-1"
                            >*</span
                        ></label
                    >
                    <div class="mx-auto d-flex justify-content-between">
                        <div class="form-check col-md-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.prior_host"
                                name="prior_host"
                                id="prior_host_true"
                            />
                            <label
                                class="custom-control-label"
                                for="prior_host_true"
                                >Yes</label
                            >
                        </div>
                        <div class="form-check ml-4">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.prior_host"
                                name="prior_host"
                                id="prior_host_false"
                            />
                            <label
                                class="custom-control-label"
                                for="prior_host_false"
                                >No</label
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="formData.prior_host">
            <div class="col-md-6 p-2">
                <div class="form-group">
                    <label class="fs-6" for="year_hosted"
                        >In what year did your family host a student with Live N
                        Learn?</label
                    >
                    <input type="text" id="year_hosted" class="form-control" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="form-group d-flex">
                    <label class="fs-6"
                        >Do you feel comfortable riding a bike?<span
                            class="text-danger p-1"
                            >*</span
                        ></label
                    >
                    <div class="mx-auto d-flex justify-content-between">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.bike_rider"
                                name="bike_rider"
                                id="bike_rider_true"
                            />
                            <label
                                class="custom-control-label"
                                for="bike_rider_true"
                                >Yes</label
                            >
                        </div>
                        <div class="form-check ml-4">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.bike_rider"
                                name="bike_rider"
                                id="bike_rider_false"
                            />
                            <label
                                class="custom-control-label"
                                for="bike_rider_false"
                                >No</label
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="form-group d-flex">
                    <div>
                        <label class="fs-6"
                            >College Credit<span class="text-danger p-1"
                                >*</span
                            ></label
                        >
                        <p class="">
                            Are you interested in receiving more information
                            <br />about how you can earn college credit for
                            participating <br />
                            in this trip?
                        </p>
                    </div>
                    <div class="mx-auto d-flex w-100">
                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.college_credit_info"
                                name="college_credit_info"
                                id="college_credit_info_true"
                            />
                            <label class="" for="college_credit_info_true"
                                >Yes</label
                            >
                        </div>
                        <div class="form-check ml-4">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.college_credit_info"
                                name="college_credit_info"
                                id="college_credit_info_false"
                            />
                            <label
                                class="custom-control-label"
                                for="college_credit_info_false"
                                >No</label
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group d-flex">
                    <div>
                        <label class="fs-6"
                            >Scholarships<span class="text-danger p-1"
                                >*</span
                            ></label
                        >
                        <p class="">
                            Are you interested in receiving more information
                            <br />
                            about how you can earn a scholarship toward your
                            trip?
                        </p>
                    </div>
                    <div class="mx-auto d-flex w-100">
                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.scholarships_info"
                                name="scholarships_info"
                                id="scholarships_info_true"
                            />
                            <label class="" for="scholarships_info_true"
                                >Yes</label
                            >
                        </div>
                        <div class="form-check ml-4">
                            <input
                                class="form-check-input"
                                type="radio"
                                :v-model="formData.scholarships_info"
                                name="scholarships_info"
                                id="scholarships_info_false"
                            />
                            <label
                                class="custom-control-label"
                                for="scholarships_info_false"
                                >No</label
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
            formData: {
                prior_host: true,
                hosted_year: "",
                bike_rider: false,
                college_credit_info: false,
                scholarships_info: false,
            },
        };
    },

    methods: {
        handleGenderIdChange(e) {
            this.traveler_gender_id = e.target.value;
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
