<template>
    <div class="py-4 container-fluid">

      <div class="mt-4 row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Live N Learn - Media Gallery</h5>
            </div>
            <p class="mb-0 text-sm ml-1">
                Use this tool to add Images that will be used to add to Trip Itineraries
              </p>
            <div class="row content">

                <div class="row ml-1">
                    <div class="col-6 col-xs-12">
                        <div class="form-group">
                            <label for="image_description" style="display: block">Enter Image Description First</label>
                            <textarea class="form-control" id="image_description" rows="5"
                            placeholder="Description"
                            v-model="image_description"></textarea>
                          </div>
                          <div v-if="showError" class="invalid-feedback2">{{ error.message }}</div>
                      <div class="form-group">
                        <label for="trip_description" style="display: block">Select Photos to Upload to Image Gallery(Multiple files allowed)</label>
                        <input name="file" type="file" placeholder="Upload Photos" multiple @change="onFileSelected" accept="image/*" data-classIcon="icon-plus" data-buttonText="Choose Image to Upload" ref="fileupload" />
                        <!-- <button @click="uploadFiles" type="button" class="btn bg-gradient-success"><i
                                                    class="fa fa-file" aria-hidden="true"></i>
                                                Upload Images</button> -->
                      </div>

                    </div>
                  </div>
                  <div class="row ml-1">
                    <div class="row">
                      <h5>Image Gallery</h5>
                    </div>


                    <div class="row">

                        <div v-for="files in mediaFilesList" class="col-lg-2 col-md-4 col-6">
                        <img :src="files.uri"  class="img-fluid img-thumbnail" :key="files.id" :title="files.description" />
                        <div class="row mx-auto"><small>{{ files.description }}</small></div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                            <button @click="removeFromGallery(files.id)" type="button" class="btn bg-gradient-warning btn-sm me-md-2"><i class="fa fa-trash" aria-hidden="true"></i> Delete </button>
                        </div>
                        </div>


                    </div>

                  </div>

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
import { toast } from "vue3-toastify";

export default {
    name: "DataTables",
    setup() {
        let tripList = ref([]);
        let mediaFilesList = ref([]);

        //get Gallery Images
        var newApiUrl = store.state.apiUrl + "media_file";
        axios
            .get(newApiUrl, {
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${localStorage.token}`,
                },
            })
            .then((result) => {

                console.log('All Media');
                //console.log(result.data);

                result.data.media_files.forEach(item => {
                    console.log(item);
                    mediaFilesList.value.push({ id: item.id, uri: item.uri, description: item.title });


                });
            })
            .catch((e) => {
                console.log(e);
          console.log(e.response.data.errors);
          this.showError = true;
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

          //message
          this.error.message = e.response.data.errors;

		  this.$forceUpdate();
            });


        return {
            mediaFilesList,
            showError: false,
            error: {
                message: "",
            },
        }
    },
    methods: {
        removeFromGallery(id) {
            if (confirm('Are you sure you want to remove this Image?')){

                var newApiUrl =
                    this.$store.state.apiUrl +
                    "media_file/" + id;
                axios
                    .delete(
                        newApiUrl,
                        {
                            headers: {
                                "Content-Type": "multipart/form-data",
                                Accept: "application/json",
                                Authorization: "Bearer " + localStorage.token,
                            },
                        }
                    )
                    .then((r) => {
                        const result = r.data;

                        console.log(result);
                        toast.success('Image was removed', { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });
                        this.refreshToGallery();
                    })
                    .catch((e) => {
                        console.log(e.response.data.errors);
          this.showError = true;
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

          //message
          this.error.message = e.response.data.errors;

		  this.$forceUpdate();
                    });

            }
            else {
                return false;
            }

        },
        addImagesToGallery() {
            for (let i = 0; i < this.selectedFile.length; i++) {
                let file = this.selectedFile[i];

                var newApiUrl =
                    this.$store.state.apiUrl +
                    "media_file";
                axios
                    .post(
                        newApiUrl,
                        {
                            media_file: file,
                            title: this.image_description
                        },
                        {
                            headers: {
                                "Content-Type": "multipart/form-data",
                                Accept: "application/json",
                                Authorization: "Bearer " + localStorage.token,
                            },
                        }
                    )
                    .then((r) => {
                        const result = r.data;

                        console.log(result);
                        toast.success('Image was added', { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });
                        this.refreshToGallery();
                    })
                    .catch((e) => {
                        console.log(e.response.data.errors);
                        this.showError = true;
                        toast.error('There was an error uploading your image. Please try again.', { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

                        //message
                        this.error.message = e.response.data.errors;

                        this.$forceUpdate();
                    });
            }
        },
        refreshToGallery() {
            //empty gallery
            this.mediaFilesList = [];
            var newApiUrl = store.state.apiUrl + "media_file";
            axios
                .get(newApiUrl, {
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${localStorage.token}`,
                    },
                })
                .then((result) => {

                    console.log('All Media');
                    console.log(result.data);

                    result.data.media_files.forEach(item => {
                        console.log(item);
                        this.mediaFilesList.push({ id: item.id, uri: item.uri, description: item.title });

                    });
                    this.$forceUpdate();
                })
                .catch((e) => {
                    console.log(e.response.data.errors);
                    this.showError = true;
                    toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

                    //message
                    this.error.message = e.response.data.errors;

                    this.$forceUpdate();
                });
        },
        onFileSelected(event) {
            this.selectedFile = event.target.files;
            this.addImagesToGallery();

            this.image_description = '';
            this.$refs.fileupload.value = null;
            this.$forceUpdate();
        }
    }
};
</script>
  <style>
  .ml-1 {
    margin-left: 10px !important;
  }
  </style>
