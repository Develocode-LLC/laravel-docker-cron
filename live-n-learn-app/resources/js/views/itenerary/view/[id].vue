<template>
    <div class="py-4 container-fluid">
        <div class="mt-4 row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="mb-0">Update Itinerary</h5>
                        <p class="mb-0 text-sm">
                            Use this tool to update an Itinerary here
                        </p>
                    </div>
                    <div class="row" style="margin:10px;">


                            <div class="form-group">
                                <label for="Itinerary_name">Itinerary Name</label>
                                <input type="text" class="form-control" id="Itinerary_name" placeholder="Itinerary Name"
                                    v-model="itineraryData.title">
                                    <input type="hidden" ref="overview_image" />
                            </div>
                            <div class="form-group">
                                <label for="trip_code">Itinerary Code</label>
                                <input type="text" class="form-control" id="Itinerary_code" placeholder="Itinerary Code"
                                    v-model="itineraryData.code">
                            </div>
                            

                            <div
                          class="row"
                          v-for="n in parseInt(destinationTotal)"
                          :key="n"
                        >
                          <div class="col-10">
                            <div class="form-group">
                              <label for="origin_city">Destination</label>
                              <select
                                class="form-select"
                                id="destination"
                                ref="destination"
                                v-model="destinationList[n - 1]"
                              >
                                <option selected value="">
                                  Select Destination
                                </option>
                                <option
                                  v-for="(name, id) in destinationsList"
                                  :value="name.id"
                                  :label="name.name"
                                  :key="id"
                                >
                                  {{ name.name }}
                                </option>
                              </select>
                            </div>
                          </div>
                          <div class="col-2 align-bottom">
                            <div class="form-group">
                              <label for="origin_city" style="display: block"
                                >&nbsp;</label
                              >
                              <button
                                @click="removeDestination(n)"
                                type="button"
                                class="btn bg-gradient-warning"
                              >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                Delete
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-4">
                            <button
                              type="button"
                              @click="addNewDestination()"
                              class="btn bg-gradient-success"
                            >
                              <i
                                class="fa fa-map-marker"
                                aria-hidden="true"
                              ></i>
                              Add Additional Destination
                            </button>
                          </div>
                          <div class="col-4">
                            <!-- <button type="button" @click="updateDestination()" class="btn bg-gradient-warning"><i
                                        class="fa fa-map-marker" aria-hidden="true"></i> Update Locations
                                    Destination</button> -->
                          </div>
                        </div>


</div>


<div class="row form-group" style="margin-left:10px;">

                            

                            <div class="form-group">
                                <label for="trip_code"><b>Itinerary Overview</b></label>
                            </div>

                            <div class="row overview-row" v-for="n in parseInt(overviewTotal)" :key="n">

                                <div class="col-md-2 col-12">
                                    <div class="form-group">
                                        <label for="trip_description" style="display: block">{{ n }}: Image</label>
                                        <button @click="showGallery(n-1)" type="button" class="btn bg-gradient-success"><i
                                            class="fa fa-image" aria-hidden="true"></i>
                                        Choose Image</button>
                                        <div class="col-md-6 col-12">
                                                <img :src="itineraryData.overview[n-1].media_file.uri"  class="img-fluid img-thumbnail" />
                                        </div>
                
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="trip_title" style="display:block;"> {{ n }}: Title</label>
                                        <input type="text" class="form-control" placeholder="Enter Title"
                                            v-model="itineraryData.overview[n - 1].title">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="trip_description" style="display:block;"> {{ n }}:
                                            Description</label>
                                        <textarea class="form-control" id="trip_description" rows="4"
                                            placeholder="Enter Description here"
                                            v-model="itineraryData.overview[n - 1].content"></textarea>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="form-group" style="margin-top:25px !important;">
                                        <button type="button" @click="removeOverview()" class="btn bg-gradient-warning"><i
                                                class="fa fa-trash" aria-hidden="true"></i>
                                            Delete</button>
                                    </div>
                                </div>


                                <div class="row" v-show="showCurrentImageUpload[n-1].show">
                                    <div class="row">
                                      <h5>Image Gallery</h5>
                                    </div>
                                    <div class="form-group">
                                        <label for="trip_description" style="display: block">Select Photos to Upload to Image Gallery(Multiple files allowed)</label>
                                        <input name="file" type="file" placeholder="Upload Photos" multiple @change="onFileSelected" accept="image/*" />
                                      </div>
                
                                    <div class="row">
                
                                        <div v-for="files in mediaFilesList" class="col-lg-1 col-md-2 col-6">
                                        <img :src="files.uri"  class="img-fluid img-thumbnail" :key="files.id" />
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                                            <button @click="addOverViewGalleryImages(files.id,n-1)" type="button" class="btn bg-gradient-info btn-sm me-md-2"><i class="fa fa-plus" aria-hidden="true"></i> Image </button>
                                        </div>
                                        </div>
                
                
                                    </div>
                
                                </div>



                            </div>

                            <div class="row">

                                <div class="col-3"></div>
                                <div class="col-4">
                                    <button type="button" @click="addNewOverview()" class="btn bg-gradient-success"><i
                                            class="fa fa-list" aria-hidden="true"></i> Add New Day</button>
                                </div>


                            </div>






                            <div v-if="showError" class="invalid-feedback2">{{ error.message }}</div>
                            <div class="row">
                                <div class="col-3">
                                    <button type="button" @click="updateItinerary()" class="btn bg-gradient-success"><i class="fa fa-save"></i> Update
                                        Itinerary</button>
                                </div>

                                <div class="col-1"></div>
                                <div class="col-4">
                                    <button type="button" @click="duplicateItinerary()" class="btn bg-gradient-info"><i
                                            class="fa fa-clone" aria-hidden="true"></i> Duplicate Itinerary</button>
                                </div>
                            </div>


                    </div>

                </div>
            </div>
        </div>
        </div>


