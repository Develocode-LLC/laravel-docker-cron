<template>
    <policy-container
        policy-title="LIVE N LEARN CANCELLATION POLICY
"
    >
        <p class="text-break">
            Live N Learn’s cancellation policy provided below is designed to
            account for the expenses incurred by Live N Learn well in advance of
            the group's departure. To be eligible for a refund, all payments
            must be submitted by established deadlines.
        </p>
        <h6 class="text-center">Cancellation Instructions</h6>
        <p>
            All cancellation requests must be submitted in writing to Live N
            Learn by email
            <a href="mailto:info@livenlearn.com" class="text-info">
                (info@livenlearn.com)</a
            >
            by a traveler, their legal guardian or the Group Leander. Please
            clearly indicate the participant’s name, school and program name.
            Live N Learn will issue a check for refunds within 30 days of
            cancellation.
        </p>
        <div class="w-100">
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
        <p class="fw-bolder text-center">
            It is recommended to purchase the optional cancellation insurance to
            assure a 75-100% refund of program price in case of cancellation.
        </p>
        <h6>Involuntary Cancellations</h6>
        <p>
            Live N Learn may cancel a student’s participation due to lack of
            payment or failure to abide by school or teacher’s rules/standards
            prior to the trip. Cancellation fees will be assessed in these
            cases.
        </p>
        <h6>Re-enrollment</h6>
        <p>
            Based on availability, canceled participants may re-enroll by
            submitting missing payments, a $50 fee and any applicable changes in
            airfare.
        </p>
        <h6>Substitution Policy</h6>
        <p>
            Substitutions can be made if the participant finds a suitable
            replacement and it is approved by the Group Leader. The substitute
            participant must fill out all registration forms and pay all
            applicable trip fees at time of enrollment. All substitution
            requests must be submitted in writing to Live N Learn by email
            (info@livenlearn.com). Please clearly indicate the substitution’s
            name, school and program name. Substitutions are subject to hotel
            and airline availability.
        </p>
        <div class="w-100">
            <h6 class="text-center">Refund Policy for Substitutions</h6>

            <table class="table table-striped">
                <thead>
                    <tr scope="col">
                        <th>Days before departure</th>
                        <th>Refund for Withdrawing Participant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>90 + days</td>
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
            <div class="w-100">
                <p class="text-center fs-6">
                    <i
                        >Price of cancellation insurance is non-refundable in
                        case of cancellation or substitution</i
                    >
                </p>
            </div>
        </div>
    </policy-container>

    <signature-pad has-parent="true"></signature-pad>
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
