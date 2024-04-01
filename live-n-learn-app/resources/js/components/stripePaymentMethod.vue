<template>
  <!-- <div class="container p-2"> -->
  <div class="row" v-if="!checkoutPage">
    <div class="col-12">
      <label class="mb-0">Payment Amount:</label>
      <input type="text" ref="paymentAmountInput" class="form-control my-2" v-model="paymentAmount" placeholder="$0.00"
        v-if="formFunction != 'store'" />
    </div>
  </div>
  <row class="mt-4">
    <div class="col-12">
      <ul class="list-group">
        <li class="list-group-item active text-center" @click="(e) => cardSelector(e, 'addNew')">Add new card</li>
        <li class="list-group-item bg-warn text-center" v-if="isLoadingPaymentMethod"> <span
            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"> </span> </li>
        <li class="list-group-item" v-for="(data, index) in savedPaymentMethods" :key="index"
          @click="(e) => cardSelector(e, data)">
          <div class="row" v-if="data.requires_verification == 0">
            <div class="col-1"><i :class="getCardIcon(data.stripe_object?.card?.brand ?? '')"></i></div>
            <div class="col-2">{{ data.stripe_object?.type != "us_bank_account" ? data.stripe_object?.card.brand : 'ACH'
            }}</div>
            <div class="col-4">
              <p class="text-xs"> {{ data.stripe_object?.type != "us_bank_account" ? '******...' +
                data.stripe_object?.card.last4 : data.stripe_object?.us_bank_account?.bank_name }}</p>
            </div>
            <div class="col-5">{{ data.stripe_object?.billing_details.name }}</div>
          </div>
        </li>
      </ul>
    </div>
  </row>
  <div class="row" v-if="addNewCard">
    <div class="col-12">
      <div class="row">
        <div class="col-12">
          <div class="form-group">

            <input type="text" class="form-control my-2" v-model="fullNameOnCard" placeholder="Full Name On Card" />
            <input type="text" class="form-control my-2" v-model="address_line1" placeholder="Address Line 1" />
            <input type="text" class="form-control my-2" v-model="address_line2" placeholder="Address Line 2" />
            <div class="row">
              <div class="col-4">
                <input type="text" class="form-control my-2" v-model="address_city" placeholder="City" />
              </div>
              <div class="col-8">
                <input type="text" class="form-control my-2" id="state" placeholder="State/Province"
                  v-model="state_province" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <StripeElements v-if="stripeLoaded" v-slot="{ elements, instance }" ref="elms" :stripe-key="stripeKey"
        :instance-options="instanceOptions" :elements-options="elementsOptions">
        <div class="row">
          <div class="col-12">
            <!-- <StripeElement
                class="form-control"
                ref="card"
                :elements="elements"
                :options="cardOptions"
              /> -->
            <div class="row">
              <div class="col-12">
                <StripeElement type="cardNumber" class="form-control" ref="cardNumber" :elements="elements"
                  :options="cardNumberOptions" />
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-4">
                <StripeElement type="cardCvc" ref="cardCvc" class="form-control" :elements="elements"
                  :options="cardCvcOptions" />
              </div>

              <div class="col-4">
                <StripeElement type="cardExpiry" ref="cardExpiry" class="form-control" :elements="elements"
                  :options="cardExpiryOptions" />
              </div>
              <div class="col-4">
                <StripeElement type="postalCode" ref="cardPostal" class="form-control" :elements="elements"
                  :options="postalCodeOptions" />
              </div>
            </div>
          </div>
        </div>
      </StripeElements>
    </div>
  </div>
  <!-- <stripe-ach-payment-method v-if="addBank"></stripe-ach-payment-method> -->
  <div class="row mt-3">
    <div class="col-12">
      <button type="button" @click="pay" class="btn bg-gradient-success" v-if="formFunction == 'store'">
        Store My Card
      </button>
      <button type="button" @click="pay" class="btn bg-gradient-success" v-else>
        Make Payment
      </button>
    </div>
  </div>

  <!-- </div> -->
</template>
  
<script>
import { StripeElements, StripeElement } from "vue-stripe-js";
import { loadStripe } from "@stripe/stripe-js";
import { defineComponent, ref, onBeforeMount, defineProps, reactive, toRaw, nextTick, onMounted, onUpdated, onBeforeUpdate, watch } from "vue";
import store from "@/store/index.js";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import { useCurrencyInput } from 'vue-currency-input'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import bootstrap from "bootstrap/dist/js/bootstrap";
import stripeACHPaymentMethod from '@/components/stripeACHPaymentMethod.vue';

