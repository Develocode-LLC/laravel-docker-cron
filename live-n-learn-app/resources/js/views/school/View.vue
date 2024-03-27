<template>
    <div class="py-4 container-fluid">

        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Live N Learn Schools</h5>

                    </div>
                    <div class="row ml-2">
                        <div class="col-4">
                            <a class="btn btn-success" href="/school/add"><i class="fa fa-plus" aria-hidden="true"></i> Add New School</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable-schools" class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>School</th>
                                    <th>School ID</th>

                                    <th></th>


                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.ml-2 {
    margin-left: 20px !important;
  }
</style>


<script>
import { DataTable } from "simple-datatables";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from 'vue';


export default {
    name: "DataTables",
    inheritAttrs: false,
    setup() {

        let schoolsList = ref([]);
        let schools = [];
        let schoolRows = Array();

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

            result.data.schools.forEach(function (schoolItem) {

                let linkBtn = '<a class="btn btn-success" href="/school/' + schoolItem.id + '"><i class="fa fa-school" aria-hidden="true"></i> View Details</a>';

                // let delBtn = '<a class="btn btn-warning" href="#school/' + schoolItem.id + '"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';

                let rowArray = new Array(schoolItem.name, schoolItem.code, linkBtn);

                try {
                    schoolRows.push(rowArray);
                }
                catch (err) {
                    console.log(err.message);
                }


            });

            const dataTableSearch = new DataTable("#datatable-schools", {
                searchable: true,
                fixedHeight: true,
            });

            try {
                dataTableSearch.insert({ data: schoolRows });
            }
            catch (err) {
                console.log(err.message);
            }





        }).catch(e => {


            console.error(e)
        })



        return {
            schoolsList,
            schools,
            schoolRows
        }


    },
    methods: {




    }
    ,
    mounted() {


    },
};
</script>


