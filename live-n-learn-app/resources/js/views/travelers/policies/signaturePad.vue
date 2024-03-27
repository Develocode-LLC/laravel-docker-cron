<template>
  <form class="container-fluid">
    <div class="row mx-auto">
      <div class="col-6">
        <div class="form-group">
          <label for="parent_guardian_printed_name"
            >Parent/Gaurdian's Name:</label
          >
          <input
            class="form-control"
            type="text"
            id="parent_guardian_printed_name"
            v-model="formData.parent_guardian_printed_name"
            required
          />
        </div>
      </div>
      <div class="col-6" v-if="hasTraveler">
        <div class="form-group">
          <label for="traveler_printed_name">Traveler's Name:</label>
          <input
            class="form-control"
            type="text"
            id="traveler_printed_name"
            v-model="formData.traveler_printed_name"
            required
          />
        </div>
      </div>
      <!-- <div class="col-4">
        <div class="form-group">
          <label for="signed_date">Date:</label>

          <input
            class="form-control"
            type="date"
            id="signed_date"
            v-model="formData.date"
          />
        </div>
      </div> -->
    </div>
    <div class="row mx-auto">
      <div class="col-6">
        <div class="form-group d-flex flex-column">
          <label for="parent_signature">Parent/Gaurdian's signature:</label>

          <canvas ref="canvas" id="parent_signature"></canvas>
        </div>
      </div>
      <div class="col-6" v-if="hasTraveler">
        <div class="form-group d-flex flex-column">
          <label>Traveler's signature:</label>

          <canvas ref="traveler" id="traveler_signature"></canvas>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <label for="signed_date">Date:</label>

          <input
            class="form-control"
            type="date"
            id="signed_date"
            v-model="formData.date"
          />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <button
            @click.prevent="saveSignature"
            :disabled="false"
            class="form-control w-50 btn-success"
          >
            Sign
          </button>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import SignaturePad from "signature_pad";

export default {
  props: {
    hasTraveler: false,
  },
  data() {
    return {
      signaturePad: null,
      travelerSignaturePad: null,
      formData: {
        parent_guardian_printed_name: "",
        traveler_printed_name: "",
        date: this.formatDate(new Date()),
        parent_guardian_signature: null,
        traveler_signature: null,
      },
    };
  },
  mounted() {
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
    saveSignature() {
      console.log(this.signaturePad);
      console.log(this.formData);
      if (this.hasTraveler) {
        console.log(this.travelerSignaturePad);

        this.formData.traveler_signature =
          this.travelerSignaturePad.toDataURL();
      }

      this.formData.parent_guardian_signature = this.signaturePad.toDataURL();

      console.log(this.formData);
    },
    formatDate(date) {
      const year = date.getFullYear();
      let month = (1 + date.getMonth()).toString().padStart(2, "0");
      let day = date.getDate().toString().padStart(2, "0");
      return `${year}-${month}-${day}`;
    },
  },
};
</script>
<style>
/* Add any custom styles for the signature pad */
canvas {
  border: 1px solid #000;
  margin: 0.75rem;
}
.signature-pad > input {
  height: 2rem;
  margin: auto;
}
</style>
