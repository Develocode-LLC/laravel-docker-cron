<template>
  <form class="container-fluid" @submit.prevent="submit">
    <div class="row ">
      <div class="col-6 mx-auto">
        <div class="form-group">
          <label for="parent_guardian_printed_name">Parent/Guardian Name:</label>
          <input class="form-control" type="text" id="parent_guardian_printed_name"
            v-model="formData.parent_guardian_printed_name" required :disabled="isTraveler" />
        </div>
      </div>
      <div class="col-6" v-if="hasTraveler">
        <div class="form-group" v-if="current_signature && current_signature.signature_type !== 'traveler'">
          <label for="traveler_printed_name">Traveler Name:</label>
          <input class="form-control" type="text" id="traveler_printed_name" v-model="formData.traveler_printed_name"
            required :disabled="!isTraveler" />
        </div>
      </div>

    </div>
    <!-- signature blocks -->
    <div class="row ">
      <!-- parent signature -->
      <div class="col-6 mx-auto">
        <div class="form-group d-flex flex-column"
          v-if="current_signature && current_signature.signature_type !== 'parent'">
          <label for="parent_signature">Parent/Guardian signature:</label>

          <canvas :class="isTraveler ? 'pe-none' : ''" ref="canvas" id="parent_signature"></canvas>
        </div>
        <!-- parent signature image -->
        <div class="form-group d-flex flex-column"
          v-if="current_signature && current_signature.signature_type === 'parent'">
          <img :src="current_signature?.signature_uri" alt="parent signature">
        </div>
      </div>
      <!-- traveler signature -->
      <div class="col-6" v-if="hasTraveler">
        <div class="form-group d-flex flex-column"
          v-if="current_signature && current_signature.signature_type !== 'traveler'">
          <label>Traveler signature:</label>

          <canvas :class="!isTraveler ? 'pe-none' : ''" ref="traveler" id="traveler_signature"></canvas>
        </div>
        <div class="form-group d-flex flex-column">
          <label>Traveler signature:</label>
        </div>
        <!-- traveler signature image -->
        <div class="form-group d-flex flex-column"
          v-if="current_signature && current_signature.signature_type === 'traveler'">
          <img :src="current_signature?.signature_uri" alt="parent signature">

        </div>
      </div>
    </div>


    <!-- date -->
    <div class="row">
      <div class="col-6 mx-auto">
        <div class="form-group">
          <label for="signed_date">Date:</label>

          <input class="form-control" type="date" id="signed_date" v-model="formData.date" />
        </div>
      </div>
    </div>
    <!-- Clear button -->
    <div class="row p-4 ">
      <div class="col-6 mx-auto ">
        <div class="form-group ">
          <button class="form-control w-50 btn-danger mx-auto" @click.prevent="clearSignature">
            Clear
          </button>
        </div>
      </div>


    </div>
  </form>
