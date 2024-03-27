<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Update Form</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to update a Form for Live N' Learn
                        </p>
                    </div>
                    <div class="row" style="margin:10px;">
                        <form>
                            <div class="form-group">
                                <label for="location">Checklist Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Checklist Name"
                                    v-model="formdata.name">
                            </div>
                            <div class="form-group">
                                <label for="checklist_description">Description/Label</label>
                                <textarea class="form-control" id="checklist_description" rows="3"
                                    placeholder="Enter Description/Label here" v-model="formdata.description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="country">Checklist Type:</label>
                                <select class="form-select" id="type" v-model="formdata.type">
                                    <option value="">Select Type</option>
                                    <option value="Document Upload">Document Upload</option>
                                    <option value="Radio Buttons">Radio Buttons</option>
                                    <option value="Check Box">Check Box</option>
                                    <option value="Text">Text</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Label Options</label>
                            </div>

                            <div class="form-group">
                                <button @click="addOptions()" type="button" class="btn bg-gradient-success"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Add New Label</button>
                            </div>




                            <div class="row" v-for="(option, index) in formdata.options">
                                <div class="col-8">
                                    <div class="form-group">

                                        <input type="text" class="form-control" v-model="option.option"
                                            placeholder="Enter Option Label">

                                    </div>
                                </div>
                                <div class="col-4 align-bottom">
                                    <div class="form-group">

                                        <button @click="deleteOptions(index)" type="button"
                                            class="btn bg-gradient-warning"><i class="fa fa-minus" aria-hidden="true"></i>
                                            Delete</button>
                                    </div>
                                </div>

                            </div>



                            <button @click="updateChecklist" type="button" class="btn bg-gradient-success"><i class="fa fa-plus"
                                    aria-hidden="true"></i> Update Form</button>

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
                name: '',
                description: '',
                type: '',
                options: [
                    { option: '' }
                ]
            }

        }

    },
    methods: {
        deleteOptions(index) {
            console.log(index);
            this.formdata.options.splice(index, 1);
            if (index === 0)
                this.addOptions()
        },
        addOptions() {
            this.formdata.options.push({ option: '' });
        },
        updateChecklist() {

            console.log(this.$store.state.apiUrl);
            console.log(this.formdata);
            var newApiUrl = this.$store.state.apiUrl + 'checklist';
            axios.post(newApiUrl, {
                name: this.formdata.name,
                description: this.formdata.description,
                type: this.formdata.type,
                options: this.formdata.options
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(r => {
                const result = r.data;

                console.log(result);

                this.$router.push({ path: '/checklist/view', replace: true });

            }).catch(e => {
                console.log(e.message);
                console.error(e.response.data);
            })

        }

    }

    ,
    mounted() {
        // eslint-disable-next-line no-unused-vars

    },
};
</script>
