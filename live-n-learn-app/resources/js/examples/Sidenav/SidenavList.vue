<template>
  <div id="sidenav-collapse-main" class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100">
    <ul class="navbar-nav">
      <li class="nav-item">
        <sidenav-collapse collapse-ref="dashboardsExamples" nav-text="Dashboard"
          :class="getRoute() === 'dashboards' ? 'active' : ''">
          <template #icon>
            <icon name="dashboard" />
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <sidenav-item :to="{
                name: defaultRoute,
              }" mini-icon="" text="Live N Learn" />
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Outbound Trips"
          :class="getRoute() === 'trips' ? 'active' : ''" v-if="authUserRole === 'administrator'">
          <template #icon>
            <i class="fa fa-plane" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/locations/add' })">
                  <span class="sidenav-normal"><i class="fa fa-plus" aria-hidden="true"></i> Add Trip
                    Location
                  </span>
                </span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/locations/view' })">
                  <span class="sidenav-normal"> View Trip Locations</span>
                </span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/itinerary/add' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Add New Itinerary
                  </span>
                </span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/itinerary/view' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-list" aria-hidden="true"></i> View
                    Itineraries
                  </span>
                </span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/trips/add' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Create New Trip
                  </span>
                </span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/trips/view' })">
                  <span class="sidenav-normal"><i class="fa fa-plane" aria-hidden="true"></i> View All
                    Trips</span>
                </span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/flights/view' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plane" aria-hidden="true"></i> Flight
                    Information</span>
                </span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/flights/outbound/calendar' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Flight
                    Calendar</span></span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/trips/gallery' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-image" aria-hidden="true"></i> Image
                    Gallery</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Inbound Programs"
          :class="getRoute() === 'locations' ? 'active' : ''" v-if="authUserRole === 'administrator'">
          <template #icon>
            <!-- <i class="ni ni-map-big"></i> -->
            <i class="fa fa-globe" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/locations/add' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add Program
                    Location</span></span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/locations/view' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-list" aria-hidden="true"></i> View Program
                    Location</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/inbound_programs/create' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plus" aria-hidden="true"></i> New Hosting
                    Program</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/inbound_programs/list' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-list" aria-hidden="true"></i> View Hosting
                    Programs</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/flights/viewinbound' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plane" aria-hidden="true"></i> Flight
                    Information</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/flights/inbound/calendar' })">
                  <span class="sidenav-normal">
                    <i class="fa fa-plane" aria-hidden="true"></i> Flight
                    Calendar</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <!-- customer-support -->
      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Users" :class="getRoute() === 'admins' ? 'active' : ''"
          v-if="authUserRole === 'administrator'">
          <template #icon>
            <icon name="customer-support" />
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/add' })"><span class="sidenav-normal"><i
                      class="fa fa-plus" aria-hidden="true"></i> Add
                    User</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/admins' })"><span class="sidenav-normal"><i
                      class="fa fa-user-circle-o" aria-hidden="true"></i>
                    Admins</span></span>
              </li>
              <!-- ROUTE DOES NOT EXIST HIDING FOR NOW-->
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/students/outbound' })">
                  <span class="sidenav-normal"><i class="fa fa-user-circle" aria-hidden="true"></i>
                    Outbound Travelers</span></span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/students/inbound' })">
                  <span class="sidenav-normal"><i class="fa fa-user-circle" aria-hidden="true"></i>
                    Inbound Travelers</span></span>
              </li>

              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/hosts' })">
                  <span class="sidenav-normal"><i class="fa fa-user-o" aria-hidden="true"></i> Host
                    Families</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/coordinators' })">
                  <span class="sidenav-normal"><i class="fa fa-user" aria-hidden="true"></i> Local
                    Coordinators</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/group_leaders' })">
                  <span class="sidenav-normal"><i class="fa fa-user" aria-hidden="true"></i> Group
                    Leaders</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/admins/all' })">
                  <span class="sidenav-normal"><i class="fa fa-users" aria-hidden="true"></i> All
                    Users</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Partners"
          :class="getRoute() === 'school' ? 'active' : ''" v-if="authUserRole === 'administrator'">
          <template #icon>
            <i class="fa fa-school" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/school/add' })">
                  <span class="sidenav-normal"><i class="fa fa-plus" aria-hidden="true"></i> Add
                    School</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/school/view' })">
                  <span class="sidenav-normal"><i class="fa fa-list" aria-hidden="true"></i> View
                    Schools</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/partners/add' })">
                  <span class="sidenav-normal"><i class="fa fa-plus" aria-hidden="true"></i> Add New
                    Partner</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/partners/inbound/view' })">
                  <span class="sidenav-normal"><i class="fa fa-users" aria-hidden="true"></i>View Inbound
                    Partners</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/partners/outbound/view' })">
                  <span class="sidenav-normal"><i class="fa fa-users" aria-hidden="true"></i> View
                    Outbound Partners</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Forms"
          :class="getRoute() === 'checklist' ? 'active' : ''"
          v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
          <template #icon>
            <!-- <i class="ni ni-map-big"></i> -->
            <!-- <icon name="components"/> -->
            <i class="fa fa-list-alt" style="color: black !important" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <!-- <li class="nav-item">
                <a href="" class="nav-link"
                  ><span class="sidenav-mini-icon"></span
                  ><span class="sidenav-normal">Add Form</span></a
                >
              </li> -->
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '' })">
                  <span class="sidenav-normal">View All Forms</span>
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/program/form_traveler' })
                  ">
                  <span class="sidenav-normal"> Traveler Info </span>
                  <!-- <lnl-circular-progress-bar percentage="30" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/program/form_health' })
                  ">
                  <span class="sidenav-mini-icon"></span>
                  <span class="sidenav-normal"> Health Form</span>
                  <!-- <lnl-circular-progress-bar percentage="30" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="$router.push({ path: '/travelers/program/passport' })"><span
                    class="sidenav-mini-icon"></span><span class="sidenav-normal">Passport</span>
                  <!-- <lnl-circular-progress-bar percentage="30" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/program/additional' })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Additional Info</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>

              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/policy/terms-conditons' })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Terms and Conditions</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/policy/student-coc' })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Student Code of Conduct</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/policy/parent-consent' })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Parent Consent</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({ path: '/travelers/policy/cancel-policy' })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Cancellation Policy</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>
              <li class="nav-item" v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
                <span class="nav-link" @click="
                  $router.push({
                    path: '/travelers/policy/medical-insurance',
                  })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Medical Insurance Policy</span>
                  <!-- <lnl-circular-progress-bar percentage="75" /> -->
                </span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>
      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Payments"
          :class="getRoute() === 'payments' ? 'active' : ''"
          v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
          <template #icon>
            <!-- <i class="ni ni-map-big"></i> -->
            <!-- <icon name="components"/> -->
            <i class="fa fa-money-check" style="color: black !important" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <!-- <li class="nav-item">
                <a href="" class="nav-link"
                  ><span class="sidenav-mini-icon"></span
                  ><span class="sidenav-normal">Add Form</span></a
                >
              </li> -->
              <li class="nav-item">
                <span class="nav-link" @click="
                  $router.push({ path: `/traveler/invoices/${this.userId}` })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">View My
                    Payments</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="
                  this.$router.push({
                    path: `/traveler/payment-method/${this.userId}`,
                  })
                  "><span class="sidenav-mini-icon"></span><span class="sidenav-normal">Edit Payment
                    Method</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Invoices"
          :class="getRoute() === 'invoices' ? 'active' : ''" v-if="authUserRole === 'administrator'">
          <template #icon>
            <i class="fa fa-file-invoice" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/invoices/view' })"><span
                    class="sidenav-mini-icon"></span><span class="sidenav-normal">View Invoices</span>
                </span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>
      <li></li>

      <!-- <li class="nav-item">
        <sidenav-collapse
          collapse-ref="pagesExamples"
          nav-text="Messaging"
          :class="getRoute() === 'Messaging' ? 'active' : ''"
        >
          <template #icon>
            <i
              class="fa fa-envelope"
              style="color: black"
              aria-hidden="true"
            ></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <li class="nav-item">
                <a href="/messaging/add" class="nav-link"
                  ><span class="sidenav-mini-icon"></span
                  ><span class="sidenav-normal">Send Message</span></a
                >
              </li>
              <li class="nav-item">
                <a href="/messaging/view" class="nav-link"
                  ><span class="sidenav-mini-icon"></span
                  ><span class="sidenav-normal">View Messages</span></a
                >
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li> -->
      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="Reports"
          :class="getRoute() === 'Reports' ? 'active' : ''" v-if="authUserRole === 'administrator'">
          <template #icon>
            <i class="fa fa-file" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/reports/view' })">
                  <span class="fa fa-list"></span> &nbsp;<span class="sidenav-normal">View Reports</span>
                </span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '/reports/generate' })"><span
                    class="fa fa-plus"></span> &nbsp;<span class="sidenav-normal">Generate Report</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>
      <li class="nav-item">
        <sidenav-collapse collapse-ref="pagesExamples" nav-text="My Program"
          :class="getRoute() === 'Reports' ? 'active' : ''"
          v-if="authUserRole === 'traveler' || authUserRole === 'parent'">
          <template #icon>
            <i class="fa fa-file" style="color: black" aria-hidden="true"></i>
          </template>
          <template #list>
            <ul class="nav ms-4 ps-3">
              <!-- nav links -->
              <li class="nav-item">
                <span class="nav-link" @click="
                  $router.push({ path: '/traveler/trips' })
                  "><span class="fa fa-list"></span> &nbsp;<span class="sidenav-normal">Trip
                    Details</span></span>
              </li>
              <li class="nav-item">
                <span class="nav-link" @click="$router.push({ path: '' })"><span class="fa fa-plus"></span> &nbsp;<span
                    class="sidenav-normal">Travel Requests</span></span>
              </li>
            </ul>
          </template>
        </sidenav-collapse>
      </li>

      <li class="nav-item"></li>
    </ul>
  </div>
  <div class="pt-3 mx-3 mt-3 sidenav-footer"></div>
