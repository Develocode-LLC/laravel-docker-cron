<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Edit Partner</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to edit a Partner
                        </p>
                    </div>
                    <div class="row" style="margin: 10px">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="partner_type">Partner Type</label>
                                <select class="form-select" id="partner_type" v-model="partner_type">
                                    <option>Select Partner Type</option>
                                    <option value="Inbound">Inbound Partner</option>
                                    <option value="Outbound">Outbound Partner</option>
                                    <option value="Both">Both</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="partner_name">Partner Name</label>
                                <input type="text" class="form-control" id="partner_name" placeholder="Partner Name"
                                    v-model="name" />
                            </div>
                            <div class="form-group">
                                <label for="address_1">Address 1</label>
                                <input type="text" class="form-control" id="address_1" placeholder="Address 1"
                                    v-model="address_1" />
                            </div>
                            <div class="form-group">
                                <label for="address_2">Address 2</label>
                                <input type="text" class="form-control" id="address_2" placeholder="Address 2"
                                    v-model="address_2" />
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" placeholder="City" v-model="city" />
                            </div>
                            <div class="form-group">
                                <label for="state">State/Province</label>
                                <input type="text" class="form-control" id="state" placeholder="State"
                                    v-model="state_province" />
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" placeholder="Postal Code"
                                    v-model="postal_code" />
                            </div>
                            <div class="form-group">
                                <label for="country_code">Country</label>
                                <select ref="country_code2" class="form-select" id="country_code" v-model="country_code"
                                    @change="updatePhoneNumber()">

                                    <option value="DZ" data-countryCode="213">Algeria (+213)</option>
                                    <option value="AD" data-countryCode="376">Andorra (+376)</option>
                                    <option value="AO" data-countryCode="244">Angola (+244)</option>
                                    <option value="AI" data-countryCode="1264">Anguilla (+1264)</option>
                                    <option value="AG" data-countryCode="1268">Antigua &amp; Barbuda (+1268)</option>
                                    <option value="AR" data-countryCode="54">Argentina (+54)</option>
                                    <option value="AM" data-countryCode="374">Armenia (+374)</option>
                                    <option value="AW" data-countryCode="297">Aruba (+297)</option>
                                    <option value="AU" data-countryCode="61">Australia (+61)</option>
                                    <option value="AT" data-countryCode="43">Austria (+43)</option>
                                    <option value="AZ" data-countryCode="994">Azerbaijan (+994)</option>
                                    <option value="BS" data-countryCode="1242">Bahamas (+1242)</option>
                                    <option value="BH" data-countryCode="973">Bahrain (+973)</option>
                                    <option value="BD" data-countryCode="880">Bangladesh (+880)</option>
                                    <option value="BB" data-countryCode="1246">Barbados (+1246)</option>
                                    <option value="BY" data-countryCode="375">Belarus (+375)</option>
                                    <option value="BE" data-countryCode="32">Belgium (+32)</option>
                                    <option value="BZ" data-countryCode="501">Belize (+501)</option>
                                    <option value="BJ" data-countryCode="229">Benin (+229)</option>
                                    <option value="BM" data-countryCode="1441">Bermuda (+1441)</option>
                                    <option value="BT" data-countryCode="975">Bhutan (+975)</option>
                                    <option value="BO" data-countryCode="591">Bolivia (+591)</option>
                                    <option value="BA" data-countryCode="387">Bosnia Herzegovina (+387)</option>
                                    <option value="BW" data-countryCode="267">Botswana (+267)</option>
                                    <option value="BR" data-countryCode="55">Brazil (+55)</option>
                                    <option value="BN" data-countryCode="673">Brunei (+673)</option>
                                    <option value="BG" data-countryCode="359">Bulgaria (+359)</option>
                                    <option value="BF" data-countryCode="226">Burkina Faso (+226)</option>
                                    <option value="BI" data-countryCode="257">Burundi (+257)</option>
                                    <option value="KH" data-countryCode="855">Cambodia (+855)</option>
                                    <option value="CM" data-countryCode="237">Cameroon (+237)</option>
                                    <option value="CA" data-countryCode="1">Canada (+1)</option>
                                    <option value="CV" data-countryCode="238">Cape Verde Islands (+238)</option>
                                    <option value="KY" data-countryCode="1345">Cayman Islands (+1345)</option>
                                    <option value="CF" data-countryCode="236">Central African Republic (+236)</option>
                                    <option value="CL" data-countryCode="56">Chile (+56)</option>
                                    <option value="CN" data-countryCode="86">China (+86)</option>
                                    <option value="CO" data-countryCode="57">Colombia (+57)</option>
                                    <option value="KM" data-countryCode="269">Comoros (+269)</option>
                                    <option value="CG" data-countryCode="242">Congo (+242)</option>
                                    <option value="CK" data-countryCode="682">Cook Islands (+682)</option>
                                    <option value="CR" data-countryCode="506">Costa Rica (+506)</option>
                                    <option value="HR" data-countryCode="385">Croatia (+385)</option>
                                    <option value="CU" data-countryCode="53">Cuba (+53)</option>
                                    <option value="CY" data-countryCode="90392">Cyprus North (+90392)</option>
                                    <option value="CY" data-countryCode="357">Cyprus South (+357)</option>
                                    <option value="CZ" data-countryCode="42">Czech Republic (+42)</option>
                                    <option value="DK" data-countryCode="45">Denmark (+45)</option>
                                    <option value="DJ" data-countryCode="253">Djibouti (+253)</option>
                                    <option value="DM" data-countryCode="1809">Dominica (+1809)</option>
                                    <option value="DO" data-countryCode="1809">Dominican Republic (+1809)</option>
                                    <option value="EC" data-countryCode="593">Ecuador (+593)</option>
                                    <option value="EG" data-countryCode="20">Egypt (+20)</option>
                                    <option value="SV" data-countryCode="503">El Salvador (+503)</option>
                                    <option value="GQ" data-countryCode="240">Equatorial Guinea (+240)</option>
                                    <option value="ER" data-countryCode="291">Eritrea (+291)</option>
                                    <option value="EE" data-countryCode="372">Estonia (+372)</option>
                                    <option value="ET" data-countryCode="251">Ethiopia (+251)</option>
                                    <option value="FK" data-countryCode="500">Falkland Islands (+500)</option>
                                    <option value="FO" data-countryCode="298">Faroe Islands (+298)</option>
                                    <option value="FJ" data-countryCode="679">Fiji (+679)</option>
                                    <option value="FI" data-countryCode="358">Finland (+358)</option>
                                    <option value="FR" data-countryCode="33">France (+33)</option>
                                    <option value="GF" data-countryCode="594">French Guiana (+594)</option>
                                    <option value="PF" data-countryCode="689">French Polynesia (+689)</option>
                                    <option value="GA" data-countryCode="241">Gabon (+241)</option>
                                    <option value="GM" data-countryCode="220">Gambia (+220)</option>
                                    <option value="GE" data-countryCode="7880">Georgia (+7880)</option>
                                    <option value="DE" data-countryCode="49">Germany (+49)</option>
                                    <option value="GH" data-countryCode="233">Ghana (+233)</option>
                                    <option value="GI" data-countryCode="350">Gibraltar (+350)</option>
                                    <option value="GR" data-countryCode="30">Greece (+30)</option>
                                    <option value="GL" data-countryCode="299">Greenland (+299)</option>
                                    <option value="GD" data-countryCode="1473">Grenada (+1473)</option>
                                    <option value="GP" data-countryCode="590">Guadeloupe (+590)</option>
                                    <option value="GU" data-countryCode="671">Guam (+671)</option>
                                    <option value="GT" data-countryCode="502">Guatemala (+502)</option>
                                    <option value="GN" data-countryCode="224">Guinea (+224)</option>
                                    <option value="GW" data-countryCode="245">Guinea - Bissau (+245)</option>
                                    <option value="GY" data-countryCode="592">Guyana (+592)</option>
                                    <option value="HT" data-countryCode="509">Haiti (+509)</option>
                                    <option value="HN" data-countryCode="504">Honduras (+504)</option>
                                    <option value="HK" data-countryCode="852">Hong Kong (+852)</option>
                                    <option value="HU" data-countryCode="36">Hungary (+36)</option>
                                    <option value="IS" data-countryCode="354">Iceland (+354)</option>
                                    <option value="IN" data-countryCode="91">India (+91)</option>
                                    <option value="ID" data-countryCode="62">Indonesia (+62)</option>
                                    <option value="IR" data-countryCode="98">Iran (+98)</option>
                                    <option value="IQ" data-countryCode="964">Iraq (+964)</option>
                                    <option value="IE" data-countryCode="353">Ireland (+353)</option>
                                    <option value="IL" data-countryCode="972">Israel (+972)</option>
                                    <option value="IT" data-countryCode="39">Italy (+39)</option>
                                    <option value="JM" data-countryCode="1876">Jamaica (+1876)</option>
                                    <option value="JP" data-countryCode="81">Japan (+81)</option>
                                    <option value="JO" data-countryCode="962">Jordan (+962)</option>
                                    <option value="KZ" data-countryCode="7">Kazakhstan (+7)</option>
                                    <option value="KE" data-countryCode="254">Kenya (+254)</option>
                                    <option value="KI" data-countryCode="686">Kiribati (+686)</option>
                                    <option value="KP" data-countryCode="850">Korea North (+850)</option>
                                    <option value="KR" data-countryCode="82">Korea South (+82)</option>
                                    <option value="KW" data-countryCode="965">Kuwait (+965)</option>
                                    <option value="KG" data-countryCode="996">Kyrgyzstan (+996)</option>
                                    <option value="LA" data-countryCode="856">Laos (+856)</option>
                                    <option value="LV" data-countryCode="371">Latvia (+371)</option>
                                    <option value="LB" data-countryCode="961">Lebanon (+961)</option>
                                    <option value="LS" data-countryCode="266">Lesotho (+266)</option>
                                    <option value="LR" data-countryCode="231">Liberia (+231)</option>
                                    <option value="LY" data-countryCode="218">Libya (+218)</option>
                                    <option value="LI" data-countryCode="417">Liechtenstein (+417)</option>
                                    <option value="LT" data-countryCode="370">Lithuania (+370)</option>
                                    <option value="LU" data-countryCode="352">Luxembourg (+352)</option>
                                    <option value="MO" data-countryCode="853">Macao (+853)</option>
                                    <option value="MK" data-countryCode="389">Macedonia (+389)</option>
                                    <option value="MG" data-countryCode="261">Madagascar (+261)</option>
                                    <option value="MW" data-countryCode="265">Malawi (+265)</option>
                                    <option value="MY" data-countryCode="60">Malaysia (+60)</option>
                                    <option value="MV" data-countryCode="960">Maldives (+960)</option>
                                    <option value="ML" data-countryCode="223">Mali (+223)</option>
                                    <option value="MT" data-countryCode="356">Malta (+356)</option>
                                    <option value="MH" data-countryCode="692">Marshall Islands (+692)</option>
                                    <option value="MQ" data-countryCode="596">Martinique (+596)</option>
                                    <option value="MR" data-countryCode="222">Mauritania (+222)</option>
                                    <option value="YT" data-countryCode="269">Mayotte (+269)</option>
                                    <option value="MX" data-countryCode="52">Mexico (+52)</option>
                                    <option value="FM" data-countryCode="691">Micronesia (+691)</option>
                                    <option value="MD" data-countryCode="373">Moldova (+373)</option>
                                    <option value="MC" data-countryCode="377">Monaco (+377)</option>
                                    <option value="MN" data-countryCode="976">Mongolia (+976)</option>
                                    <option value="MS" data-countryCode="1664">Montserrat (+1664)</option>
                                    <option value="MA" data-countryCode="212">Morocco (+212)</option>
                                    <option value="MZ" data-countryCode="258">Mozambique (+258)</option>
                                    <option value="MN" data-countryCode="95">Myanmar (+95)</option>
                                    <option value="NA" data-countryCode="264">Namibia (+264)</option>
                                    <option value="NR" data-countryCode="674">Nauru (+674)</option>
                                    <option value="NP" data-countryCode="977">Nepal (+977)</option>
                                    <option value="NL" data-countryCode="31">Netherlands (+31)</option>
                                    <option value="NC" data-countryCode="687">New Caledonia (+687)</option>
                                    <option value="NZ" data-countryCode="64">New Zealand (+64)</option>
                                    <option value="NI" data-countryCode="505">Nicaragua (+505)</option>
                                    <option value="NE" data-countryCode="227">Niger (+227)</option>
                                    <option value="NG" data-countryCode="234">Nigeria (+234)</option>
                                    <option value="NU" data-countryCode="683">Niue (+683)</option>
                                    <option value="NF" data-countryCode="672">Norfolk Islands (+672)</option>
                                    <option value="NP" data-countryCode="670">Northern Marianas (+670)</option>
                                    <option value="NO" data-countryCode="47">Norway (+47)</option>
                                    <option value="OM" data-countryCode="968">Oman (+968)</option>
                                    <option value="PW" data-countryCode="680">Palau (+680)</option>
                                    <option value="PA" data-countryCode="507">Panama (+507)</option>
                                    <option value="PG" data-countryCode="675">Papua New Guinea (+675)</option>
                                    <option value="PY" data-countryCode="595">Paraguay (+595)</option>
                                    <option value="PE" data-countryCode="51">Peru (+51)</option>
                                    <option value="PH" data-countryCode="63">Philippines (+63)</option>
                                    <option value="PL" data-countryCode="48">Poland (+48)</option>
                                    <option value="PT" data-countryCode="351">Portugal (+351)</option>
                                    <option value="PR" data-countryCode="1787">Puerto Rico (+1787)</option>
                                    <option value="QA" data-countryCode="974">Qatar (+974)</option>
                                    <option value="RE" data-countryCode="262">Reunion (+262)</option>
                                    <option value="RO" data-countryCode="40">Romania (+40)</option>
                                    <option value="RU" data-countryCode="7">Russia (+7)</option>
                                    <option value="RW" data-countryCode="250">Rwanda (+250)</option>
                                    <option value="SM" data-countryCode="378">San Marino (+378)</option>
                                    <option value="ST" data-countryCode="239">Sao Tome &amp; Principe (+239)</option>
                                    <option value="SA" data-countryCode="966">Saudi Arabia (+966)</option>
                                    <option value="SN" data-countryCode="221">Senegal (+221)</option>
                                    <option value="CS" data-countryCode="381">Serbia (+381)</option>
                                    <option value="SC" data-countryCode="248">Seychelles (+248)</option>
                                    <option value="SL" data-countryCode="232">Sierra Leone (+232)</option>
                                    <option value="SG" data-countryCode="65">Singapore (+65)</option>
                                    <option value="SK" data-countryCode="421">Slovak Republic (+421)</option>
                                    <option value="SI" data-countryCode="386">Slovenia (+386)</option>
                                    <option value="SB" data-countryCode="677">Solomon Islands (+677)</option>
                                    <option value="SO" data-countryCode="252">Somalia (+252)</option>
                                    <option value="ZA" data-countryCode="27">South Africa (+27)</option>
                                    <option value="ES" data-countryCode="34">Spain (+34)</option>
                                    <option value="LK" data-countryCode="94">Sri Lanka (+94)</option>
                                    <option value="SH" data-countryCode="290">St. Helena (+290)</option>
                                    <option value="KN" data-countryCode="1869">St. Kitts (+1869)</option>
                                    <option value="SC" data-countryCode="1758">St. Lucia (+1758)</option>
                                    <option value="SD" data-countryCode="249">Sudan (+249)</option>
                                    <option value="SR" data-countryCode="597">Suriname (+597)</option>
                                    <option value="SZ" data-countryCode="268">Swaziland (+268)</option>
                                    <option value="SE" data-countryCode="46">Sweden (+46)</option>
                                    <option value="CH" data-countryCode="41">Switzerland (+41)</option>
                                    <option value="SI" data-countryCode="963">Syria (+963)</option>
                                    <option value="TW" data-countryCode="886">Taiwan (+886)</option>
                                    <option value="TJ" data-countryCode="7">Tajikstan (+7)</option>
                                    <option value="TH" data-countryCode="66">Thailand (+66)</option>
                                    <option value="TG" data-countryCode="228">Togo (+228)</option>
                                    <option value="TO" data-countryCode="676">Tonga (+676)</option>
                                    <option value="TT" data-countryCode="1868">Trinidad &amp; Tobago (+1868)</option>
                                    <option value="TN" data-countryCode="216">Tunisia (+216)</option>
                                    <option value="TR" data-countryCode="90">Turkey (+90)</option>
                                    <option value="TM" data-countryCode="7">Turkmenistan (+7)</option>
                                    <option value="TM" data-countryCode="993">Turkmenistan (+993)</option>
                                    <option value="TC" data-countryCode="1649">Turks &amp; Caicos Islands (+1649)</option>
                                    <option value="TV" data-countryCode="688">Tuvalu (+688)</option>
                                    <option value="UG" data-countryCode="256">Uganda (+256)</option>
                                    <option value="GB" data-countryCode="44">UK (+44)</option>
                                    <option value="UA" data-countryCode="380">Ukraine (+380)</option>
                                    <option value="AE" data-countryCode="971">United Arab Emirates (+971)</option>
                                    <option value="UY" data-countryCode="598">Uruguay (+598)</option>
                                    <option value="US" data-countryCode="1">USA (+1)</option>
                                    <option value="UZ" data-countryCode="7">Uzbekistan (+7)</option>
                                    <option value="VU" data-countryCode="678">Vanuatu (+678)</option>
                                    <option value="VA" data-countryCode="379">Vatican City (+379)</option>
                                    <option value="VE" data-countryCode="58">Venezuela (+58)</option>
                                    <option value="VN" data-countryCode="84">Vietnam (+84)</option>
                                    <option value="VG" data-countryCode="84">Virgin Islands - British (+1284)</option>
                                    <option value="VI" data-countryCode="84">Virgin Islands - US (+1340)</option>
                                    <option value="WF" data-countryCode="681">Wallis &amp; Futuna (+681)</option>
                                    <option value="YE" data-countryCode="969">Yemen (North)(+969)</option>
                                    <option value="YE" data-countryCode="967">Yemen (South)(+967)</option>
                                    <option value="ZM" data-countryCode="260">Zambia (+260)</option>
                                    <option value="ZW" data-countryCode="263">Zimbabwe (+263)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="country_phone_code">Country Code</label>
                                <input type="text" class="form-control" id="country_phone_code"
                                    placeholder="Country Phone Code" v-model="country_phone_code" />
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" placeholder="Phone Number"
                                    v-model="phone_number" />
                            </div>
                            <div v-if="showError" class="invalid-feedback-partner-add">
                                {{ error.message }}
                            </div>
                            <button type="submit" class="btn bg-gradient-success" @click.prevent="updatePartner()">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                Update Partner
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useRoute } from "vue-router";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";
export default {
    inheritAttrs: false,

    setup() {
        const route = useRoute();
        const paramId = route.params.id;
        const name = ref('');
        const state_province = ref('');
        const country_code = ref('');
        const code = ref('');

        const address_1 = ref('');
        const address_2 = ref('');
        const city = ref('');
        const partner_id = ref('');
        const postal_code = ref('');

        const partner_type = ref('');
        const country_phone_code = ref('');
        const phone_number = ref('');



        const showError = ref();
        const snackbar = ref();
        const active = ref(true);

        const error = {};
        error.message = '';
        //get school info
        var newApiUrl =
            store.state.apiUrl + "partner/" + paramId;

        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            partner_id.value = paramId;
            name.value = result.data.partner.name;
            partner_type.value = result.data.partner.type;
            country_phone_code.value = result.data.partner.country_phone_code;
            phone_number.value = result.data.partner.phone_number;
            address_1.value = result.data.partner.address_1;
            address_2.value = result.data.partner.address_2;
            city.value = result.data.partner.city;
            state_province.value = result.data.partner.state_province;
            country_code.value = result.data.partner.country_code;
            postal_code.value = result.data.partner.postal_code;
            console.log(result.data);
            console.log(result.data.partner.country_code);

        }).catch(e => {


            console.error(e)
        })

        return {
            showError,
            error,
            name,
            partner_type,
            country_phone_code,
            phone_number,
            address_1,
            address_2,
            city,
            state_province,
            country_code,
            partner_id,
            postal_code,
            code,
            snackbar,
            active
        }

    },
    components: {
        VsudAlert,
        VsudSnackbar,
    },
    methods: {
        closeSnackbar() {
            this.snackbar = null;
        },
        updatePhoneNumber() {

            let selIndex = this.$refs.country_code2.options.selectedIndex;

            this.country_phone_code = this.$refs.country_code2.options[selIndex].getAttribute('data-countrycode');

            this.selected_country_code = this.$refs.country_code2.value;

            console.log(this.$refs.country_code2.options[selIndex].getAttribute('data-countrycode'));

            console.log(this.$refs.country_code2.options[selIndex].value);


        },
        updatePartner() {
            var newApiUrl =
                this.$store.state.apiUrl + "partner/" + this.partner_id;
            axios
                .put(
                    newApiUrl,
                    {
                        name: this.name,
                        address_1: this.address_1,
                        address_2: this.address_2,
                        city: this.city,
                        state_province: this.state_province,
                        country_code: this.country_code,
                        postal_code: this.postal_code,
                        phone_number: this.phone_number,
                        country_phone_code: this.country_phone_code,
                        type: this.partner_type
                    },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                            Authorization: "Bearer " + localStorage.token,
                        },
                    }
                )
                .then((r) => {
                    const result = r.data;

                    console.log(result);

                    this.snackbar = "info";

                    if (this.formdata.partner_type == 'Inbound') {

                        this.$router.push({ path: "/partners/inbound/view", replace: true });

                    }
                    else {

                        this.$router.push({ path: "/partners/outbound/view", replace: true });

                    }
                })
                .catch((e) => {
                    console.log(e);
                    this.showError = true;
                    this.error.message = e.response.data.message;
                    this.snackbar = "warning";
                });
        },
    },
};
</script>
<style>
.invalid-feedback2 {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}
</style>
