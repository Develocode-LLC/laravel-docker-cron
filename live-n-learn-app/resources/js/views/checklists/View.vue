<template>
    <div class="py-4 container-fluid">

      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Live N Learn - Forms</h5>

            </div>
            <div class="table-responsive">
              <table id="datatable-search" class="table table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Name</th>
                    <th>Option Type</th>
                    <th></th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-sm font-weight-normal">Passport</td>
                    <td class="text-sm font-weight-normal">Document Upload</td>
                    <td><a class="btn btn-success" href="#checklist/1">View/Edit Details</a></td>
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
