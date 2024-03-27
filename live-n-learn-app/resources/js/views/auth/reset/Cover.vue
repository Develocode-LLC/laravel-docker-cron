<template>
  <main class="mt-0 main-content main-content-bg">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div
              class="px-5 col-xl-5 col-lg-6 col-md-8 col-12 d-flex flex-column"
            >
              <div class="mt-8 card card-plain">
                <div class="pb-0 text-left card-header">
                  <h3 class="text-info text-gradient">Reset Password</h3>
                  <p class="mb-0">
                    You will receive an e-mail in maximum 60 seconds
                  </p>
                </div>
                <div class="pb-3 card-body">
                  <form role="form">
                    <div class="mb-3">
                      <div class="form-group">
                        <label for="password">New Password</label>
                        <input
                          type="password"
                          class="form-control"
                          id="password"
                          placeholder="Password"
                          required
                          v-model="formdata.password"
                        />
                        <label for="password">Confirm Password</label>
                        <input
                          type="password"
                          class="form-control"
                          id="password"
                          placeholder="Password"
                          required
                          v-model="formdata.password"
                        />

                        <div class="invalid-feedback">Password is required</div>
                      </div>
                    </div>
                    <div class="text-center">
                      <vsud-button
                        class="mt-4"
                        variant="gradient"
                        color="info"
                        full-width
                        >Reset</vsud-button
                      >
                    </div>
                  </form>
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
import bgImg from "@/assets/img/curved-images/curved6.jpg";
import Navbar from "@/examples/PageLayout/Navbar.vue";
import AppFooter from "@/examples/PageLayout/Footer.vue";
import VsudInput from "@/components/VsudInput.vue";
import VsudButton from "@/components/VsudButton.vue";
const body = document.getElementsByTagName("body")[0];

export default {
  name: "ResetCover",
  components: {
    Navbar,
    AppFooter,
    VsudInput,
    VsudButton,
  },
  data() {
    return {
      bgImg,
      formdata: {
        password: "",
        passwordConfirmation: "",
      },
    };
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
