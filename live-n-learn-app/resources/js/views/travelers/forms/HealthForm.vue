<template>
    <form class="shadow-md rounded m-4 p-4" @submit.prevent="submit">
        <h6 class="text-center fs-2">Health and Medical Information</h6>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="traveler_health">
                        Please list any allergies, dietary restrictions,
                        disabilities, medications, and/or health conditions.
                        Seperate each with a , Failure to provide complete and
                        accurate information could result in expulsion from the
                        program.<small class="text-danger p-2">*</small></label
                    >
                    <textarea
                        id="traveler_health"
                        class="form-control"
                        v-model="formData.medical_info"
                        placeholder="eggs, fish, peanuts, etc"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="traveler_dietary_pref"
                        >Dietary Preferences
                        <small class="text-danger p-2">*</small>
                        <span class="info text-muted"
                            >Please include here if there are any foods you will
                            not or cannot eat. Please let us know in detail your
                            food preferences keeping in mind what you indicate
                            here will affect the menu choices during your
                            trip.</span
                        ></label
                    >
                    <textarea
                        id="traveler_dietary_pref"
                        class="form-control"
                        v-model="formData.dietary_pref"
                        placeholder="pork, fish, beef, etc"
                    ></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="traveler_diet"
                        >Do you follow any of the diets below?
                        <small class="text-danger p-2">*</small>
                    </label>
                    <select
                        id="traveler_diet"
                        class="form-control"
                        v-model="formData.traveler_diet"
                    >
                        <option value="">--Please Select a Diet--</option>
                        <option value="none">None</option>

                        <option value="vegetarian">Vegetarian</option>
                        <option value="pescatarian">Pescatarian</option>

                        <option value="vegan">Vegan</option>

                        <option value="gluten_free">Gluten Free</option>

                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="traveler_seafood"
                        >Do you eat seafood?
                        <small class="text-danger p-2">*</small>
                        <span class="info"
                            >Seafood can be a staple of diets in many countries
                            outside of the US. Please indicate below if you eat
                            seafood</span
                        >
                    </label>
                    <select
                        id="traveler_seafood"
                        class="form-control"
                        v-model="formData.eat_seafood"
                    >
                        <option value="">--Please Select a Preference--</option>
                        <option value="yes">Yes</option>

                        <option value="no">No</option>
                        <option value="some">
                            I eat some, but not all seafood
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label for="traveler_seafood"
                    >If yes, Please give detailed information on which seafood
                    you will and will not eat.
                </label>
                <textarea
                    :disabled="formData.eat_seafood === 'no'"
                    :required="
                        formData.eat_seafood === 'yes' ||
                        formData.eat_seafood === 'some'
                    "
                    class="form-control"
                    v-model="formData.seafood_details"
                ></textarea>
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
                medical_info: "",
                dietary_pref: "",
                traveler_diet: "",
                eat_seafood: "",
                seafood_details: "",
            },
        };
    },
    methods: {
        submit() {
            console.log("validation required");
            console.log("data", this.formData);
        },
    },
};
</script>
