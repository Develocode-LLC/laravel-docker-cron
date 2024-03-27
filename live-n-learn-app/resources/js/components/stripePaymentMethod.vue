<template>
  <div class="container p-4">
    {{ id }}
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <input
                type="text"
                class="form-control my-2"
                v-model="fullNameOnCard"
                placeholder="Full Name On Card"
              />
              <input
                type="text"
                class="form-control my-2"
                v-model="address_line1"
                placeholder="Address Line 1"
              />
              <input
                type="text"
                class="form-control my-2"
                v-model="address_line2"
                placeholder="Address Line 2"
              />
              <div class="row">
                <div class="col-4">
                  <input
                    type="text"
                    class="form-control my-2"
                    v-model="address_city"
                    placeholder="City"
                  />
                </div>
                <div class="col-8">
                  <input
                    type="text"
                    class="form-control my-2"
                    id="state"
                    placeholder="State/Province"
                    v-model="state_province"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <StripeElements
          v-if="stripeLoaded"
          v-slot="{ elements, instance }"
          ref="elms"
          :stripe-key="stripeKey"
          :instance-options="instanceOptions"
          :elements-options="elementsOptions"
        >
          <div class="row">
            <div class="col-6">
              <!-- <StripeElement
                class="form-control"
                ref="card"
                :elements="elements"
                :options="cardOptions"
              /> -->
              <div class="row">
                <div class="col-12">
                  <StripeElement
                    type="cardNumber"
                    class="form-control"
                    ref="cardNumber"
                    :elements="elements"
                    :options="cardNumberOptions"
                  />
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-4">
                  <StripeElement
                    type="cardCvc"
                    ref="cardCvc"
                    class="form-control"
                    :elements="elements"
                    :options="cardCvcOptions"
                  />
                </div>

                <div class="col-4">
                  <StripeElement
                    type="cardExpiry"
                    ref="cardExpiry"
                    class="form-control"
                    :elements="elements"
                    :options="cardExpiryOptions"
                  />
                </div>
                <div class="col-4">
                  <StripeElement
                    type="postalCode"
                    ref="cardPostal"
                    class="form-control"
                    :elements="elements"
                    :options="postalCodeOptions"
                  />
                </div>
              </div>
            </div>
          </div>
        </StripeElements>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12">
        <button type="button" @click="pay" class="btn bg-gradient-success">
          {{ formType == "store" ? "Store My Card" : "Make Payment" }}
        </button>
      </div>
    </div>
  </div>
</template>
  
  <script>
import { StripeElements, StripeElement } from "vue-stripe-js";
import { loadStripe } from "@stripe/stripe-js";
import { defineComponent, ref, onBeforeMount, defineProps } from "vue";
import store from "@/store/index.js";
import axios from "axios";
import { useRoute } from "vue-router";

export default defineComponent({
  name: "stripePaymentMethod",

  components: {
    StripeElements,
    StripeElement,
  },
  props: ["formFunction"],
  setup(props) {
    const route = useRoute();
    const stripeKey = ref(store.state.stripePublishableKey); // test key

    // https://stripe.com/docs/js/initializing#init_stripe_js-options
    const instanceOptions = ref({});

    // https://stripe.com/docs/js/elements_object/create#stripe_elements-options
    const elementsOptions = ref({});

    // https://stripe.com/docs/stripe.js#element-options
    const cardOptions = ref({});
    const cardNumberOptions = ref({});
    const postalCodeOptions = ref({});
    const cardCvcOptions = ref({});
    const cardExpiryOptions = ref({});
    const stripeLoaded = ref(false);
    const card = ref();
    const cardNumber = ref();
    const elms = ref();

    //extra card details
    const fullNameOnCard = ref("");
    const address_line1 = ref();
    const address_line2 = ref();
    const address_city = ref();
    const address_zip = ref("");
    const address_country = ref();
    const formType = ref(props.formFunction);
    console.log(formType);

    onBeforeMount(() => {
      const stripePromise = loadStripe(stripeKey.value);
      getSavedPaymentDetails();
      stripePromise.then(() => {
        stripeLoaded.value = true;
      });
    });

    const getSavedPaymentDetails = async () => {
      var newApiUrl =
        store.state.apiUrl + "user/" + route.params.id + "/user_payment_method";
      console.log(newApiUrl);
      await axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((result) => {
          console.log(result);
        })
        .catch((error) => {
          consol.error(error);
        });
    };

    const pay = async () => {
      // Get stripe element
      const cardNumberElement = cardNumber.value.stripeElement;

      // Access instance methods, e.g. createToken()
      elms.value.instance
        .createToken(cardNumberElement, {
          name: fullNameOnCard.value,
          address_line1: address_line1.value,
          address_line2: address_line2.value,
          address_city: address_city.value,
          address_country: address_country.value,
        })
        .then((result) => {
          // Handle result.error or result.token
          if (result.error) {
            console.error(result.error);
          } else {
            if (props.formFunction === "store") {
              storeCard(result.token.id);
            } else {
              // this.makePurchase();
            }
          }
        });
    };

    const storeCard = async (token) => {
      var newApiUrl =
        store.state.apiUrl + "user/" + route.params.id + "/payment_method";
      await axios
        .post(
          newApiUrl,
          { stripe_token: token },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.token,
            },
          }
        )
        .then((result) => {
          console.log(result);
        })
        .catch((error) => {
          consol.error(error);
        });
    };

    const makePurchase = async () => {
      var newApiUrl = this.$store.state.apiUrl + "";
      await axios
        .post(
          { newApiUrl },
          {},
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.token,
            },
          }
        )
        .then((result) => {
          console.log(result);
        })
        .catch((error) => {
          consol.error(error);
        });
    };

    return {
      storeCard,
      makePurchase,
      stripeKey,
      stripeLoaded,
      instanceOptions,
      elementsOptions,
      cardOptions,
      cardNumber,
      cardNumberOptions,
      postalCodeOptions,
      cardCvcOptions,
      card,
      elms,
      pay,
      fullNameOnCard,
      address_line1,
      address_line2,
      address_city,
      address_zip,
      address_country,
      formType,
    };
  },
  methods() {},
});
</script>