</template>

<script>
import Icon from "@/components/Icon.vue";
import SidenavItem from "./SidenavItem.vue";
import SidenavCollapse from "./SidenavCollapse.vue";
import SidenavCard from "./SidenavCard.vue";
import SidenavCollapseItem from "./SidenavCollapseItem.vue";
import lnlCircularProgressBar from "@/components/LnlCircularProgressBar.vue";

export default {
  name: "SidenavList",
  components: {
    Icon,
    SidenavItem,
    SidenavCollapse,
    SidenavCard,
    SidenavCollapseItem,
    lnlCircularProgressBar,
  },
  props: {
    cardBg: { type: String, default: "" },
  },
  data() {
    return {
      title: "Vite Soft UI Dashboard PRO",
      controls: "dashboardsExamples",
      isActive: "active",
      authUserRole: "",
      defaultRoute: "",
      userId: null,
    };
  },
  methods: {
    getRoute() {
      const routeArr = this.$route.path.split("/");
      return routeArr[1];
    },
  },
  watch: {
    authUserRole(data) {
      console.log(data);
      // if (this.$route.path.match(/\/dashaboards\/.*/)) {

      switch (data) {
        case "administrator":
          this.defaultRoute = "Default";
          break;
        case 'traveler':
          this.defaultRoute = "Traveler Dashboard";
          break;
        case 'parent':
          this.defaultRoute = "Traveler Dashboard";
          break;

        default:
          break;
      }

      // }
    },
  },
  beforeMount() {
    console.log(this.$store.state);
    const user = JSON.parse(localStorage.getItem("user"));

    if (user) {
      this.userId = user.id;
      this.authUserRole = user.role;
      if (this.$route.path.match(/dashboards/i)) {
        switch (this.authUserRole) {
          case "administrator":
            this.$router.push("/dashboards/dashboard-default");
            this.defaultRoute = "Default";
            break;
          case "traveler":
            this.$router.push("/dashboards/traveler");
            this.defaultRoute = "Traveler Dashboard";
            break;
          case "parent":
            this.$router.push("/dashboards/traveler");
            this.defaultRoute = "Traveler Dashboard";
            break;
          default:
            this.$router.push("/dashboards/dashboard-default");
            break;
        }
      }
    } else {
      // this.$router.push("/");
    }
  },
};
</script>