</template>
<script>
import SignaturePad from "signature_pad";
import axios from "axios";
import { vMaska } from "maska";
import store from "@/store/index.js";
import { toast } from 'vue3-toastify';
import moment from "moment";
import { ref } from 'vue'
import { nextTick } from "vue";
export default {
  directives: { maska: vMaska },


  props: {
    hasTraveler: false,
    formType: "",
    formId: ""
  },
  data() {
    return {
      isEmpty: false,
      isTraveler: false,
      current_signature: null,
      signature_uri: '',
      tripData: {},
      userData: {},
      childrenData: {},
      signaturePad: null,
      travelerSignaturePad: null,
      formData: {
        parent_guardian_printed_name: "",
        traveler_printed_name: "",
        date: moment(new Date()).format('YYYY-MM-DD'),
        parent_guardian_signature: null,
        traveler_signature: null,
      }, error: {
        message: ""
      },
      showError: false,
    };
  },
  mounted() {
    if (this.signaturePad === null) return;
    this.signaturePad = new SignaturePad(this.$refs.canvas, {
      // You can add configuration options here
      // e.g., backgroundColor: 'rgba(255, 255, 255, 0)'
    });
    if (this.hasTraveler) {
      this.travelerSignaturePad = new SignaturePad(this.$refs.traveler, {
        // You can add configuration options here
        // e.g., backgroundColor: 'rgba(255, 255, 255, 0)'
      });
    }


  },
  beforeDestroy() {
    // Clear the signature pad when the component is destroyed
    if (this.hasTraveler) {
      this.travelerSignaturePad.clear();
    }

    this.signaturePad.clear();
  },
  methods: {
    getUserData() {
      let user = JSON.parse(localStorage.getItem("user"));

      let userTripApi = this.$store.state.apiUrl + "user_with_trips/" + user.id;
      axios
        .get(userTripApi, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        }).then((r) => {
          const result = r.data;
          if (result.user.class === 'traveler') {
            console.log(result.user.trips);
            this.isTraveler = true;

            this.tripData = result.user.trips;
            this.userData = result.user;
          } else if (result.user.class === 'parent') {
            this.isTraveler = false;
            this.tripData = result.user.children[0]?.trips;
            this.userData = result.user.children[0];
            this.childrenData = result.user.children;
          }
          localStorage.setItem('tripData', this.tripData[0].id);

        }).catch(e => {
          this.showError = true;
          this.error.message = 'An Error occured';
          console.error(e.message);
        });

    },
    getUserSignature() {
      let user = JSON.parse(localStorage.getItem("user"));
      let latestTripId = JSON.parse(localStorage.getItem('tripData'));
      //  GET /api/v1/trip/{trip}/form/{form}/user/{user}/trip_form_signature

      // console.log(latestTripId)
      const getUserSignatureApiURL = this.$store.state.apiUrl + `trip/${latestTripId}/form/${this.formId}/user/${user.id}/trip_form_signature`;
      axios.get(getUserSignatureApiURL, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.token,
        }
      }).then(r => {
        const signatures = r.data.form_signatures;
        this.current_signature = signatures[0];
      }).catch(e => {

        console.error(e);
      })

    },
    saveSignature() {

      // we are a traveler we only need to save traveler signature.
      if (this.isTraveler) {

        // check if printed name is there.
        if (this.formData.traveler_printed_name.length <= 0) {
          toast.error(" Traveler Printed name cannot be blank", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

          return false;
        }
        // check for empty signature pad.
        if (this.travelerSignatureIsEmpty()) {
          toast.error(" Traveler Signature cannot be blank", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

          return false;
        }

        // both inputs have data save the traveler signature
        this.formData.traveler_signature =
          this.travelerSignaturePad.toDataURL();
        // this.formData.parent_guardian_signature = this.signaturePad.toDataURL();
        return true;
      } else {
        // we are a parent. we should only sign the parent signature.

        // check if the parent  printed name is available 
        if (this.formData.parent_guardian_printed_name.length <= 0) {
          toast.error(" Parent Printed name cannot be blank", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

          return false
        }
        // ensure the signature is not blank
        if (this.parentSignatureIsEmpty()) {
          toast.error(" Parent Signature cannot be blank", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

          return false;
        }

        this.formData.parent_guardian_signature = this.signaturePad.toDataURL();
        return true;
      }





    },

    clearSignature() {
      if (this.hasTraveler) {
        this.travelerSignaturePad.clear();
        this.formData.traveler_printed_name = "";

      } else {
        this.signaturePad.clear();
        this.formData.parent_guardian_printed_name = "";
      }

    },
    parentSignatureIsEmpty() {

      return this.signaturePad.isEmpty();

    },
    travelerSignatureIsEmpty() {
      return this.travelerSignaturePad.isEmpty();

    },
    async submit() {
      if (this.saveSignature()) {
        const user = JSON.parse(localStorage.getItem("user"));

        const tripId = this.tripData[0]?.id; // need to get trip id
        const formType = this.formType;
        const signedDate = this.formData.date;

        if (tripId === undefined) {
          this.showError = true;
          this.error.message = 'No trip id found'
          return;
        }



        var newApiUrl = this.$store.state.apiUrl + `trip/${tripId}/form/${this.formId}/user/${user.id}/trip_form_signature`;


        await axios.post(newApiUrl, {
          form_type: formType,
          signature_type: this.userData.class,
          name: this.userData.full_name,
          signature_date: signedDate,
          signature: this.isTraveler ? this.formData.traveler_signature : this.formData.parent_guardian_signature,

        }, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        }).then(result => {

          if (result) { this.signaturePad.clear() }
          console.log(result)
          toast.success("Signed  Successfully!", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });


        }).catch(error => {
          console.log(error)


          toast.error("Unable to sign", { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });


        });
      } else {
        this.error.message = 'Not able to save';
        this.showError = true;
        toast.error(this.error.message, { autoClose: 600, position: toast.POSITION.BOTTOM_CENTER });

      }


    },
  },
  beforeMount() {
    this.getUserData();
    this.getUserSignature();
  },
};
</script>
<style>
/* Add any custom styles for the signature pad */
canvas {
  border: 1px solid #000;
  margin: 0.75rem;
}

.signature-pad>input {
  height: 2rem;
  margin: auto;
}
</style>