export default defineComponent({
  name: "stripePaymentMethod",

  components: {
    StripeElements,
    StripeElement,
    stripeACHPaymentMethod
  },
  props: ["formFunction", 'userId', 'invoiceId', 'checkoutPage', 'payment-amount'],
  setup(props) {
    const route = useRoute();
    const router = useRouter();
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

    //purchase refs
    const paymentAmount = ref()
    const savedPaymentMethods = ref([]);
    const existing_payment_method = ref();
    const stripe_customer_id = ref();
    const addNewCard = ref(true);
    const addBank = ref(false);
    const paymentType = ref();

    //functional refs
    const storeCardAndPay = ref(true)
    const propLoaded = ref(false);
    const isLoadingPaymentMethod = ref(true);

    const { paymentAmountInput } = useCurrencyInput({ currency: 'USD' })

    onBeforeMount(() => {
      const stripePromise = loadStripe(stripeKey.value);

      stripePromise.then(() => {
        stripeLoaded.value = true;
      });
    });

    watch(() => props.userId, (newValue, oldValue) => {
      // isLoadingPaymentMethod.value = true;
      if (!propLoaded.value && newValue !== undefined) {
        // Run your method here
        getSavedPaymentDetails();
        //console.log('Prop has loaded:', newValue);

        // Update the flag to prevent running the method again
        propLoaded.value = true;
      }
    });

    const getSavedPaymentDetails = async () => {

      // isLoadingPaymentMethod.value = true;

      var newApiUrl =
        store.state.apiUrl + "user/" + props.userId + "/user_payment_method";
      //console.log(newApiUrl);
      await axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((result) => {
          //console.log(result)
          if (result.data.payment_methods) {
            var data = result.data.payment_methods.filter(obj => obj.requires_verification == 0) ?? []
            //console.log(data)
            savedPaymentMethods.value = data;
            isLoadingPaymentMethod.value = false;
          }


        })
        .catch((error) => {
          //console.error(error);
        });
    };

    const pay = async () => {
      // Get stripe element
      const cardNumberElement = cardNumber.value.stripeElement;
      // //console.log(storeCardAndPay.value)
      // return;

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
            //console.error(result.error);
          } else {
            if (props.formFunction === "store") {
              storeCard(result.token.id);
            } else if (storeCardAndPay.value) {
              storeCard(result.token.id)

              nextTick(() => {
                getSavedPaymentDetails();
              });

              makePurchase();

            } else {
              makePurchase();
            }
          }
        });
    };

    const storeCard = async (token) => {
      var newApiUrl =
        store.state.apiUrl + "user/" + props.userId + "/user_payment_method";
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
          //console.log(result);
          getSavedPaymentDetails();
        })
        .catch((error) => {
          //console.error(error.message);
        });
    };

    const makePurchase = async () => {

      var newApiUrl = store.state.apiUrl + "invoice/" + props.invoiceId + "/make_payment";
      // //console.log(paymentAmount);

      // return;
      await axios
        .post(
          newApiUrl,
          {
            "stripe_customer_id": stripe_customer_id.value,
            "existing_payment_method": existing_payment_method.value,
            "amount": paymentAmount.value,
            "type": paymentType.value
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
          //console.log(result);
          var myModalEl = document.getElementById('createPaymentModal')
          var modal = bootstrap.Modal.getInstance(myModalEl)
          modal.hide()
          toast.success("Payment Made Successfully!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER })
          router.go();
        })
        .catch((error) => {
          //console.error(error);
        });

    };
    const getCardIcon = (cardType) => {
      switch (cardType) {
        case 'visa':
          return 'fa fa-cc-visa';
        case 'mastercard':
          return 'fa fa-cc-mastercard';
        case 'amex':
          return 'fa fa-cc-amex';
        // Add more cases for other card types as needed
        default:
          return 'fa fa-credit-card'; // Default icon
      }
    }

    const cardSelector = (e, cardData) => {
      var el = e.target;
      if (!el.classList.contains('list-group-item')) {
        el = el.parentElement.parentElement;
      }

      if (el.classList.contains("list-group-item") && !el.classList.contains("active")) {
        const activeEl = document.querySelector('.list-group-item.active');
        activeEl.classList.remove("active");
        el.classList.add("active")
      }
      if (cardData == "addNew") {

        addNewCard.value = true;
        existing_payment_method.value = ""
        stripe_customer_id.value = ""
        if (props.formFunction != 'store') {
          storeCardAndPay.value = true;
        }

      } else if (cardData == "addBank") {
        addBank.value = true;
        existing_payment_method.value = ""
        stripe_customer_id.value = ""
        if (props.formFunction != 'store') {
          storeCardAndPay.value = true;
        }
      }
      else {
        addNewCard.value = false;
        var stripeData = toRaw(cardData);
        existing_payment_method.value = stripeData.stripe_object.id
        stripe_customer_id.value = stripeData.stripe_object.customer
        paymentType.value = stripeData.stripe_object.type == "us_bank_account" ? "ach" : "credit";
      }
    }

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
      paymentAmount,
      savedPaymentMethods,
      getCardIcon,
      paymentAmountInput,
      cardSelector,
      addNewCard,
      existing_payment_method,
      stripe_customer_id,
      storeCardAndPay,
      paymentType,
      getSavedPaymentDetails,
      isLoadingPaymentMethod
    };
  },
  methods() { },
  created() {
    // this.getSavedPaymentDetails();
  },
});
</script>

<style lang="scss" scoped>
.list-group-item.active {
  background-color: #64b1bd;
  border-color: #64b1bd;
}
</style>