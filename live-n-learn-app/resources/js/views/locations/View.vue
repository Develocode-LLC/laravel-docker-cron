<template>
  <div class="py-4 container-fluid">

    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Live N Learn Locations</h5>

          </div>
          <div class="table-responsive">
            <table id="datatable-locations" class="table table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Location</th>
                  <th>State/Province</th>
                  <th>Country</th>
                  <th></th>
                  <th></th>

                </tr>
              </thead>
              <!-- <tbody>
                <tr v-for="(row, index) in locationsList" :key="index">
                  <td class="text-sm font-weight-normal">{{ row.name }}</td>
                  <td class="text-sm font-weight-normal">{{ row.state_province }}</td>
                  <td class="text-sm font-weight-normal"> {{ row.country }}</td>

                  <td class="text-sm font-weight-normal"><a class="btn btn-success"
                      v-bind:href="'#locations/' + row.id + ''"><i class="fa fa-map-marker" aria-hidden="true"></i> View Details</a></td>
                      <td class="text-sm font-weight-normal"><a class="btn btn-warning" @click="removeLocation(row.id);"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></td>
                </tr>
              </tbody> -->
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
import { ref } from 'vue';


export default {
  name: "DataTables",
  inheritAttrs: false,
  setup() {

    let locationsList = ref([]);
    let locations = [];
    let locationRows = Array();

    //get locations list
    var newApiUrl = store.state.apiUrl + 'location';
    axios.get(newApiUrl, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.token
      }
    }).then(r => {
      const result = r;

      result.data.locations.forEach(function (locationItem) {

        let linkBtn = '<a class="btn btn-success" href="/locations/' + locationItem.id + '"><i class="fa fa-map-marker" aria-hidden="true"></i> View Details</a>';

        let delBtn = '<a class="btn btn-warning" href="/locations/' + locationItem.id + '"><i class="fa fa-trash" aria-hidden="true"></i> Deactivate</a>';

        let rowArray = new Array(locationItem.name, locationItem.state_province, locationItem.country, linkBtn, delBtn);

        try {
          locationRows.push(rowArray);
        }
        catch (err) {
          console.log(err.message);
        }


      });

      const dataTableSearch = new DataTable("#datatable-locations", {
        searchable: true,
        fixedHeight: true,
      });

      try {
        dataTableSearch.insert({ data: locationRows });
      }
      catch (err) {
        console.log(err.message);
      }





    }).catch(e => {


      console.error(e)
    })



    return {
      locationsList,
      locations,
      locationRows
    }


  },
  methods: {

    removeLocation(id) {
      confirm("Are you sure you want to disable " + id + "?. Feature coming soon!");
      return false;

    }


  }
  ,
  mounted() {


  },
};
</script>