</template>

<script>
import { useRoute } from "vue-router";
import axios from "axios";
import store from "@/store/index.js";
import { ref } from "vue";
import VsudAlert from "@/components/VsudAlert.vue";
import VsudSnackbar from "@/components/VsudSnackbar.vue";

export default {
    name: "DataTables",
    setup() {
        const route = useRoute();
        const paramId = route.params.id;
        let locationsList = ref([]);
        let itineraryData = ref({});
        let itineraryImageData = ref();
        let destinationsList = ref([]);
        let overviewList = ref([]);
        let showUploadedImages = ref(false);
        let imagesTotal = ref(0);
        let destinationTotal = ref(1);
        let destinationList = ref([]);
        let finalDestinationList = ref([]);
        let overviewTotal = ref();
        let schoolList = ref([]);
        let showCurrentImageUpload = ref([]);
        let selectedMediaFilesList = ref([]);
        let showSelectedImage = ref([]);
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

        result.data.media_files.forEach(item => {
          mediaFilesList.value.push({ id: item.id, uri: item.uri });

        });
      })
      .catch((error) => {
        console.error(error);
      });


        //get itinerary list
        var newApiUrl = store.state.apiUrl + 'master_itinerary/' + paramId;
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;

            console.log(result.data);

            itineraryData.value = result.data.itinerary;


            overviewTotal.value = result.data.itinerary.overview.length;

            for (var i=0;i<overviewTotal.value;i++){
                showCurrentImageUpload.value.push({ show: false});
                showSelectedImage.value.push( {show: false});
                selectedMediaFilesList.value.push({ uri: null});
            }

            if (result.data.itinerary.destinations.length > 0){
                destinationTotal.value = result.data.itinerary.destinations.length;
            }

            if (result.data.itinerary.destinations != null) {
          for (let i = 0; i < result.data.itinerary.destinations.length; i++) {
            destinationList.value.push(result.data.itinerary.destinations[i].id);
          }
        }


        }).catch(e => {


            console.error(e)
        })


        console.log('destinations');
        console.log(destinationList.value);


        //get itinerary images
        var newApiUrl = store.state.apiUrl + 'master_itinerary/' + paramId + '/master_itinerary_image';
        axios.get(newApiUrl, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.token
            }
        }).then(r => {
            const result = r;
            //console.log(result.data);

            itineraryImageData.value = result.data.itinerary_images;


            imagesTotal.value = result.data.itinerary_images.length;

            if (imagesTotal.value > 0) {
                showUploadedImages.value = true;
                console.log(itineraryImageData.value);
            }

        }).catch(e => {


            console.error(e)
        })

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

            result.data.locations.forEach((item, index) => {
                if (item.country == 'United States') {
                    locationsList.value.push({ id: item.id, name: item.name });

                }
                else {
                    destinationsList.value.push({ id: item.id, name: item.country });
                }

            })


        }).catch(e => {


            console.error(e)
        })

        return {
            paramId,
            showCurrentImageUpload,
            selectedMediaFilesList,
            mediaFilesList,
            showSelectedImage,
            locationsList,
            itineraryImageData,
            finalDestinationList,
            destinationList,
            imagesTotal,
            showUploadedImages,
            destinationsList,
            overviewList,
            destinationTotal,
            overviewTotal,
            itineraryData,
            formdata: {
                title: '',
                school: 0,
                originCity: 0,
                destinationCity: 0,
                description: '',
                start_city: '',
                trip_type: '',
                trip_itenary: '',
                dest_city: [],
                cost: 0.00,
                start_date: '',
                trip_id_prefix: '',
                end_date: '',
                total_seats: '',
                registration_cutoff_date: ''
            },
            showError: false,
            error: {
                message: ''
            },

        }


    },
    methods: {
        showGallery(id){

this.showCurrentImageUpload[id].show = true;
this.$forceUpdate();

},
addOverViewGalleryImages(files_id, array_index){

    console.log('Files id:' + files_id);
    console.log('Array Index:' + array_index);

this.$refs.overview_image[array_index].value = files_id;
console.log('Added image to index:' + files_id + ' to ' + array_index);
this.showCurrentImageUpload[array_index].show = false;

this.mediaFilesList.forEach(file => {
    console.log(file.id + ' ' + file.uri);
    if (file.id == files_id){
        this.selectedMediaFilesList[array_index].uri = file.uri;
        console.log('adding ' + file.id + ' ' + file.uri + ' to selectedMediaFilesList[' + array_index + ']');
        this.$forceUpdate();
    }
  
});

console.log('Array');
console.log(this.selectedMediaFilesList);


this.$forceUpdate();
},
        addNewDestination() {
            this.destinationTotal++;
            this.$forceUpdate();
        },
        updateDestination() {

            this.finalDestinationList = [];

            for (let i = 0; i < this.destinationTotal; i++) {

                if (this.$refs.destination[i].value !== undefined) {

                    console.log(this.$refs.destination[i].value);

                    this.finalDestinationList.push(this.$refs.destination[i].value);

                }

            }

            console.log(this.finalDestinationList);

        },
        removeDestination(index) {
            console.log(index);
            this.destinationTotal--;
            this.$forceUpdate();
            this.finalDestinationList.splice(index, 1);
            if (index === 0)
                this.addNewDestination();
        },
        addNewOverview() {

            this.itineraryData.overview.push(
                {
                    "id": 16,
                    "master_itinerary_id": 17,
                    "itinerary_index": 1,
                    "itinerary_date": "2024-02-02",
                    "time": "20:30:00",
                    "title": "",
                    "content": "",
                    "created_at": "2024-01-12T14:56:13.000000Z",
                    "updated_at": "2024-01-12T14:56:13.000000Z"
                }
            );
            this.overviewTotal++;
            this.$forceUpdate();
        },
        updateOverview() {

            this.OverviewList = [];

            for (let i = 0; i < this.overviewTotal; i++) {

                if (this.$refs.overview_title[i].value !== undefined) {

                    this.overviewList.push({
                        title: this.$refs.overview_title[i].value,
                        description: this.$refs.overview_description[i].value
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
            if (index === 0)
                this.addNewOverview();
        },
        duplicateItinerary() {

            var newApiUrl = store.state.apiUrl + 'master_itinerary/' + this.paramId + '/duplicate';
            axios.post(newApiUrl, {}, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(r => {
                const result = r;

                //console.log(result.data.duplicate_itinerary.id);

                let duplicateId = result.data.duplicate_itinerary.id;

                this.$router.push({ path: '/itinerary/' + duplicateId, replace: true });



            }).catch(e => {


                console.error(e)
            })

        }
        ,
        updateItinerary() {

            this.finalDestinationList = [];

            for (let i = 0; i < this.destinationTotal; i++) {
        if (this.$refs.destination[i].value !== undefined) {
          this.finalDestinationList.push(parseInt(this.$refs.destination[i].value));

        }
      }

      console.log(this.finalDestinationList);



            var newApiUrl = this.$store.state.apiUrl + 'master_itinerary/' + this.paramId;
            axios.put(newApiUrl, {
                "code": this.itineraryData.code,
                "title": this.itineraryData.description,
                "description": this.itineraryData.description,
                "destinations": this.finalDestinationList
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                }
            }).then(r => {
                const result = r.data;

                console.log(result);

                //this.addImagesToItinerary(result.itinerary.id);

                //this.addOverviewToId(result.itinerary.id);

                this.$router.push({ path: '/itinerary/view', replace: true });

                this.$forceUpdate();

            }).catch(e => {

                console.log(e);
                console.log(e.message);

                this.showError = true;

                //message
                this.error.message = e.message;
            })

        }



    }
    ,
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
