<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn - Admin Users</h5>
          </div>
          <div class="table-responsive">
            <table id="users-list" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>User Type</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { DataTable } from "simple-datatables";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";

export default {
  name: "ListAdmins",
  setup() {
    let userList = ref([]);

    return {
      userList,
    };
  },
  methods: {
    async fetchUsers() {
      var newApiUrl = store.state.apiUrl + "user?class=administrator";

      await axios
        .get(newApiUrl, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((result) => {
          this.userList = result.data.users;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    async loadDataTable() {
      let userRows = new Array();

      const userDatatable = new DataTable("#users-list", {
        searchable: true,
        fixedHeight: true,
      });

      await this.fetchUsers();

      this.userList.forEach((user) => {
        let class_type = (
          user.class.charAt(0).toUpperCase() + user.class.slice(1)
        ).replace("_", " ");

        let btnViewUser = `<a class="btn bg-gradient-info" href="/admins/${user.id}">
                                        <i class="fa fa-user" aria-hidden="true"></i> View User Details
                                    </a>`;

        let rowArray = new Array(
          class_type,
          user.first_name,
          user.last_name,
          user.email,
          btnViewUser
        );

        userRows.push(rowArray);
      });

      userDatatable.insert({ data: userRows });
    },
  },
  async mounted() {
    await this.loadDataTable();
  },
};
</script>
