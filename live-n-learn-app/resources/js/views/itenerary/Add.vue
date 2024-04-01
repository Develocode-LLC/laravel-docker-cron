<template>
  <div class="py-4 container-fluid">
    <div class="mt-4 row">
      <div class="col-12">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h5 class="mb-0">Add New Itinerary</h5>
            <p class="mb-0 text-sm">Use this tool to add an Itinerary here</p>
          </div>
          <div class="row" style="margin: 10px">
            <form @submit.prevent="submit">
              <div class="form-group">
                <label for="Itinerary_name">Itinerary Name</label>
                <input type="text" class="form-control" id="Itinerary_name" placeholder="Itinerary Name"
                  v-model="formdata.title" />
              </div>
              <div class="form-group">
                <label for="trip_code">Itinerary Code</label>
                <input type="text" class="form-control" id="Itinerary_code" placeholder="Itinerary Code"
                  v-model="formdata.code" />
              </div>
              <div class="row" v-for="idx in parseInt(destinationTotal)" :key="idx">
                <div class="col-12 col-md-10">
                  <div class="form-group">
                    <label for="origin_city">Destination</label>
                    <select class="form-select" id="destination" ref="destination"
                      v-model="formdata.destinations[idx - 1]">
                      <option selected value="">Select Destination</option>
                      <option v-for="(name, id) in destinationList" :value="name.id" :label="name.name" v-bind:key="id">
                        {{ name.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-2 align-bottom">
                  <div class="form-group">
                    <label for="origin_city" style="display: block">&nbsp;</label>
                    <button @click="removeDestination(idx)" type="button" class="btn bg-gradient-danger">
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 col-12">
                  <button type="button" @click="addNewDestination()" class="btn bg-gradient-success">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> Add
                    Additional Destination
                  </button>
                </div>
                <div class="col-4">
                  <!-- <button type="button" @click="updateDestination()" class="btn bg-gradient-warning"><i
                                            class="fa fa-map-marker" aria-hidden="true"></i> Update Locations
                                        Destination</button> -->
                </div>
              </div>

              <!-- <div class="img-flex row" v-show="showUploadedImages">
                <div class="img-preview" v-for="n in parseInt(imagesTotal)" :key="n" >
                  <img :id="'preview_' + n" :src="giveUploadUrl(n - 1)" alt="your image" width="100" height="100" />
                </div>
              </div> -->

              <div class="form-group">
                <label for="trip_code"><b>Itinerary Overview</b></label>
              </div>

              <div class="row overview-row" v-for="n in parseInt(overviewTotal)" :key="n">
                <div class="col-md-2 col-12">
                  <div class="form-group">
                    <label for="trip_description" style="display: block">{{ n }}: Image</label>
                    <button @click="showGallery(n - 1)" type="button" class="btn bg-gradient-success">
                      <i class="fa fa-image" aria-hidden="true"></i> add
                      Image
                    </button>
                    <div class="col-md-6 col-12">
                      <img :src="selectedMediaFilesList[n - 1]?.uri" class="img-fluid img-thumbnail" />
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label for="trip_title" style="display: block">
                      {{ n }}: Title</label>
                    <input type="text" class="form-control" placeholder="Enter Title" ref="overview_title"
                      v-model="itineraryOverviewData[n - 1].title" />

                    <input type="hidden" ref="overview_image" />
                  </div>
                </div>

                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label for="trip_description" style="display: block">{{ n }}: Description</label>
                    <textarea class="form-control" id="trip_description" rows="1" placeholder="Enter Description here"
                      ref="overview_description" v-model="itineraryOverviewData[n - 1].content">
                    </textarea>
                  </div>
                </div>

                <div class="col-md-2 col-12">
                  <div class="form-group" style="margin-top: 25px !important">
                    <button type="button" @click="removeOverview()" class="btn bg-gradient-danger">
                      <i class="fa fa-trash" aria-hidden="true"></i> Delete
                    </button>
                  </div>
                </div>
                <div v-show="showCurrentImageUpload[n - 1].show" class="row">
                  <div class="row">
                    <h5>Image Gallery</h5>
                  </div>
                  <div class="form-group">
                    <label for="trip_description" style="display: block">Select Photos to Upload to Image Gallery(Multiple
                      files
                      allowed)</label>
                    <input name="file" type="file" placeholder="Upload Photos" multiple @change="onFileSelected"
                      accept="image/*" />
                  </div>


                  <div class="row" style="max-height: 200px; overflow: scroll;">
                    <div v-for="files in mediaFilesList" class="col-md-2 col-6" :key="files">
                      <img :src="files.uri" class="img-fluid img-thumbnail aspect-video" :key="files.id"
                        :title="files.description" />
                        <div class="row justify-content-center">{{ files.description }}</div>
                      <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                        <button @click="addOverViewGalleryImages(files.id, n - 1)" type="button"
                          class="btn btn-default bg-gradient-info btn-block w-100">
                          <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="justify-content: center">
                <!-- <div class="col-3"></div> -->
                <div class="col-12 col-md-4">
                  <button type="button" @click="addNewOverview()" class="btn bg-gradient-success">
                    <i class="fa fa-list" aria-hidden="true"></i> Add New Day
                  </button>
                </div>
              </div>

              <div class="invalid-feedback2">
                {{ error.message }}
              </div>

              <button type="submit" @click="addItinerary()" class="btn bg-gradient-success">
                <i class="fa fa-save"></i> Save Itinerary
              </button>
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
import store from "@/store/index.js";
import { ref, toRaw } from "vue";
import { Result } from "postcss";
import { toast } from "vue3-toastify";

export default {
  name: "DataTables",
  setup() {
    let destinationList = ref([]);
    let mediaFilesList = ref([]);
    let overviewList = ref([]);
    let showCurrentImageUpload = ref([]);
    let selectedMediaFilesList = ref([]);
    let showSelectedImage = ref([]);
    let destinationTotal = ref(1);
    let overviewTotal = ref(1);
    let schoolList = ref([]);
    let itineraryOverviewData = ref([{
      // "id": this.itineraryData.overview[this.itineraryData.overview.length - 1].id + 1,
      // "master_itinerary_id": "",
      "itinerary_index": 0,
      "itinerary_date": "2024-02-02",
      "time": "20:30:00",
      "title": "",
      "content": "",
      "media_file": {
        "created_at": Date.now(),
        "file_location": "",
        "id": 0,
      },
      "media_file_id": 0
    }]);
    let itinerary = ref([]);


    //console.log(destinationTotal.value);

    for (var i = 0; i < overviewTotal.value; i++) {
      showCurrentImageUpload.value.push({ show: false });
      showSelectedImage.value.push({ show: false });
      selectedMediaFilesList.value.push({ uri: null, description: null });
    }


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
        result.data.media_files.forEach((item) => {
          mediaFilesList.value.push({
            id: item.id,
            uri: item.uri,
            description: item.title,
          });
        });
      })
      .catch((error) => {
        console.error(error);
      });

    //get locations list
    var newApiUrl = store.state.apiUrl + "location";
    axios
      .get(newApiUrl, {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((result) => {
        //console.log(result.data.locations);

        result.data.locations.forEach((item) => {
          if (item.country == "United States") {
          } else {
            destinationList.value.push({ id: item.id, name: item.country });
          }
        });
      })
      .catch((error) => {
        console.error(error);
      });

    return {
      destinationList,
      mediaFilesList,
      selectedMediaFilesList,
      showCurrentImageUpload,
      overviewList,
      imagesTotal: 0,
      showUploadedImages: false,
      selectedFile: null,
      destinationTotal: 1,
      overviewTotal: 1,
      formdata: {
        code: "",
        title: "",
        description: "",
        destinations: [],
      },
      showError: false,
      error: {
        message: "",
      },
      itineraryOverviewData
    };
  },
  methods: {
    showGallery(id) {
      this.showCurrentImageUpload[id].show = true;
      this.$forceUpdate();
    },
    addOverViewGalleryImages(files_id, array_index) {

      this.$refs.overview_image[array_index].value = files_id;
      console.log('Added image to index:' + files_id + ' to ' + array_index);
      this.showCurrentImageUpload[array_index].show = false;

      console.log('Media Files Array');
      console.log(this.mediaFilesList);
      console.log('End Media Files Array');

      this.mediaFilesList.forEach(file => {
        if (file.id == files_id) {
          console.log('I found the file at ' + file.id);
          this.selectedMediaFilesList[array_index].uri = file.uri;
          this.itineraryOverviewData[array_index].media_file_id = files_id;
        }

      });

      this.$forceUpdate();
    },
    giveUploadUrl(id) {
      console.log(this.selectedFile[id]);
      var newurl = URL.createObjectURL(this.selectedFile[id]);
      return newurl;
    },
    addNewDestination() {
      this.destinationTotal++;
      this.$forceUpdate();
    },
    removeDestination(index) {
      this.formdata.destinations.splice(index, 1);
      this.destinationTotal--;

      if (this.destinationTotal === 0) this.addNewDestination();

      this.$forceUpdate();
    },
    addImagesToItinerary(itineraryId) {
      for (let i = 0; i < this.selectedFile.length; i++) {
        let file = this.selectedFile[i];

        var newApiUrl =
          this.$store.state.apiUrl +
          "master_itinerary/" +
          itineraryId +
          "/master_itinerary_image";
        axios
          .post(
            newApiUrl,
            {
              image: file,
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
          })
          .catch((e) => {
            console.log(e);
            console.log(e.message);

            this.showError = true;

          //message
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

            //message
          this.error.message = e.response.data.errors;
          this.$forceUpdate();
          });
      }
    },
    addImagesToGallery() {
      for (let i = 0; i < this.selectedFile.length; i++) {
        let file = this.selectedFile[i];

        var newApiUrl = this.$store.state.apiUrl + "media_file";
        axios
          .post(
            newApiUrl,
            {
              media_file: file,
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
            this.refreshToGallery();
          })
          .catch((e) => {
            console.log(e);
            console.log(e.message);

            this.showError = true;


          //message
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

            //message
          this.error.message = e.response.data.errors;
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
          console.log("All Media");
          //console.log(result.data);

          result.data.media_files.forEach((item) => {
            console.log(item);
            this.mediaFilesList.push({
              id: item.id,
              uri: item.uri,
              description: item.title,
            });
          });
          this.$forceUpdate();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    onFileSelected(event) {
      this.selectedFile = event.target.files;
      this.showUploadedImages = true;
      console.log(this.selectedFile);
      console.log(this.selectedFile[0]);
      this.imagesTotal = this.selectedFile.length;

      this.addImagesToGallery();

      this.$forceUpdate();
    },
    addNewOverview() {

      this.showCurrentImageUpload = [];
      this.overviewTotal++;
      for (var i = 0; i < this.overviewTotal; i++) {
        this.showCurrentImageUpload.push({ show: false });
      }

      this.showCurrentImageUpload.push({ show: false });
      this.selectedMediaFilesList.push({ uri: "", description: "" });
      this.itineraryOverviewData.push(
        {
          // "id": this.itineraryData.overview[this.itineraryData.overview.length - 1].id + 1,
          // "master_itinerary_id": "",
          "itinerary_index": this.itineraryOverviewData.length,
          "itinerary_date": "2024-02-02",
          "time": "20:30:00",
          "title": "",
          "content": "",
          "media_file": {
            "created_at": Date.now(),
            "file_location": "",
            "id": 0,
          },
          "media_file_id": 0
        }
      );
      console.log(this.itineraryOverviewData)

      this.$forceUpdate();
    },
    // addNewOverview() {
    //   // console.log(this.itineraryData.overview)
    //   // return;
    //   // for (var i = 0; i < this.overviewTotal; i++) {
    //   //   this.showCurrentImageUpload.push({ show: false });
    //   // }
    //   // debugger
    //   this.overviewTotal++;
    // this.itineraryOverviewData.push(
    //   {
    //     // "id": this.itineraryData.overview[this.itineraryData.overview.length - 1].id + 1,
    //     "master_itinerary_id": "",
    //     "itinerary_index": '',
    //     "itinerary_date": "2024-02-02",
    //     "time": "20:30:00",
    //     "title": "",
    //     "content": "",
    //     "media_file": {
    //       "created_at": Date.now(),
    //       "file_location": "",
    //       "id": 0,
    //     },
    //     "media_file_id": 0
    //   }
    // );
    //   // this.$forceUpdate();
    // },
    updateOverview() {
      this.OverviewList = [];

      for (let i = 0; i < this.overviewTotal; i++) {
        if (this.$refs.overview_title[i].value !== undefined) {
          this.overviewList.push({
            title: this.$refs.overview_title[i].value,
            description: this.$refs.overview_description[i].value,
          });
        }
      }

      console.log(this.overviewList);
    },
    removeOverview(index) {
      console.log(index);
      this.overviewTotal--;
      this.$forceUpdate();
      this.overviewList.splice(index, 1);
      if (index === 0) this.addNewOverview();
    },
    addOverviewToId(itineraryId) {
      this.OverviewList = [];

      var newApiUrl =
        this.$store.state.apiUrl +
        "master_itinerary/" +
        itineraryId +
        "/master_itinerary_index";
      axios
        .post(
          newApiUrl,
          { overview: this.itineraryOverviewData },
          {
            headers: {
              "Content-Type": "application/json",
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.token,
            },
          }
        )
        .then((r) => {
          const result = r.data;

          console.log(result);
          toast.success('Itinerary created successfully!', { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 1000 })
          this.$router.push({ path: "/itinerary/view", replace: true });
        })
        .catch((e) => {
          console.log(e);
          console.log(e.message);

          this.showError = true;

          //message
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

            //message
          this.error.message = e.response.data.errors;

          this.$forceUpdate();
        });
      // }
      // }

      // this.$router.push({ path: "/itinerary/view", replace: true });

      this.$forceUpdate();
    },

    addItinerary() {
      var newApiUrl = this.$store.state.apiUrl + "master_itinerary";
      axios
        .post(newApiUrl, this.formdata, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        })
        .then((result) => {
          const itinerary_id = result.data.itinerary.id;

          this.addOverviewToId(itinerary_id);

          //this.$router.push({ path: '/itinerary/view', replace: true });
          console.log(result.data);
          //this.$forceUpdate();
        })
        .catch((e) => {
          console.log(e);
          console.log('Show Errors');
          console.log(e.message);

          this.showError = true;

          this.error.message = e.response.data.errors;

          //message
          toast.error(e.response.data.message, { postion: toast.POSITION.BOTTOM_CENTER, autoClose: 10000 });

          this.$forceUpdate();

            //message

        });
    },
  },
  mounted() {
    // eslint-disable-next-line no-unused-vars
  },
};
</script>
<style>
.overview-row {
  margin-bottom: 20px;
}

.img-flex {
  display: flex;
}

.img-preview {
  float: left;
  display: flex;
  width: 130px !important;
  padding: 3px;
}
</style>
