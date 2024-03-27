<template>
    <div class="py-4 container-fluid">

      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Live N Learn Outbound Itinerary List</h5>

            </div>

            <div class="row ml-2">
                <div class="col-4">
                    <a class="btn btn-success" href="/itinerary/add"><i class="fa fa-plus" aria-hidden="true"></i> Add New Ininerary</a>
                </div>
            </div>

            <div class="table-responsive">
              <table id="datatable-itinerary" class="table table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>Itinerary Name</th>
                    <th>Itinerary Code</th>
                    <th></th>
                    <th></th>
                    <th></th>
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
    let itineraryRows = Array();

    //get itinerary list
    var newApiUrl = store.state.apiUrl + 'master_itinerary';
    axios.get(newApiUrl, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.token
      }
    }).then(result => {

        console.log(result.data.itineraries);

      result.data.itineraries.forEach(function (itineraryItem) {

        let linkBtn = '<a class="btn btn-success" href="/itinerary/' + itineraryItem.id + '"><i class="fa fa-map-marker" aria-hidden="true"></i> View Details</a>';

        let promptDupText = 'Are you sure you want to duplicate this Itinerary?';

        let dupBtn = '<a class="btn btn-info"  onClick="return confirm(\'' + promptDupText + '\')" href="/itinerary/duplicate/' + itineraryItem.id + '"><i class="fa fa-clone" aria-hidden="true"></i> Duplicate</a>';

        let promptText = 'Are you sure you want to delete this Itinerary?';

        let delBtn = '<a class="btn btn-warning" onClick="return confirm(\'' + promptText + '\')" href="/itinerary/delete/' + itineraryItem.id + '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';

        let rowArray = new Array(itineraryItem.title, itineraryItem.code, linkBtn, dupBtn, delBtn);

        try {
          itineraryRows.push(rowArray);
        }
        catch (err) {
          console.log(err.message);
        }
      });

      const dataTableSearch = new DataTable("#datatable-itinerary", {
        searchable: true,
        fixedHeight: true,
      });

      try {
        dataTableSearch.insert({ data: itineraryRows });
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
      itineraryRows
    }
  },
  methods: { },
  beforeRouteUpdate(to, from, next) {
    if (to.path !== from.path) {
      window.location = to.path;
    }
  },
  mounted() {

    this.$forceUpdate();


  },
};
</script>
<style>
.ml-2 {
    margin-left: 20px !important;
  }
</style>
