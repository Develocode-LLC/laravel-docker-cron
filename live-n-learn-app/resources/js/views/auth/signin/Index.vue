<template>
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="mt-8 card card-plain">
                <div class="pb-0 card-header text-start">
                  <div class="row">
                    <img src="../../../assets/img/logo-ct.png" alt="Logo" />
                  </div>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" class="text-start" @submit.prevent="submit">
                    <div v-if="showError" class="invalid-feedback2">
                      {{ error.message }}
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" id="email" placeholder="Email" v-model="formdata.email"
                        required />

                      <div class="invalid-feedback">Email is required</div>
                    </div>
                    <div class="form-group mb-1">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" placeholder="Password" required
                        v-model="formdata.password" />

                      <div class="invalid-feedback">Password is required</div>
                    </div>
                    <div class="text-sm text-left my-3">
                      <span @click="this.$router.push('/forgot-password')">Forgot Password?</span>
                    </div>
                    <vsud-switch id="rememberMe" checked>Remember me</vsud-switch>

                    <div class="text-center">
                      <button type="submit" @click.prevent="goToDashBoard()" class="btn bg-gradient-success">
                        Sign In
                      </button>
                    </div>
                    <div id="or" class="text-center mx-auto">OR</div>
                    <div class="text-center">
                      <p class="text-small">No Account?</p>
                      <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal"
                        data-bs-target="#import">
                        Sign Up Here
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8">
                <div class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" :style="{
                  backgroundImage: `url(${bgImg})`,
                }"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div id="import" class="modal fade" tabindex="-1" aria-hidden="true">
      <!-- <form role="form" class="text-start" @submit.prevent="submit"> -->
      <stepper-modal :steps="steps" :canContinue="canContinue" :checkAfterEachStep="true" :isLoading="isLoading"
        @update:canContinue="canContinue">
        <template v-slot:slot>
          <div class="form-group">
            <label for="tripId"> Trip ID </label>
            <input type="text" class="form-control" id="tripId" placeholder="Trip ID" name="tripId" v-model="tripId"
              @change="checkTripID()" required />
            <p class="text-xs text-danger" v-if="showModalError">Invalid Trip ID.</p>
          </div>
        </template>
        <template v-slot:slota>
          <div class="form-group">
            <div class="row">
              <div class="col-12 col-lg-6">
                <label for="traveler_first_name"> Traveler First Name </label>
                <input type="text" class="form-control" id="traveler_first_name" placeholder="First Name"
                  v-model="traveler_first_name" required />
              </div>
              <div class="col-12 col-lg-6">
                <label for="traveler_last_name"> Traveler Last Name </label>
                <input type="text" class="form-control" id="traveler_last_name" placeholder="Last Name"
                  v-model="traveler_last_name" required />
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-12 col-lg-8">
                <label for="traveler_email"> Traveler Email </label>
                <input type="email" class="form-control" id="traveler_email" placeholder="user@example.com"
                  @change="checkEmailConfirmation('traveler')" v-model="traveler_email" maxlength="64" required />
              </div>
              <div class="col-12 col-lg-4">
                <label for="traveler_phone"> Traveler Phone </label>
                <input type="tel" class="form-control" id="traveler_phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                  placeholder="555-555-5555" v-model="traveler_phone" v-maska data-maska="+1 (###) ###-####" required />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-lg-8">
                <label for="traveler_email_conf"> Email Confirmation</label>
                <input type="email" class="form-control" id="traveler_email_conf" placeholder="user@example.com"
                  v-model="traveler_email_conf" maxlength="64" autocomplete="off"
                  @change="checkEmailConfirmation('traveler')" required />
                <p class="text-xs text-danger" v-if="emailIsValid === false">Email confirmation does not match.</p>
              </div>
            </div>
          </div>
        </template>
        <template v-slot:slotb>
          <div class="form-group">
            <div class="row">
              <div class="col-12 col-lg-6">
                <label for="fname"> Guardian First Name </label>
                <input type="text" class="form-control" id="fname" placeholder="First Name" v-model="guardian_first_name"
                  required />
              </div>
              <div class="col-12 col-lg-6">
                <label for="lname"> Guardian Last Name </label>
                <input type="text" class="form-control" id="lname" placeholder="Last Name" v-model="guardian_last_name"
                  required />
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-12 col-lg-8">
                <label for="email"> Guardian Email </label>
                <input type="email" class="form-control" id="email" placeholder="user@example.com"
                  v-model="guardian_email" maxlength="64" @change="checkEmailConfirmation('guardian')" required />
                <p class="text-sm text-danger" v-if="emailIsValid === false">Email confirmation does not match.</p>
              </div>
              <div class="col-12 col-lg-4">
                <label for="phone"> Guardian Phone </label>
                <input type="tel" class="form-control" id="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                  placeholder="555-555-5555" v-model="guardian_phone" v-maska data-maska="+1 (###) ###-####" required />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-lg-8">
                <label for="email"> Email Confirmation</label>
                <input type="email" class="form-control" id="email" placeholder="user@example.com"
                  v-model="guardian_email_conf" maxlength="64" autocomplete="false"
                  @change="checkEmailConfirmation('guardian')" required />
              </div>
            </div>
          </div>
        </template>
        <template v-slot:finish>
          <div class="row" v-if="!successfulRegistration">
            <div class="col-12 col-lg-6 mx-auto text-center">
              <button type="button" class="btn btn-lg btn-success" v-if="isLoading">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="isLoading"> </span>
              </button>
              <button v-else type="button" :class="traveler_email === guardian_email ||
                traveler_email_conf === guardian_email_conf
                ? 'disabled'
                : ''
                " class="btn btn-lg btn-success" @click="registerForProgram()">
                Finish Registration
              </button>
              <p v-if="traveler_email === guardian_email ||
                traveler_email_conf === guardian_email_conf
                " class="text-danger text-sm">
                The traveler and guardian email should not match
              </p>
            </div>
          </div>
          <div class="row" v-else>
            <div class="col-12 col-lg-6 mx-auto text-center">
              <button type="button" class="btn btn-lg btn-success" @click="$router.go()">
                Return to login
              </button>
            </div>
          </div>
        </template>
      </stepper-modal>
      <!-- </form> -->
    </div>
  </main>
</template>

<script>
import _ from "lodash";
import bgImg from "@/assets/img/curved-images/curved9.jpg";
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import VsudInput from "@/components/VsudInput.vue";
import VsudSwitch from "@/components/VsudSwitch.vue";
import VsudButton from "@/components/VsudButton.vue";
import stepperModal from "@/components/Shared/stepperModal.vue";
import { vMaska } from "maska";
import bootstrap from 'bootstrap/dist/js/bootstrap'

import axios from "axios";
import { mapGetters, mapMutations, mapActions } from "vuex";
const body = document.getElementsByTagName("body")[0];

export default {
  directives: { maska: vMaska },
  name: "SigninCover",
  components: {
    Navbar,
    AppFooter,
    VsudInput,
    VsudSwitch,
    VsudButton,
    stepperModal,
  },
  methods: {
    ...mapActions(["setUser"]),
    goToDashBoard() {
      var newApiUrl = this.$store.state.apiUrl + "login";
      axios
        .post(
          newApiUrl,
          {
            email: this.formdata.email,
            password: this.formdata.password,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        )
        .then((r) => {
          const result = r.data;

          console.log(result.user);

          let user = {
            accessToken: result.token,
            userData: {
              role: result.user.class,
              fullName: result.user.first_name + " " + result.user.last_name,
              email: result.user.email,
              id: result.user.id,
              username: result.user.email,
            },
          };

          localStorage.setItem("token", user.accessToken);
          localStorage.setItem("user", JSON.stringify(user.userData));
          this.$store.dispatch("setUser", result.user);

          this.$router.push({
            path: "/dashboards/dashboard-default",
            replace: true,
          });
        })
        .catch((e) => {
          this.showError = true;

          this.error.message = e;
        });
    },
    async checkTripID() {
      this.canContinue = false;
      this.showModalError = false;


      var tripIdInput = document.querySelector('input[name="tripId"]');
      if (tripIdInput.classList.contains("is-valid")) {
        tripIdInput.classList.remove("is-valid");
        tripIdInput.classList.add("is-invalid");
      }

      var newApiUrl = `${this.$store.state.apiUrl}trip/${this.tripId}/lookup`;
      // console.log(newApiUrl);
      this.isLoading = true;

      await axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        })
        .then((result) => {
          // console.log(result.data.trip);
          this.tripTitle = result.data.trip.title;
          tripIdInput.classList.remove("is-invalid");
          tripIdInput.classList.add("is-valid");
          this.canContinue = true;
          this.isLoading = false;

          //   this.$router.push({
          //     path: "/dashboards/dashboard-default",
          //     replace: true,
          //   });
        })
        .catch((e) => {

          tripIdInput.classList.remove("is-valid");
          tripIdInput.classList.add("is-invalid");
          this.canContinue = false;
          this.showModalError = true;
          this.isLoading = false;


          this.error.message = e.response.data.message;
        });
    },
    HasContinued() {
      this.canContinue = false;
    },

    checkEmailConfirmation(type) {
      // debugger
      // Regular expression for validating email format
      this.isLoading = true;

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      let email,
        confirmationEmail = "";


      if (type == "traveler") {
        email = this.traveler_email;
        confirmationEmail = this.traveler_email_conf;
      }


      if (type == "guardian") {
        email = this.guardian_email;
        confirmationEmail = this.guardian_email_conf;
      }


      if (
        email === confirmationEmail
      ) {
        this.emailIsValid = true;
        this.canContinue = true;
        this.isLoading = false;
        console.log('success')
        // Enable the next button or perform other actions
      } else {
        this.emailIsValid = false;
        this.canContinue = false;
        this.isloading = false;
        console.log('fail')
        // Disable the next button or perform other actions
      }
      //   }, 300);
    },
    registerForProgram() {
      //-----------------
      // Trip Registration
      // -----------------
      // POST /api/v1/trip_registration/{trip:code}

      this.isLoading = true;
      var newApiUrl =
        this.$store.state.apiUrl + "trip_registration/" + this.tripId;
      axios
        .post(
          newApiUrl,
          {
            traveler: {
              first_name: this.traveler_first_name,
              last_name: this.traveler_last_name,
              email: this.traveler_email,
              email_confirmation: this.traveler_email_conf,
              phone_number: this.traveler_phone,
            },
            parent_guardian: {
              first_name: this.guardian_first_name,
              last_name: this.guardian_last_name,
              email: this.guardian_email,
              email_confirmation: this.guardian_email_conf,
              phone_number: this.guardian_phone,
            },
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        )
        .then((r) => {
          const result = r.data;
          if (result) {
            this.isLoading = false;
            this.successfulRegistration = true;
            // console.log(this.steps[this.steps.length - 1]);
            this.steps[this.steps.length - 1].headline = "Success!";
            this.steps[this.steps.length - 1].description = `${this.traveler_first_name} has successfully registered for ${this.tripTitle} trip!`
          }
          // this.$router.push({
          //   path: "/",
          // });
        })
        .catch((e) => {
          this.showError = true;

          this.error.message = e.response.data.message;
          // this.successfulRegistration = true;
          // this.steps[this.steps.length - 1].headline = "Success!";
          // this.steps[this.steps.length - 1].description = `${this.traveler_first_name} has successfully registered for ${this.tripTitle}`;
        });
    },
    showImportModal() {
      const modal = new bootstrap.Modal(document.getElementById('import'));
      modal.show();
    },
  },
  data() {
    return {
      bgImg,
      showError: false,
      showModalError: false,
      error: {
        message: "",
      },
      tripId: "",
      tripTitle: "",
      formdata: {
        email: "",
        password: "",
      },
      traveler_first_name: "",
      traveler_last_name: "",
      traveler_phone: "",
      traveler_email: "",
      traveler_email_conf: "",
      guardian_first_name: "",
      guardian_last_name: "",
      guardian_phone: "",
      guardian_email: "",
      guardian_email_conf: "",
      steps: [
        {
          id: 0,
          name: "Trip ID",
          headline: "Lets start by getting your Trip ID",
          description:
            "The Trip ID is a unique code provided to you by your Group Leader. Not sure of your Trip ID? Contact your Group Leader.",
        },
        {
          id: 1,
          name: "Traveler Details",
          headline: "Please provide information about the traveler.",
          description: "",
        },
        {
          id: 2,
          name: "Guardian Details",
          headline:
            "Next, Lets get some information about the traveler guardian",
          description: "",
        },
        {
          id: 3,
          name: "Finish",
          headline: "Finish Registration",
          description:
            `Thank you for signing up! Once you hit this button, check your email for a confirmation link to complete your registration. If you don’t see the email, please contact info@livenlearn.com.`,
        },
      ],
      tripId: "",
      canContinue: false,
      emailIsValid: null,
      isLoading: false,
      successfulRegistration: false,
    };
  },

  beforeMount() {
    // console.log(this.$route)

    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  mounted() {
    if (this.$route.query.register == 'true') {
      this.showImportModal()
      // console.log(modal[0].)
    }
  },
  beforeUnmount() {

    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
  },
};
</script>
<style scoped>
#or {
  position: relative;
  width: 300px;
  height: 50px;

  line-height: 50px;
  text-align: center;
}

#or::before,
#or::after {
  position: absolute;
  width: 130px;
  height: 1px;

  top: 24px;

  background-color: #aaa;

  content: "";
}

#or::before {
  left: 0;
}

#or::after {
  right: 0;
}

.invalid-feedback2 {
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875em;
  color: #dc3545;
}
</style>