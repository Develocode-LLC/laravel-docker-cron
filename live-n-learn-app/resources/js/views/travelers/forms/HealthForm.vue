<template>
    <form class="container-fluid" @submit.prevent="submit">

        <div class="row">
            <div class="col-md-12 card mx-auto">
                <h6 class="text-center fs-2">Health and Medical Information</h6>
                <p class="lead w-50 block mx-auto text-sm"> Please provide Live N Learn with detailed health and medical
                    information of
                    the
                    traveler. If there are any updates between now and the date of departure, please make sure to update
                    this information.</p>
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Does the traveler require any special
                                accommodations while traveling?
                                (wheelchair, interpreter, etc.)?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="special_accommodations"
                                    id="special_accommodations_yes" v-model="formData.has_special_accommodations"
                                    :value="1">
                                <label class="custom-control-label" for="special_accommodations_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="special_accommodations"
                                    id="special_accommodations_no" v-model="formData.has_special_accommodations"
                                    :value="0">
                                <label class="custom-control-label" for="special_accommodations_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="formData.has_special_accommodations">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <i class="text-sm text-muted">
                                Please detail any special accommodations the traveler will require during the trip.
                            </i>
                            <textarea class="form-control" id="traveler_diet_other" rows="2"
                                v-model="formData.special_accommodations_details"></textarea>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Does the traveler suffer from any pre-existing
                                medical conditions (seizures, diabetes, mental health issues, eating disorders,
                                etc.)?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="pre_existing_medical_condition"
                                    id="pre_existing_medical_condition_yes"
                                    v-model="formData.has_preexisting_conditions" :value="1">
                                <label class="custom-control-label" for="pre_existing_medical_condition_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pre_existing_medical_condition"
                                    id="pre_existing_medical_condition_no" v-model="formData.has_preexisting_conditions"
                                    :value="0">
                                <label class="custom-control-label" for="pre_existing_medical_condition_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="formData.has_preexisting_conditions">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <i class="text-sm text-muted">
                                Please detail any pre-existing medical conditions.
                            </i>
                            <textarea class="form-control" id="pre_existing_medical_condition_details" rows="2"
                                v-model="formData.preexisting_conditions_details"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="formData.has_preexisting_conditions">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <i class="text-sm text-muted">
                                What are the warning signs the Group Leader should be aware of and what should be done
                                in the event of an emergency related to this condition?
                            </i>
                            <textarea class="form-control" id="pre_existing_medical_condition_warnings" rows="2"
                                v-model="formData.preexisting_conditions_warning_sign"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Is the traveler allergic to any medication, food,
                                etc?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="has_allergens" id="has_allergens_yes"
                                    v-model="formData.has_allergies" :value="1">
                                <label class="custom-control-label" for="has_allergens_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_allergens" id="has_allergens_no"
                                    v-model="formData.has_allergies" :value="0">
                                <label class="custom-control-label" for="has_allergens_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="formData.has_allergies">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <div class="row">
                                <i class=" text-xs text-muted">
                                    Please list any allergies, dietary restrictions,
                                    disabilities, medications, and/or health conditions.
                                    Seperate each with a <mark>,</mark> Failure to provide complete and
                                    accurate information could result in expulsion from the
                                    program.</i>
                            </div>

                            <textarea id="allergen_details" class="form-control"
                                v-model="formData.allergies_details"></textarea>
                        </div>
                    </div>

                </div>
                <div class="row" v-if="formData.has_allergies">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <div class="row">
                                <i class=" text-xs text-muted">
                                    What should be done in the case of a reaction? (EpiPen, etc.) </i>
                            </div>

                            <textarea id="allergen_reaction_details" class="form-control"
                                v-model="formData.allergic_reaction_details"></textarea>


                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Besides food related allergies, does the traveler
                                have any dietary restrictions or preferences?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="dietary_restrictions"
                                    id="dietary_restrictions_yes" v-model="formData.has_dietary_restrictions"
                                    :value="1">
                                <label class="custom-control-label" for="dietary_restrictions_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dietary_restrictions"
                                    id="dietary_restrictions_no" v-model="formData.has_dietary_restrictions" :value="0">
                                <label class="custom-control-label" for="dietary_restrictions_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mx-auto" v-if="formData.has_dietary_restrictions">
                    <div class="form-group">
                        <i class="text-sm text-muted">
                            Please detail and include if there are any foods you will not or cannot eat. What you
                            indicate here will affect the menu choices during your trip.</i>
                        <textarea id="traveler_dietary_pref" class="form-control"
                            v-model="formData.dietary_restriction_details"></textarea>


                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="traveler_diet" class="form-control-label ">Do you follow any of the diets
                                below?</label>
                            <select multiple id="traveler_diet" class="form-control" v-model="formData.user_diet">
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
                    <div class="col-6 mx-auto" v-if="formData.user_diet.includes('other')">
                        <div class="form-group ">
                            <i class="info text-muted ">If Other, Please include here if there are any foods you will
                                not or cannot eat.
                            </i>
                            <textarea class="form-control" id="traveler_diet_other" rows="2"></textarea>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Does the traveler take any prescription
                                medications?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="has_prescription_medication"
                                    id="has_prescription_medication_yes" v-model="formData.has_prescription_medications"
                                    :value="1">
                                <label class="custom-control-label" for="has_prescription_medication_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_prescription_medication"
                                    id="has_prescription_medication_no" v-model="formData.has_prescription_medications"
                                    :value="0">
                                <label class="custom-control-label" for="has_prescription_medication_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mx-auto" v-if="formData.has_prescription_medications">
                    <div class="form-group">
                        <i class="text-sm text-muted">
                            Please list any prescriptions medications your student is currently taking</i>
                        <textarea id="traveler_dietary_pref" class="form-control"
                            v-model="formData.prescription_medications_details"></textarea>


                    </div>
                </div>


                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Does the traveler take any over the counter
                                medications?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="has_over_counter_medication"
                                    id="has_over_counter_medication_yes" v-model="formData.has_otc_medications"
                                    :value="1">
                                <label class="form-control-label" for="has_over_counter_medication_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_over_counter_medication"
                                    id="has_over_counter_medication_no" v-model="formData.has_otc_medications"
                                    :value="0">
                                <label class="form-control-label" for="has_over_counter_medication_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mx-auto" v-if="formData.has_otc_medications">
                    <div class="form-group">
                        <i class="text-sm text-muted">
                            Please list any prescriptions medications your student is currently taking.</i>
                        <textarea id="has_over_counter_medication_details" class="form-control"
                            v-model="formData.otc_medications_details"></textarea>


                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="form-group">
                            <label for="" class="form-control-label">Is there any other information regarding the health
                                or medical history of the travel that should be conveyed to your Group Leader Prior to
                                the trip?</label>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="other_health_information"
                                    id="other_health_information_yes" v-model="formData.has_additional_information"
                                    :value="1">
                                <label class="form-control-label" for="other_health_information_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="other_health_information"
                                    id="other_health_information_no" v-model="formData.has_additional_information"
                                    :value="0">
                                <label class="form-control-label" for="other_health_information_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mx-auto" v-if="formData.has_additional_information">
                    <div class="form-group">
                        <i class="text-sm text-muted">
                            Please list here:</i>
                        <textarea id="other_health_information_details" class="form-control"
                            v-model="formData.additional_information_details"></textarea>


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
            </div>
        </div>




    </form>
