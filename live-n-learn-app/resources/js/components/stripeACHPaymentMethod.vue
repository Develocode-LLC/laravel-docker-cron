<template>
  <div class="container p-4">
    {{ id }}
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <input type="text" class="form-control my-2" v-model="fullName" placeholder="Account Holder Name" />
              <input type="text" class="form-control my-2" v-model="routing_number" placeholder="Routing Number" />
              <input type="text" class="form-control my-2" v-model="account_number" placeholder="Account Number" />
              <input type="text" class="form-control my-2" v-model="account_number_confirm"
                placeholder="Account Number Confirmation" />
              <div class="form-group">
                <select id="country_code" class="form-control" v-model="country_code">
                  <option value="">Please select your country</option>
                  <option v-for="country in country_list" :key="country.number" :value="country.code">
                    {{ country.name }}
                  </option>
                </select>
              </div>

            </div>
          </div>
        </div>
        <StripeElements v-if="stripeLoaded" v-slot="{ elements, instance }" ref="elms" :stripe-key="stripeKey"
          :instance-options="instanceOptions" :elements-options="elementsOptions">

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
import countries from "@/utils/countries.js";


export default defineComponent({
  name: "stripeAchPaymentMethod",

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
    const country_list = ref(countries)
    const country_code = ref("");

    onBeforeMount(() => {
      const stripePromise = loadStripe(stripeKey.value);
      // getSavedPaymentDetails();
      stripePromise.then(() => {
        stripeLoaded.value = true;
      });
    });

    // const getSavedPaymentDetails = async () => {
    //   var newApiUrl =
    //     store.state.apiUrl + "user/" + route.params.id + "/user_payment_method";
    //   console.log(newApiUrl);
    //   await axios
    //     .get(newApiUrl, {
    //       headers: {
    //         "Content-Type": "application/json",
    //         Accept: "application/json",
    //         Authorization: "Bearer " + localStorage.token,
    //       },
    //     })
    //     .then((result) => {
    //       console.log(result);
    //     })
    //     .catch((error) => {
    //       console.error(error);
    //     });
    // };

    const pay = async () => {
      // Get stripe element
      // const cardNumberElement = cardNumber.value.stripeElement;

      // Access instance methods, e.g. createToken()
      elms.value.instance
        .createToken('bank_account', {
          country: 'US',
          currency: 'usd',
          routing_number: '110000000',
          account_number: '000123456789',
          account_holder_name: 'Jenny Rosen',
          account_holder_type: 'individual',
        })
        .then((result) => {
          // console.log(result);
          // return;
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
        store.state.apiUrl + "user/" + route.params.id + "/user_payment_method";
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
          console.error(error.response.data);
        });
    };

    const makePurchase = async () => {
      var newApiUrl = this.$store.state.apiUrl + "";
      await axios
        .post(
          newApiUrl,
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
          console.error(error);
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
      country_list,
      country_code
    };
  },
  methods() { },
});
</script>