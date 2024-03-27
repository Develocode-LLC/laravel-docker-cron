<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Add New User</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to add a new Live N Learn User
                        </p>
                    </div>
                    <div class="row" style="margin:10px;">
                        <form @submit.prevent="submit">
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" placeholder="First Name" v-model="formdata.fname"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="fname">Last Name</label>
                                <input type="text" class="form-control" id="lname" placeholder="Last Name" v-model="formdata.lname"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" v-model="formdata.email"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" readonly class="form-control" id="username" placeholder="Username" v-model="formdata.email"
                                    required>
                            </div>


                            <div class="form-group">
                                <label for="admin_password">Password</label>
                                <input type="password" class="form-control" id="admin_password" placeholder="Password"
                                    v-model="formdata.password" required>
                            </div>


                            <div class="form-group">
                                <label for="admin_cpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="admin_cpassword"
                                    placeholder="Confirm Password" v-model="formdata.password_confirmation" required>
                            </div>



                            <div class="form-group">
                                <label for="location_type">User Type</label>
                                <select class="form-select" id="location_type" v-model="formdata.class" required>
                                    <option value="Select Type">Select Type</option>
                                    <option value="administrator">Admin</option>
                                    <option value="local_coordinator">Local Coordinator</option>
                                    <option value="traveler">Outbound Travelers</option>
                                    <option value="host_family">Host Family</option>
                                    <option value="group_leader">Group Leader</option>
                                    <option value="inbound_partner">Inbound Partner</option>
                                    <option value="outbound_partner">Outbound Partner</option>


                                </select>
                            </div>

                            <div v-if="showError" class="invalid-feedback2">{{ error.message }}</div>

                            <button type="submit" class="btn bg-gradient-success" @click.prevent="addAdmin()"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Add
                                User</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { DataTable } from "simple-datatables";
import axios from "axios";

export default {
    name: "DataTables",
    data() {
        return {
            showError: false,
            error: {
                message: ''
            },
            formdata: {
                fname: '',
                lname: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
                class: 'Select Type'
            }

        }

    },
    methods: {
        addAdmin() {
            var newApiUrl = this.$store.state.apiUrl + 'user';
            axios.post(newApiUrl, {
                first_name: this.formdata.fname,
                last_name: this.formdata.lname,
                email: this.formdata.email,
                email_confirmation: this.formdata.email,
                password: this.formdata.password,
                password_confirmation: this.formdata.password_confirmation,
                eats_seafood: 0,
                follows_diet: 0,
                rides_bike: 0,
                class: this.formdata.class,
                metadata: []
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    Authorization: 'Bearer ' + localStorage.token
                }
            }).then(r => {
                const result = r.data;

                console.log(result);

                this.$router.push({ path: '/admins/all', replace: true });

            }).catch(e => {
                console.log(e.message);
                console.error(e.response.data);
                this.showError = true;
                this.error.message = e.response.data.message;
            })

        }

    }

    ,
    mounted() {
        // eslint-disable-next-line no-unused-vars

    },
};
</script>
<style>
.invalid-feedback2 {
    width: 100%;
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;
}
</style>
