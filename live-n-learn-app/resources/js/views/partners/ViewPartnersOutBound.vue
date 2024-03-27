<template>
    <div class="py-4 container-fluid">

        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Live N Learn - OutBound - Partners</h5>

                    </div>
                    <div class="row ml-2">
                        <div class="col-4">
                            <a class="btn btn-success" href="/partners/add"><i class="fa fa-plus" aria-hidden="true"></i>
                                Add New Partner</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable-partners" class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Partner Name</th>
                                    <th>Country</th>

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
        let partnerRows = Array();

        //get partners list
        var newApiUrl = store.state.apiUrl + 'partner';
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            console.log(result);

            result.data.partners.forEach(function (partnerItem) {
                if ((partnerItem.type == 'Outbound') || (partnerItem.type == 'Both')) {

                    let linkBtn = '<a class="btn btn-success" href="/partners/' + partnerItem.id + '"><i class="fa fa-users" aria-hidden="true"></i> View Details</a>';

                    let rowArray = new Array(partnerItem.name, partnerItem.country_code, linkBtn);

                    try {
                        partnerRows.push(rowArray);
                    }
                    catch (err) {
                        console.log(err.message);
                    }
                }


            });

            const dataTableSearch = new DataTable("#datatable-partners", {
                searchable: true,
                fixedHeight: true,
            });

            try {
                dataTableSearch.insert({ data: partnerRows });
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
            partnerRows
        }


    },
    methods: {




    }
    ,
    mounted() {


    },
};
</script>


