<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn - Reports</h5>
          </div>
          <div class="table-responsive">
            <table id="datatable-search" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Report Title</th>
                  <th>Generation Date</th>
                  <th>User Generated</th>
                  <th>Report Type</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-sm font-weight-normal">
                    <a href="#">Example Report</a>
                  </td>
                  <td class="text-sm font-weight-normal">03/04/2024</td>
                  <td class="text-sm font-weight-normal">
                    Marcus@develocode.com
                  </td>
                  <td class="text-sm font-weight-normal">Trip</td>
                  <td>
                    <a class="btn btn-success" href="/messaging/1"
                      >View Report</a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
import { DataTable } from "simple-datatables";

export default {
  name: "DataTables",
  mounted() {
    // eslint-disable-next-line no-unused-vars
    const dataTableSearch = new DataTable("#datatable-search", {
      searchable: true,
      fixedHeight: true,
    });
  },
};
</script>
