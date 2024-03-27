<template>
    <div class="mt-4 row">
        <div class="col-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-0 capitalize">View {{ class_type_name }} Details</h5>
                                <p class="mb-0 text-sm capitalize">
                                    Use this tool to view/edit {{ class_type_name }} Details
                                </p>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn bg-gradient-danger float-end" 
                                    data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                >
                                    <i class="fa fa-user-slash" aria-hidden="true"></i> Delete User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:10px;">
                    <div id="tabs" class="container">

                        <div class="tabs">
                            <a v-on:click="activetab = '1'" v-bind:class="[activetab === '1' ? 'active' : '']"><i
                                    class="fa fa-users" aria-hidden="true"></i> Primary Details</a>
                            <a v-on:click="activetab = '2'" v-bind:class="[activetab === '2' ? 'active' : '']"><i
                                    class="fa fa-mobile" aria-hidden="true"></i> Contact Information</a>
                            <a v-on:click="activetab = '5'" v-bind:class="[activetab === '5' ? 'active' : '']"><i
                                    class="fa fa-users" aria-hidden="true"></i> Emergency Contact Information
                            </a>


                            <a v-on:click="activetab = '6'" v-bind:class="[activetab === '6' ? 'active' : '']"><i
                                    class="fa fa-home" aria-hidden="true"></i> Hosting Program Details
                            </a>

                            <a v-on:click="activetab = '7'" v-bind:class="[activetab === '7' ? 'active' : '']"><i
                                    class="fa fa-history" aria-hidden="true"></i> Program History
                            </a>

                        </div>

                        <div class="content">
                            <div v-if="activetab === '1'" class="tabcontent">
                                <div class="row" style="margin:10px;">
                                    <h4 class="capitalize">{{ class_type_name }} Details</h4>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="fname">First Name</label>
                                                <input type="text" class="form-control" id="fname" placeholder="First Name"
                                                    v-model="fname" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="mname">Middle Name</label>
                                                <input type="text" class="form-control" id="mname" placeholder="Middle Name"
                                                    v-model="mname" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="fname">Last Name</label>
                                                <input type="text" class="form-control" id="lname" placeholder="Last Name"
                                                    v-model="lname" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of Birth:</label>
                                                <input type="date" class="form-control" id="date_of_birth"
                                                    onfocus="this.showPicker()" v-model="date_of_birth"
                                                    placeholder="Date of Birth" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="gender">Gender as it appears on your legal documents</label>
                                                <select class="form-select" id="gender" v-model="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="gender_identity">Gender Indentity</label>
                                                <select class="form-select" id="gender_identity" v-model="gender_identity">
                                                    <option value="">Select Gender</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Non-Binary">Non-Binary</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group" v-if="gender_identity == 'Other'">
                                                <label for="gender_identity_other">Other</label>
                                                <input type="text" class="form-control" id="gender_identity_other"
                                                    placeholder="Other" v-model="gender_identity_other">
                                            </div>
                                        </div>



                                    </div>

                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="current_teacher_school_district">Are you currently a teacher or
                                                    working within a school district?</label>
                                                <select class="form-select" id="current_teacher_school_district"
                                                    v-model="current_teacher_school_district">
                                                    <option value="">Select</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3" v-if="current_teacher_school_district == 'Yes'">
                                            <div class="form-group">
                                                <label for="school_name">What is the name of your school?</label>
                                                <input type="text" class="form-control" id="school_name"
                                                    placeholder="Enter School" v-model="school_name" required>
                                            </div>
                                        </div>

                                        <div class="col-3" v-if="current_teacher_school_district == 'Yes'">
                                            <div class="form-group">
                                                <label for="school_district_name">What is the name of the district?</label>
                                                <input type="text" class="form-control" id="school_district_name"
                                                    placeholder="Enter District" v-model="school_district_name" required>
                                            </div>
                                        </div>


                                        <div class="col-3" v-if="current_teacher_school_district == 'Yes'">
                                            <div class="form-group">
                                                <label for="school_district_live_in">What school district do you currently
                                                    live in?</label>
                                                <input type="text" class="form-control" id="school_district_live_in"
                                                    placeholder="Enter District" v-model="school_district_live_in" required>
                                            </div>
                                        </div>
                                    </div>





                                </div>
                            </div>
                            <div v-if="activetab === '2'" class="tabcontent">
                                <div class="table-responsive">
                                    <h4>Contact Information</h4>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="School_address_1">Home Address 1</label>
                                            <input type="text" class="form-control" id="School_address_1"
                                                placeholder="Address 1" v-model="address_1" />
                                        </div>
                                        <div class="form-group">
                                            <label for="School_address_2">Address 2</label>
                                            <input type="text" class="form-control" id="School_address_2"
                                                placeholder="Address 2" v-model="address_2" />
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" id="ity" placeholder="City"
                                                        v-model="city" />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="state">State/Province</label>
                                                    <input type="text" class="form-control" id="state" placeholder="State"
                                                        v-model="state_province" />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="postal_code">Postal Code</label>
                                                    <input type="text" class="form-control" id="postal_code"
                                                        placeholder="Postal Code" v-model="postal_code" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country_code">Country</label>
                                            <select class="form-select" id="country_code" v-model="country_code">
                                                <option>Select Country</option>

                                                <option value="AF">Afghanistan</option>
                                                <option value="AX">�land Islands</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia, Plurinational State of</option>
                                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, the Democratic Republic of the</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">C�te d'Ivoire</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Cura�ao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran, Islamic Republic of</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao</option>
                                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PS">Palestinian Territory, Occupied</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">R�union</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="BL">Saint Barth�lemy</option>
                                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="MF">Saint Martin (French part)</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SX">Sint Maarten (Dutch part)</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands, British</option>
                                                <option value="VI">Virgin Islands, U.S.</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="city">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    placeholder="Phone Number" v-model="phone_number" />
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="state">Email Address</label>
                                                <input type="email" class="form-control" id="email" placeholder="Email"
                                                    v-model="email">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="postal_code">T-Shirt Size</label>
                                                <select class="form-select" id="t_shirt_size" v-model="t_shirt_size">
                                                    <option value="">Select Size</option>
                                                    <option value="XS">XS</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                    <option value="XL">XL</option>
                                                    <option value="XXL">XXL</option>
                                                    <option value="3XL">3XL</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div v-if="activetab === '3'" class="tabcontent">
                                <div class="row">
                                    <h4>Medical Information/Dietary Preferences</h4>
                                    <div class="form-group">
                                        <label for="health_medical_information">Health/Medical Information</label>
                                        <textarea class="form-control" id="health_medical_information" rows="5"
                                            placeholder="Health/Medical Information"
                                            v-model="health_medical_information"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="dietary_preferences">Dietary Preferences</label>
                                        <textarea class="form-control" id="dietary_preferences" rows="5"
                                            placeholder="Dietary Preferences" v-model="dietary_preferences"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="diets">Do you follow any of the diets below?</label>
                                                <select class="form-select" id="diets" v-model="diets">
                                                    <option value="">Select</option>
                                                    <option value="Vegetarian">Vegetarian</option>
                                                    <option value="Pescatarian">Pescatarian</option>
                                                    <option value="Vegan">Vegan</option>
                                                    <option value="Other">Other</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="diet_other">Other</label>
                                                <input type="text" class="form-control" id="diet_other" placeholder="Other"
                                                    v-model="diet_other">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="eat_seafood">Do you eat seafood?</label>
                                                <select class="form-select" id="eat_seafood" v-model="eat_seafood">
                                                    <option value="">Select</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="I eat some, but not all seafood">I eat some, but not all
                                                        seafood</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="seafood_other">Other</label>
                                                <input type="text" class="form-control" id="seafood_other"
                                                    placeholder="Other" v-model="seafood_other">
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                           

                            <div v-if="activetab === '5'" class="tabcontent">
                                <div class="row">
                                    <h4>Emergency Contact Information</h4>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="emergency_contact_name">Emergency Contact Name:</label>
                                                <input type="text" class="form-control" id="emergency_contact_name"
                                                    v-model="emergency_contact_name" placeholder="Emergency Contact Name">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                                                <input type="text" class="form-control" id="emergency_contact_phone"
                                                    v-model="emergency_contact_phone" placeholder="Emergency Contact Phone">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="emergency_contact_email">Emergency Contact Email:</label>
                                                <input type="email" class="form-control" id="emergency_contact_email"
                                                    v-model="emergency_contact_email" placeholder="Emergency Contact Email">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="emergency_contact_relationship">Relationship to
                                                    Traveler:</label>
                                                <input type="text" class="form-control" id="emergency_contact_relationship"
                                                    v-model="emergency_contact_relationship"
                                                    placeholder="Relationship to Traveler">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div v-if="activetab === '6'" class="tabcontent">
                                <div class="row">
                                    <h4>Hosting Program Details</h4>

                                    <div class="row">


                                        <div class="table-responsive">
                                            <table id="trips-search" class="table table-flush">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Program Location</th>
                                                        <th>Assigned Number of Participants</th>
                                                        <th>Assigned Schools</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                </div>


                            </div>

                        </div>

                        <div v-if="activetab === '7'" class="tabcontent">




                        </div>

                        <div class="row mt-2">
                            <div class="col-4">

                                <button type="button" @click="updateTraveler()" class="btn bg-gradient-success">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    Update Details
                                </button>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure want to delete this user?
                <input type="hidden" class="form-control" id="user_id" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn bg-gradient-primary" @click="confirmDelete()">Confirm</button>
            </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Import Google Font */
