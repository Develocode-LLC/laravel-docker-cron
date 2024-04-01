<template>
    <div class="row">
        <div class="col-md-10 card mx-auto p-4">
            <h6 class="text-center fs-2">Alternate Flight Request</h6>
            <div class="row p-4">
                <div class="col-10 mx-auto">
                    <h5 class="card-title">Alternate Flight Request
                    </h5>

                    <p class="font-weight-light text-left w-100 block">
                        Travelers may request to change either their outbound or return flight (subject to fare
                        rules
                        and restrictions) up to 60 days prior to departure. The change must be on the same airline
                        with
                        which the group is flying. Live N Learn cannot guarantee that alternate flights are
                        available.
                        Travelers wishing to make alternate flight arrangements will be charged an administrative
                        fee at
                        the time of change, plus any difference in airfare charged by the airlines. Both the
                        administrative fee and fare difference are non-refundable in case of cancellation.
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="col-10 mx-auto">
                    <table class="table table-striped ">
                        <h5 class="text-center">Alternate Flight Request Fees</h5>
                        <thead>
                            <tr scope="col ">
                                <th class="text-center">Days before departure</th>
                                <th class="text-center">Fee</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td> {{ '<' }} 90+ days</td>
                                <td>$125</td>
                            </tr>
                            <tr>
                                <td>60 to 89 days</td>
                                <td>$225</td>
                            </tr>
                            <tr>
                                <td>Less than 60 days</td>
                                <td>No changes permitted0</td>
                            </tr>

                        </tbody>
                    </table>
                </div>


            </div>
            <div class="row p-4">
                <div class="col-10 mx-auto">
                    <h5 class="text-center ">Alternate Flight Request Process</h5>
                    <ol>
                        <li>
                            <p class="font-weight-light text-left w-100 block">

                                Traveler must submit the alternate flight form with the requested deviation and pay the
                                alternate flight fee
                            </p>

                        </li>
                        <li>
                            <p class="font-weight-light text-left w-100 block">
                                Live N Learn will reach out to confirm the request.
                            </p>

                        </li>
                        <li>
                            <p class="font-weight-light text-left w-100 block">
                                Live N Learn will contact the airline to request the desired change. If the change is
                                possible, the airline will inform Live N Learn if there is any difference in fare.
                            </p>


                        </li>
                        <li>
                            <p class="font-weight-light text-left w-100 block">
                                Live N Learn will reach out to the traveler to approve the change and fare difference:
                            </p>

                        </li>
                        <ol>
                            <li type="a">
                                <p class="font-weight-light text-left w-100 block">
                                    If the change is approved, Live N Learn will send you an invoice for the fare
                                    difference which must be paid within 10 days of invoice date.
                                </p>

                            </li>
                            <li type="a">
                                <p class="font-weight-light text-left w-100 block">
                                    If change is denied, Live N Learn will refund you for half of the alternate flight
                                    request fee.
                                </p>

                            </li>
                        </ol>

                    </ol>
                </div>


            </div>
            <div class="row">
                <div class="col-10 mx-auto">
                    <h5 class="text-uppercase">Forfeiting Return Flight</h5>
                    <p class="font-weight-light text-left w-100 block">
                        Travelers also have the option to instead forfeit their return
                        flight and book a return flight on their own. If you choose to forgo the return flight with the
                        group there will be no refund
                        available from the airline for the unused portion of the trip. You will not be charged the
                        Live N Learn administrative fee in this case. <strong> Students cannot choose to forgo the
                            outbound flight from the USA to the destination country, only the return flight. </strong>
                    </p>
                </div>




            </div>
            <div class="row p-4">
                <div class="col-10 mx-auto">
                    <form class="container-fluid p-4 " @submit.prevent="submit">
                        <div v-if="this.showError" class="row">
                            <div class="col-md-4">
                                <p class="text-danger">{{ error.message }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 mx-auto">
                                <div class="form-group">
                                    <p class="font-weight-light text-left w-100 block">Would
                                        you like a different outbound or
                                        inbound
                                        flight
                                        than the
                                        group? <i class="text-sm p-2">
                                            Not all schools will allow students to alter their flights, so please
                                            consult
                                            with your
                                            Group Leader.

                                        </i></p>
                                    <select v-model="formData.different_flight_request" class="form-control"
                                        id="different_flight_request">
                                        <option value="yes">Yes, I would like to submit an alternate flight request
                                        </option>
                                        <option value="no">No, I will keep the same flight as the group.</option>
                                        <option value="forfeit">I plan to forfeit my return flight.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="formData.different_flight_request === 'yes'">
                            <div class="col-8 mx-auto">
                                <div class="form-group">
                                    <label for="" class="lead">Which segment of the flight would you like to change?
                                    </label>
                                    <select id="flight_to_change" v-model="formData.flight_to_change"
                                        class="form-control">
                                        <option value="outbound">Outbound flight</option>
                                        <option value="inbound">Inbound flight</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="formData.different_flight_request === 'yes'">
                            <div class="col-8 mx-auto mt-4">
                                <h5>Alternate Date</h5>
                                <p class="font-weight-light text-left w-100 block">On which date would you like to fly
                                    for the portion of the flight
                                    that is being modified? <i class="text-sm">Live N Learn can quote a maximum of two
                                        date
                                        options.</i> </p>
                                <div class="form-group">

                                    <label>Flight Date 1</label>
                                    <input type="date" class="form-control" v-model="formData.alt_flight_date_1" />
                                    <!-- <div class="input-group input-group-sm">
                                <span class="input-group-text">Flight Date 1</span>
                                <input type="date" class="form-control" v-model="formData.alt_flight_date_1" />
                            </div> -->
                                    <label>Flight Date 2</label>
                                    <input type="date" class="form-control" v-model="formData.alt_flight_date_2" />
                                    <!-- <div class="input-group input-group-sm">
                                <span class="input-group-text">Flight Date 2</span>
                                <input type="date" class="form-control" v-model="formData.alt_flight_date_2" />
                            </div> -->
                                </div>

                            </div>
                        </div>
                        <div class="row mt-4 " v-if="formData.different_flight_request === 'yes'">
                            <div class="col-8 mx-auto">
                                <h5>
                                    Flight Route <i class="text-danger text-sm">*</i>
                                </h5>
                                <p class="font-weight-light text-left w-100 block">
                                    Please specify the flight route you are interested in if you wish to change the
                                    outbound
                                    or return flight. Note that some airlines may require that the same Transatlantic
                                    route
                                    be taken, so if you are traveling to a different country you may need to have an
                                    additional layover in or fly out of the group departure city.
                                </p>
                                <div class="form-group">

                                    <textarea class="form-control" v-model="formData.flight_route_comment"
                                        id="flight_route_comment" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row p-4">
                            <div class="col-12 mx-auto">
                                <p class="font-weight-light text-left w-100 block">
                                    My child (Traveler Name) has my permission to travel separately from the Live N
                                    Learn group.
                                    I accept complete responsibility for whatever may happen while they travel
                                    independently. I
                                    understand that Live N Learn and the group leader(s) have no liability for any
                                    incidents or
                                    costs incurred. I agree to arrange and pay for ground transportation for my student
                                    to meet
                                    the group if necessary. I release Live N Learn, the Group Leader(s) and the Host
                                    Family (if
                                    applicable) from any and all responsibility for the above-named traveler during the
                                    time my
                                    child is traveling separate from the group.
                                </p>
                            </div>
                        </div>
                        <div class="row p-4">

                            <signature-pad formId="7"></signature-pad>

                        </div>

                        <div class="row mt-6">
                            <div class="col-6 mx-auto">
                                <div class="form-group">
                                    <button class="btn btn-success btn-lg w-100" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</template>
<script>
import SignaturePad from '../policies/signaturePad.vue'

export default {
    components: {
        SignaturePad,
    },

    data() {

        return {
            formData: {
                different_flight_request: "no",
                flight_to_change: "outbound", // or inbound
                alt_flight_date_1: "",
                alt_flight_date_2: "",
                flight_route_comment: ""
            },
            showError: false,
            error: {
                message: ""
            }
        }
    },

    methods: {

        submit() {

            console.log("get API", this.formData)
        },
    }
}
</script>
<style scoped></style>