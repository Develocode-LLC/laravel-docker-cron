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
                                <button v-if="class_type != 'administrator'" type="button" class="btn bg-gradient-danger float-end" 
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
                                    class="fa fa-users" aria-hidden="true"></i> Details</a>
                            <a v-on:click="activetab = '2'" v-bind:class="[activetab === '2' ? 'active' : '']"><i
                                    class="fa fa-plane" aria-hidden="true"></i> Program History</a>
                            <a v-on:click="activetab = '3'" v-bind:class="[activetab === '3' ? 'active' : '']"><i
                                    class="fa fa-envelope" aria-hidden="true"></i> Comment Log
                            </a>

                        </div>

                        <div class="content">
                            <div v-if="activetab === '1'" class="tabcontent">
                                <div class="row" style="margin:10px;">
                                    <h4 class="capitalize">{{ class_type_name }}  Details</h4>

                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input readonly type="text" class="form-control" id="fname" placeholder="First Name"
                                            v-model="fname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="fname">Last Name</label>
                                        <input readonly type="text" class="form-control" id="lname" placeholder="Last Name"
                                            v-model="lname" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input readonly type="email" class="form-control" id="email" placeholder="Email"
                                            v-model="email" required>
                                    </div>

                                </div>
                            </div>
                            <div v-if="activetab === '2'" class="tabcontent">
                                <div class="table-responsive">
                                    <h4>Program History</h4>
                                    <table id="datatable-search" class="table table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Program</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-sm font-weight-normal"><a href="#">Yaw Tandoh</a></td>
                                                <td class="text-sm font-weight-normal"><a href="#">Experience Spain like
                                                        never before</a>
                                                </td>
                                                <td class="text-sm font-weight-normal">2024-03-01</td>
                                                <td class="text-sm font-weight-normal">2024-03-22</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="activetab === '3'" class="tabcontent">
                                <div class="row">
                                    <h4>Comment Log</h4>
                                    <div class="form-group">

                                    </div>
                                </div>
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
import axios from "axios";
import store from "@/store/index.js";
import { ref } from 'vue';
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";
import bootstrap from "bootstrap/dist/js/bootstrap";

export default {
    props: ['id'],
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
    setup(props) {
        let tripList = ref([]);
        let tripsRows = Array();

        const activetab = ref('1');

        const fname = ref('');
        const lname = ref('');
        const email = ref('');
        const class_type = ref('');
        const class_type_name = ref('');

        //get user info
        var newApiUrl = store.state.apiUrl + 'user/' + props.id;
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(result => {
            console.log(result.data);
            fname.value = result.data.user.first_name;
            lname.value = result.data.user.last_name;
            email.value = result.data.user.email;
            class_type.value = result.data.user.class;
            class_type_name.value = result.data.user.class.replace('_', ' ');

        }).catch(e => {
            console.error(e)
        })

        return {
            activetab: '1',
            activetab,
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
