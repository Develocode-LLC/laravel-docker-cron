<template>
  <div class="modal-dialog mt-lg-10">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 id="ModalLabel" class="modal-title">Import CSV</h5>
        <i class="fas fa-upload ms-3"></i>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div> -->
      <div class="modal-body">
        <div class="row">
          <div class="col-12 text-center">
            <h3 class="mt-5">Signup for a program!</h3>
            <h5 class="text-secondary font-weight-normal">
              This information will let us know more about you and assign you to
              the proper program.
            </h5>
            <div class="multisteps-form mb-5">
              <div class="row">
                <div class="col-12 col-lg-12 mx-auto my-5">
                  <div class="multisteps-form__progress">
                    <button
                      v-for="(data, id) in steps"
                      :key="id"
                      :class="[id == 0 ? 'js-active' : '']"
                      class="multisteps-form__progress-btn"
                      type="button"
                      title="User Info"
                    >
                      <span>{{ data.name }}</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-lg-12 m-auto">
                  <form class="multisteps-form__form" style="height: 350px">
                    <div
                      :class="[index == 0 ? 'js-active' : '']"
                      class="multisteps-form__panel p-3 border-radius-xl bg-white"
                      data-animation="FadeIn"
                      v-for="(slot, index) of Object.keys($slots)"
                      :key="index"
                    >
                      <div class="row text-center">
                        <div class="col-12 mx-auto">
                          <h5 class="font-weight-normal">
                            {{ steps[index].headline }}
                          </h5>
                          <p>
                            {{ steps[index].description }}
                          </p>
                        </div>
                      </div>
                      <div class="multisteps-form__content">
                        <div class="row mt-3">
                          <div class="col-12 mt-4 mt-sm-0 text-start">
                            <slot :name="slot"></slot>
                          </div>
                        </div>
                        <div class="button-row d-flex mt-4">
                          <!-- <button
                            class="btn bg-gradient-light mb-0 js-btn-prev"
                            type="button"
                            title="Prev"
                            v-if="index + 1 != 1"
                            @click="handlePrev"
                          >
                            Prev
                          </button> -->
                          <button
                            v-if="index + 1 !== Object.keys($slots).length"
                            :class="[allowNext ? '' : 'disabled']"
                            class="btn bg-gradient-dark ms-auto mb-0 js-btn-next"
                            type="button"
                            title="Next"
                            @click="handleNext"
                          >
                            Next
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "stepperModal",
  props: {
    dismissible: {
      type: Boolean,
      default: false,
    },
    steps: {
      type: Array,
      default: {},
    },
    //Check between each step if it can move on
    canContinue: {
      type: Boolean,
      defualt: true,
    },
    checkAfterEachStep: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      allowNext: false,
    };
  },
  watch: {
    canContinue(value) {
      console.log(value);
      const nextBtn = document.querySelector(
        ".btn.bg-gradient-dark.ms-auto.mb-0.js-btn-next"
      );
      if (!value && this.checkAfterEachStep) {
        nextBtn.classList.contains("disabled")
          ? ""
          : nextBtn.classList.add("disabled");
      } else if (value && this.checkAfterEachStep) {
        nextBtn.classList.contains("disabled")
          ? nextBtn.classList.remove("disabled")
          : "";
        this.allowNext = true;
      } else {
        nextBtn.classList.contains("disabled")
          ? nextBtn.classList.remove("disabled")
          : "";
        this.allowNext = true;
      }
    },
  },
  methods: {
    handleNext() {
      // this.$emit("update:canContinue", false);
      const activeBtn = document.querySelector(
        ".multisteps-form__progress-btn.js-active"
      );
      const activeSlide = document.querySelector(
        "div.multisteps-form__panel.p-3.border-radius-xl.bg-white.js-active"
      );
      if (activeBtn) {
        activeBtn.classList.remove("js-active");
        activeSlide.classList.remove("js-active");
        const nextBtn = activeBtn.nextElementSibling;
        const nextSlide = activeSlide.nextElementSibling;
        if (nextBtn) {
          nextBtn.classList.add("js-active");
          nextSlide.classList.add("js-active");
          // !self.canContinue && this.checkAfterEachStep
          //   ? (self.allowNext = false)
          //   : null;
          if (this.checkAfterEachStep) {
            this.allowNext = false;
          }
        }
      }
    },
    handlePrev() {
      const activeBtn = document.querySelector(
        ".multisteps-form__progress-btn.js-active"
      );
      const activeSlide = document.querySelector(
        "div.multisteps-form__panel.p-3.border-radius-xl.bg-white.js-active"
      );
      if (activeBtn) {
        activeBtn.classList.remove("js-active");
        activeSlide.classList.remove("js-active");
        const nextBtn = activeBtn.previousElementSibling;
        const nextSlide = activeSlide.previousElementSibling;
        if (nextBtn) {
          nextBtn.classList.add("js-active");
          nextSlide.classList.add("js-active");
          this.allowNext = true;
        }
      }
    },
  },
};
</script>
<style scoped>
.modal-dialog {
  max-width: 50% !important;
}
</style>