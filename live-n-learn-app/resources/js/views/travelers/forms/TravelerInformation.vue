<template>
  <form class="container-fluid" @submit.prevent="submit">
    <div v-if="this.showError" class="row">
      <div class="col-md-4">
        <p class="text-danger">{{ error.message }}</p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 card mx-auto">
        <h6 class="text-center fs-2">Traveler Contact Information</h6>
        <div class="row">
          <h6>Traveler Personal Information</h6>
          <div class="col-md-4">
            <div class="form-group">
              <label for="first_name">
                First Name
                <i class="text-danger text-sm">*</i>
              </label>
              <input type="text" class="form-control" id="first_name" placeholder="Traveler First Name"
                v-model="formData.first_name" required />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="middle_name"> Middle Name</label>
              <input type="text" class="form-control" id="middle_name" placeholder="Traveler Middle Name"
                v-model="formData.middle_name" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="last_name">
                Last Name<i class="text-danger p-1 info-sm">*</i></label>
              <input type="text" class="form-control" id="last_name" placeholder="Traveler Last Name"
                v-model="formData.last_name" required />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="gender">Gender<i class="text-danger p-2 info-sm">*</i>
              </label>

              <select class="form-control" id="gender" v-model="formData.gender" required>
                <option>Male</option>
                <option>Female</option>
              </select>
              <i class="info-sm"> as it appears on your legal documents </i>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="date_of_birth">Date of Birth<i class="text-danger p-1 info-sm">*</i></label>

              <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                v-model="formData.date_of_birth" min="1930-01-01" max="2099-12-31" />
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="gender_identity">Gender Identity<i class="text-danger p-1 info-sm">*</i></label>

              <select class="form-control" id="gender_identity" v-model="formData.gender_identity" required>
                <option value="">Please choose an option</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="non_binary">Non-binary</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="preferred_pronouns">Preferred Pronouns</label>
              <select id="preferred_pronouns" class="form-control" v-model="formData.preferred_pronouns" required>
                <option value="">Please choose an option</option>
                <option value="she/her/hers">She/Her/Hers</option>
                <option value="he/him/his">He/Him/His</option>
                <option value="they/them/their">They/Them/Their</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>

        </div>
        <div class="row">

        </div>
        <div class="row" v-if="formData.gender_identity === 'other' || formData.preferred_pronouns === 'other'">
          <div class="col-md-4" v-if="formData.gender_identity === 'other'">
            <div class="form-group">
              <label for="traveler_gender_id">Gender Identity Other<i class="text-danger p-1">*</i></label>
              <input type="text" id="traveler_gender_id_other" v-model="formData.gender_identity_other"
                class="form-control" :disabled="formData.gender_identity !== 'other'" />
            </div>
          </div>
          <div :class="formData.gender_identity === 'other' ? 'col-md-4' : 'col-md-4 mx-auto'"
            v-if="formData.preferred_pronouns === 'other'">
            <div class="form-group">
              <label for="preferred_pronouns_other">Preferred Pronouns Other<i
                  class="text-danger p-1 info-sm">*</i></label>
              <input type="text" id="preferred_pronouns_other" v-model="formData.preferred_pronoun_other"
                class="form-control" :disabled="formData.preferred_pronouns !== 'other'" />
            </div>
          </div>
        </div>

        <div class="row">
          <h6>Traveler Contact Information</h6>
          <div class="col-md-4">
            <div class="form-group">
              <label for="email">
                Email
                <i class="text-danger p-1 info-sm">*</i>
              </label>

              <input type="email" id="email" class="form-control" v-model="formData.email" placeholder="example@email.com"
                required />
              <i class="info-sm">
                Please provide only the Traveler email address
              </i>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="email_confirmation">Confirm Email<i class="text-danger p-1 info-sm">*</i></label>

              <input type="email" id="email_confirmation" class="form-control" v-model="formData.email_confirmation"
                placeholder="example@email.com" required ref="email_confirmation" />
            </div>
          </div>
        </div>
        <div class="row"></div>
        <div class="row">
          <div class="col-md-4">
            <label for="phone_number">
              Phone<i class="text-danger p-1 info-sm">*</i>
            </label>

            <input type="tel" class="form-control" id="phone_number" placeholder="555-555-5555"
              v-model="formData.phone_number" required v-maska data-maska="+1 (###) ###-####" />
            <i class="info-sm">Please provide only the Traveler mobile phone number</i>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="t_shirt_size">T-Shirt Size<i class="text-danger p-1 info-sm">*</i>
              </label>
              <select id="t_shirt_size" v-model="formData.t_shirt_size" class="form-control" ref="tShirtInputRef">
                <option value="">Please choose an option</option>
                <option value="xs">XS</option>
                <option value="s">S</option>
                <option value="m">M</option>
                <option value="l">L</option>
                <option value="xl">XL</option>
                <option value="xxl">XXL</option>
                <option value="3xl">3XL</option>
              </select>
              <i class="info-sm">Adult Unisex Sizes</i>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="school_id">School Name<i class="text-danger p-1 info-sm">*</i></label>
              <select v-model="formData.school_id" class="form-control">
                <option v-for="school in schools" :key="school.id" :value="school.id">
                  {{ school.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Grade Level<i class="text-danger p-1">*</i></label>
              <select v-model="formData.grade" class="form-control">
                <option value="">--Please Select and Option--</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              <i class="info-sm">Please provide your grade level for the 2024-2025 school year.</i>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <div class="form-check">

                <input type="checkbox" class="form-check-input" id="host_family_request"
                  v-model="formData.host_family_request">
                <label class="custom-control-label" for="host_family_request">Host Family Request<small
                    class="text-danger p-2">*</small></label>
              </div>
              <i class="info-sm">If your trip includes a homestay, please indicate if you have a
                request for a host family.
              </i>
            </div>
          </div>
        </div>
        <div class="row" v-if="formData.host_family_request">
          <div class="col-4">
            <div class="form-group">
              <input type="text" class="form-control" />
              <i class="info-sm">Enter Host Family Name</i>

            </div>
          </div>
        </div>
        <div class="row">
          <h6>Traveler Address</h6>
          <div class="col-md-4">
            <div class="form-group">
              <label for="address_1">
                Street Address
                <i class="text-danger p-1 info-sm">*</i></label>
              <input id="address_1" type="text" class="form-control" v-model="formData.address_1" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="address_2"> Street Address 2 </label>
              <input id="address_1" type="text" class="form-control" v-model="formData.address_2" />
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="traveler_city">
                City<i class="text-danger p-1">*</i></label>
              <input id="traveler_city" type="text" class="form-control" v-model="formData.city" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="state_province">
                State<small class="text-danger p-2">*</small></label>
              <select id="state_province" class="form-control" v-model="formData.state_province">
                <option value="">--Please Select a State--</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="state_province">
                Country<small class="text-danger p-2">*</small></label>
              <select id="country_code" class="form-control" v-model="formData.country_code">
                <option v-for="country in countries" :key="country.number" :value="country.code">
                  {{ country.name }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="postal_code">
                Zip code<small class="text-danger p-2">*</small></label>
              <input id="postal_code" type="text" class="form-control" v-model="formData.postal_code" />
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <h6>Parent/Guardian 1</h6>
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_first_name">
                Name<i class="text-danger info-sm p-1">*</i>
              </label>
              <input class="form-control" type="text" id="parent_first_name" v-model="formData.parent.first_name" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_last_name">
                Last Name<i class="text-danger info-sm p-1">*</i>
              </label>
              <input class="form-control" type="text" id="parent_last_name" v-model="formData.parent.last_name" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_email">
                Email<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="email" id="parent_email" placeholder="example@email.com"
                v-model="formData.parent.email" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_phone_number">
                Phone<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="tel" id="parent_phone_number" v-maska data-maska="+1 (###) ###-####"
                v-model="formData.parent.phone_number" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_relationship">
                Relationship<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="tel" id="parent_relationship" v-model="formData.parent.relationship" />
            </div>
          </div>
        </div>
        <div class="row p-4">
          <div class="col-6">
            <div class="form-group">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="secondary_parent_guardian"
                  v-model="secondary_parent_guardian">
                <label class="form-control-label" for="customCheckDisabled">Is there another Parent/Guardian?</label>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-2" v-if="secondary_parent_guardian">
          <h6>Parent/Guardian 2</h6>

          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_secondary_first_name"> Name </label>
              <input class="form-control" type="text" id="parent_secondary_first_name"
                v-model="formData.parent_secondary.first_name" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="parent_secondary_last_name"> Last Name </label>
              <input class="form-control" type="text" id="parent_secondary_last_name"
                v-model="formData.parent_secondary.last_name" />
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="parent_secondary_email"> Email </label>
                <input class="form-control" type="email" id="parent_secondary_email" placeholder="example@email.com"
                  v-model="formData.parent_secondary.email" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="parent_phone2"> Phone </label>
                <input class="form-control" type="tel" id="parent_phone2" v-maska data-maska="+1 (###) ###-####"
                  v-model="formData.parent_secondary.phone_number" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="parent_secondary_relationship">
                  Relationship<i class="text-danger p-1 info-sm">*</i>
                </label>
                <input class="form-control" type="tel" id="parent_secondary_relationship"
                  v-model="formData.parent_secondary.relationship" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <h6>Emergency Contact</h6>
          <div class="col-md-4">
            <div class="form-group">
              <label for="emergency_contact_name">
                First Name<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="text" id="emergency_contact_name"
                v-model="formData.emergency_contact.first_name" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="emergency_last_name">
                Last Name<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="text" id="emergency_last_name"
                v-model="formData.emergency_contact.last_name" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="emergency_contact_phone">
                Phone<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="text" id="emergency_contact_phone" v-maska data-maska="+1 (###) ###-####"
                v-model="formData.emergency_contact.phone_number" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="emergency_contact_relationship">
                Relationship to Traveler<i class="text-danger p-1 info-sm">*</i>
              </label>
              <input class="form-control" type="text" id="emergency_contact_relationship"
                v-model="formData.emergency_contact.relationship" />
            </div>
          </div>
        </div>

        <div class="row">
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
  directives: { maska: vMaska },
  setup() {

    let schools = reactive([]);
    let getSchoolsApi = store.state.apiUrl + "school";

    //refs
    const tShirtInputRef = ref();

    axios
      .get(getSchoolsApi, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.token,
        },
      })
      .then((r) => {
        const results = r;

        results.data.schools.forEach((school) => {
          schools.push(school);
        });
      });

    return {
      schools,
    };
  },
  data() {
    // validation refs

    return {
      secondary_parent_guardian: false,
      latest_trip: null,
      show_host_family_option: false,
      formData: {
        class: "traveler",
        first_name: "",
        middle_name: "",
        last_name: "",
        email: "",
        email_confirmation: "",
        date_of_birth: "",
        phone_number: null,
        gender: "",
        gender_identity: "",
        gender_identity_other: "",
        preferred_pronouns: "",
        preferred_pronoun_other: "",
        school_id: null,
        grade: 7,
        host_family_request: false,
        host_family_name: "",
        address_1: "",
        address_2: "",
        city: "",
        state_province: "",
        postal_code: "",
        country_code: "United States of America",
        t_shirt_size: "",

        parent: {
          first_name: "",
          last_name: "",
          phone_number: "",
          email: "",
          contact_type: "parent_guardian",
          relationship: "",
        },
        parent_secondary: {
          first_name: "",
          last_name: "",
          phone_number: "",
          email: "",
          contact_type: "parent_guardian",
          relationship: "",
        },
        emergency_contact: {
          first_name: "",
          last_name: "",
          phone_number: "",
          email: "",
          contact_type: "emergency",
          relationship: "",
        },
      },
      showError: false,
      error: {
        message: "",
      },
      countries: countries,
      userData: null,
    };
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
          var user = result.user;
          // this.formData = {
          console.log(user);
          this.formData.class = user.class;
          this.formData.first_name = user.first_name ?? "";
          this.formData.middle_name = user.middle_name ?? "";
          this.formData.last_name = user.last_name ?? "";
          this.formData.email = user.email ?? "";
          this.formData.email_confirmation = "";
          this.formData.date_of_birth = user.date_of_birth ?? "";
          this.formData.phone_number = user.phone_number ?? "";
          this.formData.gender = user.gender ?? "";
          this.formData.gender_identity = user.gender_identity ?? "";
          this.formData.gender_identity_other = user.gender_identity_other ?? "";
          this.formData.preferred_pronouns = user.preferred_pronouns ?? "";
          this.formData.preferred_pronoun_other = user.preferred_pronoun_other ?? "";
          this.formData.school_id = user.school_id ?? "";
          this.formData.grade = user.grade ?? "";
          this.formData.host_family_request = user.host_family_request ?? false;
          this.formData.address_1 = user.address_1 ?? "";
          this.formData.address_2 = user.address_2 ?? "";
          this.formData.city = user.city ?? "";
          this.formData.state_province = user.state_province ?? "";
          this.formData.postal_code = user.postal_code ?? "";
          this.formData.country_code = user.country_code ?? "US";
          this.formData.t_shirt_size = user.t_shirt_size ? user.t_shirt_size.toLowerCase() : "";
          this.latest_trip = user.trips[0] ?? null;

          // this.formData.parent.first_name = "";
          // this.formData.parent.last_name = "";
          // this.formData.parent.phone_number = "";
          // this.formData.parent.email = "";
          // this.formData.parent.contact_type = "parent_guardian";
          // this.formData.parent.relationship = "";



        })
        .catch((e) => {
          this.showError = true;

          this.error.message = e
        });
    },
    async getGuardianData() {

      var user = JSON.parse(localStorage.getItem("user"));
      var newApiUrl = this.$store.state.apiUrl + "user_with_parent/" + user.id;
      axios.get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.token,
        },
      }).then(res => {


        //grab the user
        let userData = res.data.user;
        // grab the contact array
        let contactArray = userData.contacts;
        console.log(contactArray[0]?.first_name)

        // first guardian
        this.formData.parent.first_name = contactArray[0]?.first_name;
        this.formData.parent.last_name = contactArray[0]?.last_name;


        this.formData.parent.phone_number = contactArray[0]?.phone_number;
        this.formData.parent.email = contactArray[0]?.email;
        this.formData.parent.contact_type = "parent_guardian";
        this.formData.parent.relationship = contactArray[0]?.relationship;



        // todo  Need to check for secondary parent_guardian
        console.log(contactArray, "contacts")
        // secondary guardian is optional. checking against null
        if (contactArray.length === 3) {
          this.secondary_parent_guardian = true;
          this.formData.parent_secondary.first_name = contactArray[1].first_name;
          this.formData.parent_secondary.last_name = contactArray[1].last_name;

          this.formData.parent_secondary.phone_number = contactArray[1].phone_number;
          this.formData.parent_secondary.email = contactArray[1].email;
          this.formData.parent_secondary.contact_type = "parent_guardian";
          this.formData.parent_secondary.relationship = contactArray[1].relationship;

          //set proper emergency 
          this.formData.emergency_contact.first_name = contactArray[2].first_name;
          this.formData.emergency_contact.last_name = contactArray[2].last_name;

          this.formData.emergency_contact.email = contactArray[2].email ?? "";
          this.formData.emergency_contact.contact_type = "emergency";
          this.formData.emergency_contact.relationship = contactArray[2].relationship;
          this.formData.emergency_contact.phone_number = contactArray[2].phone_number;

        } else {

          // emergency contact is in index 1 since there is only 2 in the array
          this.formData.emergency_contact.first_name = contactArray[1]?.first_name;
          this.formData.emergency_contact.last_name = contactArray[1]?.last_name;

          this.formData.emergency_contact.email = contactArray[1]?.email ?? "";
          this.formData.emergency_contact.contact_type = "emergency";
          this.formData.emergency_contact.relationship = contactArray[1]?.relationship;
          this.formData.emergency_contact.phone_number = contactArray[1]?.phone_number;
        }




      }).catch(err => {
        console.error(err);
      })
    },
    submit() {

      const user = JSON.parse(localStorage.getItem("user"));
      var newApiUrl = this.$store.state.apiUrl + "user/" + user.id;

      // todo add validation  logic.
      let contactList = [
        this.formData.parent,
        this.formData.parent_secondary,
        this.formData.emergency_contact,
      ];


      console.log(contactList, "contact list")

      if (!this.secondary_parent_guardian) {

        contactList.splice(1, 1);

      }

      axios
        .put(
          newApiUrl,
          {
            class: this.formData.class,
            first_name: this.formData.first_name,
            middle_name: this.formData.middle_name,
            last_name: this.formData.last_name,
            email: this.formData.email,
            email_confirmation: this.formData.email_confirmation,
            date_of_birth: this.formData.date_of_birth, // Must be formatted as YYYY-MM-DD
            phone_number: this.formData.phone_number,
            t_shirt_size: this.formData.t_shirt_size,
            gender: this.formData.gender,
            gender_identity: this.formData.gender_identity,
            address_1: this.formData.address_1, // Can be left null if not provided
            address_2: this.formData.address_2, // Can be left null if not provided
            city: this.formData.city, // Can be left null if not provided
            state_province: this.formData.state_province, // Can be left null if not provided
            postal_code: this.formData.postal_code, // Can be left null if not provided
            country_code: this.formData.country_code, // Can be left null if not provided
            preferred_pronouns: this.formData.preferred_pronouns, // Can be left null if not provided
            preferred_pronouns_other: this.formData.preferred_pronoun_other,
            school_id: this.formData.school_id, // Must be a valid school from the DB
            grade: this.formData.grade, // Can be grades 7 through 12
            host_family_request: this.formData.host_family_request,
            metadata: [],
            contacts: contactList,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.token,
            },
          }
        )
        .then((result) => {

          if (result) {

            toast.success("Profile updated Successfully!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });


          }

        })
        .catch((error) => {
          // todo grab specific error to display to user.
          console.error(error);
          toast.error("Unable to update Profile" + this.error.message, { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

        });
    },

  },
  beforeMount() {
    this.getUserData()
    this.getGuardianData();
  },
  watch: {
    t_shirt_size: (newSize, oldSize) => {
      const tshirtTarget = this.$refs.tShirtInputRef;
      console.log(tshirtTarget)
    }
  }
};
</script>
<style>
.info {
  font-size: 0.75rem;
}

.info-sm {
  font-size: 0.80rem;
  margin: 0;
  padding: 0;
  white-space: pre;
}

.ml-4 {
  margin-left: 4rem;
}
</style>
