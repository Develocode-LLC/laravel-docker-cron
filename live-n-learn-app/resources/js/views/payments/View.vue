<template>
    <div class="py-4 container-fluid">

      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Live N Learn Payments by Program</h5>

            </div>
            <div class="table-responsive">
              <table id="datatable-search" class="table table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Name</th>
                    <th>Origin City</th>
                    <th>Destination</th>

                    <th>Program Date</th>
                    <th>Sign Ups</th>
                    <th>Total Amount Due</th>
                    <th>Total Amount Paid</th>
                    <th></th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-sm font-weight-normal"><a href="#">Destination Paris</a></td>
                    <td class="text-sm font-weight-normal">Cincinnati</td>
                    <td class="text-sm font-weight-normal">Paris</td>
                    <td class="text-sm font-weight-normal">11/01/2023</td>
                    <td class="text-sm font-weight-normal">44</td>
                    <td class="text-sm font-weight-normal">$6450.00</td>
                    <td class="text-sm font-weight-normal">$99.99</td>
                    <td><a class="btn btn-success" href="#payments/1">View Payment Details</a></td>
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
