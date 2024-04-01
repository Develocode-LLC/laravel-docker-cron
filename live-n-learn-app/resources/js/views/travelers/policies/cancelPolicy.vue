<template>
    <policy-container policy-title="LIVE N LEARN CANCELLATION POLICY
">
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <p class="font-weight-light text-left w-100 block">
                    Live N Learn cancellation policy provided below is designed to
                    account for the expenses incurred by Live N Learn well in advance of
                    the group's departure. To be eligible for a refund, all payments
                    must be submitted by established deadlines.
                </p>
            </div>
        </div>
        <!-- Cancellation Instructions -->
        <div class="row">
            <div class="col-10 p-2 mx-auto">

                <h6 class="text-center">Cancellation Instructions</h6>
                <p class="font-weight-light text-left w-100 block">
                    All cancellation requests must be submitted in writing to Live N
                    Learn by email
                    <a href="mailto:info@livenlearn.com" class="text-info">
                        (info@livenlearn.com)</a> by a traveler, their legal guardian or the Group Leander. Please
                    clearly indicate the participant name, school and program name.
                    Live N Learn will issue a check for refunds within 30 days of
                    cancellation.
                </p>
            </div>

        </div>


        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <table class="table table-striped">
                    <thead>
                        <tr scope="col">
                            <th>Days before departure</th>
                            <th>Refund</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>160+days</td>
                            <td>Full refund less $250</td>
                        </tr>
                        <tr>
                            <td>110 to 159 days</td>
                            <td>Full refund less $500</td>
                        </tr>
                        <tr>
                            <td>60 to 109 days</td>
                            <td>Full refund less $1,300</td>
                        </tr>
                        <tr>
                            <td>35 to 59 days</td>
                            <td>Full refund less 50% of program price</td>
                        </tr>
                        <tr>
                            <td>34 days or less</td>
                            <td>No refund</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <p class="font-weight-light text-left w-100 block">
                    It is recommended to purchase the optional cancellation insurance to
                    assure a 75-100% refund of program price in case of cancellation.
                </p>

            </div>

        </div>
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <p class="font-weight-light text-left w-100 block">
                    It is recommended to purchase the optional cancellation insurance to
                    assure a 75-100% refund of program price in case of cancellation.
                </p>
            </div>
        </div>
        <!-- Involuntary Cancellations -->
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <h6 class="text-uppercase">Involuntary Cancellations</h6>
                <p class="font-weight-light text-left w-100 block">
                    Live N Learn may cancel a student participation due to lack of
                    payment or failure to abide by school or teacher rules/standards
                    prior to the trip. Cancellation fees will be assessed in these
                    cases.
                </p>

            </div>

        </div>
        <!-- Re-enrollment -->
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <h6 class="text-uppercase">Re-enrollment</h6>
                <p class="font-weight-light text-left w-100 block">
                    Based on availability, canceled participants may re-enroll by
                    submitting missing payments, a $50 fee and any applicable changes in
                    airfare.
                </p>
            </div>
        </div>
        <!-- Substitution Policy -->
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <h6 class="text-uppercase">Substitution Policy</h6>
                <p class="font-weight-light text-left w-100 block">
                    Substitutions can be made if the participant finds a suitable
                    replacement and it is approved by the Group Leader. The substitute
                    participant must fill out all registration forms and pay all
                    applicable trip fees at time of enrollment. All substitution
                    requests must be submitted in writing to Live N Learn by email
                    (info@livenlearn.com). Please clearly indicate the substitution
                    name, school and program name. Substitutions are subject to hotel
                    and airline availability.
                </p>
            </div>
        </div>
        <!-- Refund Policy for Substitutions -->
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <h6 class="text-uppercase">Refund Policy for Substitutions</h6>
                <table class="table table-striped">
                    <thead>
                        <tr scope="col">
                            <th>Days before departure</th>
                            <th>Refund for Withdrawing Participant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>90+ days</td>
                            <td>All payments less $500</td>
                        </tr>
                        <tr>
                            <td>45 to 90 days</td>
                            <td>All payments less $750</td>
                        </tr>
                        <tr>
                            <td>44 days or less</td>
                            <td>Determined on a case by case basis</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-10 p-2 mx-auto">
                <p class="text-center fs-6">
                    <i>Price of cancellation insurance is non-refundable in
                        case of cancellation or substitution</i>
                </p>
            </div>
        </div>


        <div class="row">
            <div class="col-12 mx-auto">
                <signature-pad formId="5"></signature-pad>
            </div>
        </div>
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