</template>
<script>
import { reactive, ref } from "vue";
import store from "@/store/index.js";
import axios from "axios";
import countries from "../../../utils/countries.js";
import { vMaska } from "maska";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default {
    data() {
        return {
            user_medical_information_id: 0,
            formData: {
                has_special_accommodations: 0,
                special_accommodations_details: "",         // This only required if has_special_accommodations is true
                has_preexisting_conditions: 0,
                preexisting_conditions_details: "",         // This only required if has_preexisting_conditions is true
                preexisting_conditions_warning_sign: "",    // This only required if has_preexisting_conditions is true
                has_allergies: 0,
                allergies_details: "",                      // This only required if has_medicine_allergies is true
                allergic_reaction_details: "",              // This only required if has_medicine_allergies is true
                has_dietary_restrictions: 0,
                dietary_restriction_details: "",            // This only required if has_food_allergies is true
                has_prescription_medications: 0,
                prescription_medications_details: "",       // This only required if has_prescription_medications is true
                has_otc_medications: 0,
                otc_medications_details: "",                // This only required if has_otc_medications is true
                has_additional_information: 0,
                additional_information_details: "",         // This only required if has_additional_information is true
                user_diet: [],
                diet_details: ""                            // This only required if user_diet contains 'other'
            },
            showError: false,
            error: {
                message: "",
            },
        };
    },
    methods: {
        async getUserMedicalInformation() {
            const user = JSON.parse(localStorage.getItem("user"));
            var newApiUrl = `${this.$store.state.apiUrl}user/${user.id}/user_medical_information`;

            await axios
                .get(newApiUrl, {
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: "Bearer " + localStorage.token,
                    },
                })
                .then((result) => {
                    const medical_information = result.data.medical_information;

                    if (medical_information) {
                        console.log(medical_information);

                        this.formData = medical_information;

                        this.user_medical_information_id = medical_information.id;
                    }
                })
                .catch((error) => {
                    this.showError = true;
                    this.error.message = error;
                });
        },
        async submit() {
            console.log("validation required");
            console.log("data", this.formData);
            /**
             * Get User Medical Information: GET /api/v1/user/{user_id}/user_medical_information
             * Add User Medical Information: POST /api/v1/user/{user_id}/user_medical_information
             * Update User Medical Information: PUT /api/v1/user/{user_id}/user_medical_information/{user_medical_information_id}
             */
            const user = JSON.parse(localStorage.getItem("user"));
            var newApiUrl = `${this.$store.state.apiUrl}user/${user.id}/user_medical_information/${this.user_medical_information_id}`;

            axios.put(newApiUrl, { ...this.formData }, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: "Bearer " + localStorage.token,
                }
            }).then(r => {
                //todo handle toast
                //TODO handle redirect, form refresh or something...
                console.log(r)
            }).catch(e => {
                console.error(e);
            })
        },
        handleDietMultiSelect() {
            let hasOther = false;
            this.formData.user_diet.forEach(diet => {
                console.log(diet);

                if (diet === 'other') {
                    console.log(diet);
                    hasOther = true;

                }
            });

            return hasOther;

        }
    },
    beforeMount() {
        this.getUserMedicalInformation()
    },
};
</script>
<style>
.info {
    font-size: .80em;
    margin: 0;
    padding: 0;


}
</style>