@import url(https://fonts.googleapis.com/css?family=Nunito+Sans);

h1,
h2,
h3,
h4 {

    font-family: 'Montserrat' !important;

}

/* RESET */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 620px;
    min-width: 420px;
    margin: 40px auto;
    font-family: "Nunito Sans", Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    color: #888;
}

/* Style the tabs */
.tabs {
    overflow: hidden;
    margin-bottom: -2px;
    /* hide bottom border */
    margin-left: 24px;
}

.tabs a {
    float: left;
    cursor: pointer;
    padding: 0.65em 0.65em !important;
    transition: background-color 0.2s;
    border: 1px solid #ccc;
    border-right: none;
    background-color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    font-weight: bold;
}

.tabs a:last-child {
    border-right: 1px solid #ccc;
}

/* Change background color of tabs on hover */
.tabs a:hover {
    background-color: #aaa;
    color: #fff;
}

/* Styling for active tab */
.tabs a.active {
    background-color: #fff;
    color: #484848;
    border-bottom: 2px solid #fff;
    cursor: default;
}

/* Style the tab content */
.tabcontent {
    padding: 30px 50px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 4px 4px 8px #e1e1e1
}

.tabcontent td {
    padding: 0.3em 0.4em;
    color: #484848;
}

.tabcontent td.legend {
    color: #888;
    font-weight: bold;
    text-align: right;
}

