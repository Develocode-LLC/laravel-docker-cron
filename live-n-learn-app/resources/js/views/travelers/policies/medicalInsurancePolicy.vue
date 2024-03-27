<template>
  <policy-container
    policy-title="TRAVELER MEDICAL INSURANCE POLICY
"
  >
    <h6 class="card-title text-center">TOTAL COVERAGE GUARANTEED</h6>
    <p>
      Live N Learn provides all students with insurance coverage through the
      DayTripper Travel Medical Insurance Plan. See details here.
    </p>
    <h6 class="text-center">
      Travel Medical Insurance with GeoBlue,<span
        ><a
          href="https://drive.google.com/file/d/1KbH-Mq1fRNjxee_uJBFwrFRlPfTS0dzY/view?usp=sharing"
          target="_blank"
          class="text-info"
        >
          Voyager Choice Plan
        </a></span
      >
    </h6>
    <p>
      Each Live N Learn traveler will be insured with the medical insurance plan
      provided by Tokio Marine in conjunction with Good Neighbor Insurance. This
      plan is designed for groups and provides medical coverage for
      international excursions. Some of the benefits included in the plan are
      medical expenses in the case of hospitalization, emergency reunion as well
      as loss of checked baggage. Live N Learn will purchase the travel medical
      insurance for every traveler and is included in the total cost of the
      trip.
    </p>
    <p>
      In the case that a traveler would need to seek medical treatment abroad,
      the student would pay up front or receive a bill for treatment and upon
      return back to the US would file for reimbursement.
    </p>
  </policy-container>
</template>
<script>
import SignaturePad from "../policies/signaturePad.vue";
import PolicyContainer from "../policies/policyContainer.vue";

export default {
  components: {
    SignaturePad,
    PolicyContainer,
  },
};
</script>
