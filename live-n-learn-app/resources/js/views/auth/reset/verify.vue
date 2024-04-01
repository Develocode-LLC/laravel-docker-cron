<template>
  <!-- <main class="mt-0 main-content main-content-bg"> -->
  <section>
    <div class="page-header min-vh-75">
      <div class="container">
        <div class="row">
          <div class="px-5 col-xl-5 col-lg-6 col-md-8 col-12 d-flex flex-column" v-if="!passwordSuccess">
            <div class="row">
              <div class="mt-8 card card-plain">
                <div class="pb-0 text-left card-header">
                  <h3 class="text-info text-gradient-success">Set Your Password</h3>
                  <!-- <p class="mb-0">
                  You will receive an e-mail in maximum 60 seconds
                </p> -->
                </div>
                <div class="pb-3 card-body">
                  <!-- <form role="form"> -->
                  <div class="row">
                    <div class="mb-3">
                      <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" required
                          v-model="password" />

                        <label for="password">Confirm Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" required
                          v-model="password_confirmation" />

                        <p class="text-sm text-danger" v-if="passwordError">{{ passwordError }}</p>

                        <div class="invalid-feedback">Password is required</div>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn btn-lg btn-success" @click="handleResetPassword">Reset</button>
                      <!-- <vsud-button class="mt-4" variant="gradient" color="info" full-width
                      @click="handleResetPassword()">Reset</vsud-button> -->
                    </div>
                    <!-- </form> -->
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
          <div class="row" v-if="passwordSuccess">
            <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
              <div class="card card-plain">
                <div class="text-center card-body px-lg-5 py-lg-5">
                  <div class="mb-4 text-center text-muted">
                    <h2>
                      Password has been successfully reset!
                    </h2>
                  </div>
                  <div>
                    <button class="btn btn-sm btn-success col-12" @click="this.$router.push('/')">Return to login</button>
                    <!-- You will now be redirected to login in -->
                    <!-- {{ countDownSeconds.value }}; -->
                  </div>
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
    </div>
  </section>
  <!-- </main> -->
</template>

<script>
import bgImg from "@/assets/img/curved-images/curved6.jpg";
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import VsudInput from "@/components/VsudInput.vue";
import VsudButton from "@/components/VsudButton.vue";
import { ref } from 'vue';
import store from "@/store/index.js";
import axios from "axios";
import { useRoute } from "vue-router";
const body = document.getElementsByTagName("body")[0];

export default {
  name: "ResetCover",
  components: {
    Navbar,
    AppFooter,
    VsudInput,
    VsudButton,
  },
  setup() {
    const route = useRoute();

    const password = ref();
    const password_confirmation = ref();
    const passwordError = ref();
    let passwordSuccess = ref(false);
    let countDownSeconds = ref(7)
    let foo = ref();


    /** 
     * POST /api/v1/reset-password
     * Body: { "token": "token", "email": "test@example.com", "password": "new_password", "password_confirmation": "new_password" } 
     */

    const handleResetPassword = async () => {
      // console.log(route.params)
      // return;

      var vm = this;

      var newApiUrl = store.state.apiUrl + "reset-password";
      await axios
        .post(
          newApiUrl,
          {
            token: route.params.token,
            email: route.query.email,
            password: password.value,
            password_confirmation: password_confirmation.value,
          },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }
        ).then((r) => {
          // debugger;
          console.log(r)
          let data = r.data;
          if (data.message) {
            passwordSuccess.value = true;
            countdownTimer();
          }
        }).catch((e) => {
          console.log(e);
          // e.response.data.errors.foreach
          passwordError.value = e?.response?.data?.message;
          // passwordConfirmationError.value = e.response.data.message;
        });
    }
    const updateSecs = () => {
      countDownSeconds.value--;
      if (countDownSeconds.value == -1) {
        clearInterval(foo);
        this.$router.push("/");
      }
    }
    const countdownTimer = () => {
      const vm = this;
      foo.value = setInterval(function () {
        updateSecs();
      }, 1000);
    }


    return {
      handleResetPassword,
      route,
      password,
      password_confirmation,
      handleResetPassword,
      passwordError,
      passwordSuccess,
      // countdownTimer,
      // updateSecs,
      countDownSeconds,
      foo
    };
  },
  data() {
    return {
      bgImg,
      // countDownSeconds: 7,
      // passwordSuccess: false,
    };
  },
  methods: {

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
  },
};
</script>