.capitalize {
    text-transform: capitalize;
}

.tabcontent .map {
    height: 173px;
    width: 220px;
    background: #D3EAFB;
    margin-left: 60px;
    border: 1px solid #ccc;
    border-radius: 10px;
}

.data {
    width: 120px;
}
</style>

<script>
import { useRoute } from "vue-router";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";
import bootstrap from "bootstrap/dist/js/bootstrap";

export default {
    el: '#tabs',
    inheritAttrs: false,
    components: {
        VsudAlert,
        VsudSnackbar,
    },
    data() {
        return {
            activetab: '1',
            snackbar: null,
        }
    },
    setup() {
        //console.log(props.id);
        let tripList = ref([]);
        let tripsRows = Array();

        const activetab = ref('1');

        const fname = ref('');
        const lname = ref('');
        const email = ref('');
        const grade_level_at_time_of_travel = ref('');
        const current_teacher_school_district = ref('');
        const school = ref('');
        const traveler_type = ref('');
        const gender = ref('');
        const gender_identity = ref('');
        const preferred_pronouns = ref('');
        const host_family_request = ref(false);
        const class_type = ref('');
        let schoolList = ref([]);
        const class_type_name = ref('');
        const route = useRoute();


        console.log(route.params);

        const paramId = route.params.id;

        //get user info
        var newApiUrl = store.state.apiUrl + 'user/' + paramId;
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;
            console.log(result.data);
            fname.value = result.data.user.first_name;
            lname.value = result.data.user.last_name;
            email.value = result.data.user.email;
            class_type.value = result.data.user.class;
            class_type_name.value = result.data.user.class.replace('_', ' ');

        }).catch(e => {


            console.error(e)
        })

        //get schools list
        var newApiUrl = store.state.apiUrl + 'school';
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            result.data.schools.forEach((item, index) => {
                schoolList.value.push({ id: item.code, name: item.name });



            })


        }).catch(e => {


            console.error(e)
        })


        return {
            activetab: '1',
            gender,
            gender_identity,
            current_teacher_school_district,
            preferred_pronouns,
            activetab,
            schoolList,
            host_family_request,
            grade_level_at_time_of_travel,
            school,
            traveler_type,
            fname,
            lname,
            email,
            class_type,
            class_type_name
        }

    },
    methods: {
        closeSnackbar() {
            this.snackbar = null;
        },
        capitalizeEachWord(str) {
            return str.replace(/\w\S*/g, function (txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        },
        async deleteUser() {
            let user_id = this.$route.params.id;
            var newApiUrl = store.state.apiUrl + 'user/' + user_id;

            await axios.delete(newApiUrl, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(result => {

            }).catch(error => {
                console.error(error)
            })
        },
        async confirmDelete() {

            await this.deleteUser()

            var myModalEl = document.getElementById('deleteUserModal')
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide()

            this.$router.go(-1)
        },
    },
    mounted() {

    },
};
</script>
