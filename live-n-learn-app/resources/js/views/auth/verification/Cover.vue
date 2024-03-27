<template>
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row" v-if="!resetToken">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="card card-plain">
                <div class="text-center card-body px-lg-5 py-lg-5">
                  <div class="mb-4 text-center text-muted">
                    <h2>Account Verification</h2>
                  </div>
                  <div class="row gx-2 gx-sm-3">
                    <div class="col-12">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control form-control-lg"
                          autocomplete="off"
                          autocapitalize="off"
                          placeholder="Enter Verficiation Code!"
                          v-model="verificationToken"
                        />
                        <span class="text-sm text-danger" v-if="badToken">
                          {{
                            "There was an issue with your token, it might be invalid."
                          }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <vsud-button
                      class="mb-3 bg-gradient-success"
                      color="warning"
                      full-width
                      @click="verify()"
                      >Verify Code</vsud-button
                    >
                    <span class="text-sm text-muted">
                      Haven't received it?
                      <a @click="resendVerification" href="#"
                        >Resend a new code</a
                      >.
                    </span>
                    <span
                      class="text-sm text-info"
                      v-if="resentVerificationToken"
                    >
                      Verification email resent! It could take up to 5 minutes
                      to recieve your new verification token.
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div
                class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
              >
                <div
                  class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                  :style="{
                    backgroundImage: `url(${bgImg})`,
                  }"
                ></div>
              </div>
            </div>
          </div>
          <div class="row" v-if="resetToken && !passwordSuccess">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="card card-plain">
                <div
                  class="text-center card-body px-lg-5 py-lg-5"
                  v-if="!reset_token"
                >
                  <div class="mb-4 text-center text-muted">
                    <h2>Almost done, set your password!</h2>
                  </div>
                  <div class="row gx-2 gx-sm-3">
                    <div class="col-12">
                      <div class="form-group">
                        <input
                          type="password"
                          class="form-control form-control-lg"
                          autocomplete="off"
                          autocapitalize="off"
                          placeholder="Password"
                          v-model="password"
                        />
                        <input
                          type="password"
                          class="form-control form-control-lg mt-2"
                          autocomplete="off"
                          autocapitalize="off"
                          placeholder="Password Confirmation"
                          v-model="passwordConfirmation"
                        />
                      </div>
                      <span class="text-sm text-danger" v-if="passwordError">
                        {{ passwordErrorMessage }}
                      </span>
                    </div>
                  </div>
                  <div class="text-center">
                    <vsud-button
                      class="mb-3 bg-gradient-success"
                      color="warning"
                      full-width
                      @click="setPassword"
                      >Set Password</vsud-button
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div
                class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
              >
                <div
                  class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                  :style="{
                    backgroundImage: `url(${bgImg})`,
                  }"
                ></div>
              </div>
            </div>
          </div>
          <div class="row" v-if="passwordSuccess">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="card card-plain">
                <div class="text-center card-body px-lg-5 py-lg-5">
                  <div class="mb-4 text-center text-muted">
                    <h2>
                      All Done! Thank You for registering with Live N Learn!
                    </h2>
                  </div>
                  <div>
                    You will now be redirected to login in
                    {{ countDownSeconds }};
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div
                class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
              >
                <div
                  class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                  :style="{
                    backgroundImage: `url(${bgImg})`,
                  }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import bgImg from "@/assets/img/curved-images/curved9.jpg";
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import VsudButton from "@/components/VsudButton.vue";
import axios from "axios";
import store from "@/store/index.js";
const body = document.getElementsByTagName("body")[0];

export default {
  name: "VerificationCover",
  components: {
    Navbar,
    VsudButton,
    AppFooter,
  },
  data() {
    return {
      email: this.$route.query.email,
      verificationToken: "",
      resetToken: null,
      resentVerificationToken: false,
      tokenError: null,
      passwordError: null,
      passwordErrorMessage: null,
      badToken: false,
      countDownSeconds: 7,
      passwordSuccess: false,
      foo: null,
      bgImg,
    };
  },
  methods: {
    async resendVerification() {
      var newApiUrl = store.state.apiUrl + "resend_registration";
      await axios
        .post(
          newApiUrl,
          { email: this.email },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        )
        .then((result) => {
          console.log(result);
          this.resentVerificationToken = true;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    async verify() {
      var newApiUrl = store.state.apiUrl + "enter_registration_key";
      await axios
        .post(
          newApiUrl,
          { email: this.email, registration_key: this.verificationToken },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        )
        .then((result) => {
          var data = result.data;
          if (data && data.reset_token) {
            this.resetToken = data.reset_token;
          }
        })
        .catch((error) => {
          console.log(error);
          this.badToken = true;
          this.tokenError = error.response.data.message;
        });
    },
    async setPassword() {
      var newApiUrl = store.state.apiUrl + "reset-password";
      await axios
        .post(
          newApiUrl,
          {
            token: this.resetToken,
            email: this.email,
            password: this.password,
            password_confirmation: this.passwordConfirmation,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        )
        .then((result) => {
          var data = result.data;
          if (data) {
            this.passwordSuccess = true;
            this.countdownTimer();
          }
        })
        .catch((error) => {
          console.log(error);
          this.passwordError = true;
          this.passwordErrorMessage = error.response.data.message;
        });
    },
    updateSecs() {
      this.countDownSeconds--;
      if (this.countDownSeconds == -1) {
        clearInterval(this.foo);
        this.$router.push("/");
      }
    },
    countdownTimer() {
      const vm = this;
      this.foo = setInterval(function () {
        vm.updateSecs();
      }, 1000);
    },
  },

  beforeMount() {
    this.$store.state.hideConfigButton = true;
    this.$store.state.showNavbar = false;
    this.$store.state.showSidenav = false;
    this.$store.state.showFooter = false;
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.$store.state.hideConfigButton = false;
    this.$store.state.showNavbar = true;
    this.$store.state.showSidenav = true;
    this.$store.state.showFooter = true;
    body.classList.add("bg-gray-100");
    clearInterval(this.foo);
  },
};
</script>
