import {
    createRouter,
    createWebHashHistory,
    createWebHistory,
} from "vue-router";
import Default from "../views/dashboards/Default.vue";
import TravelerDash from "../views/pages/dashboards/travelerDashboard.vue";
import Automotive from "../views/dashboards/Automotive.vue";
import SmartHome from "../views/dashboards/SmartHome.vue";
import VRDefault from "../views/dashboards/vr/VRDefault.vue";
import VRInfo from "../views/dashboards/vr/VRInfo.vue";
import CRM from "../views/dashboards/CRM.vue";
import Overview from "../views/pages/profile/Overview.vue";
import Teams from "../views/pages/profile/Teams.vue";
import Projects from "../views/pages/profile/Projects.vue";
import General from "../views/pages/projects/General.vue";
import Timeline from "../views/pages/projects/Timeline.vue";
import NewProject from "../views/pages/projects/NewProject.vue";
import Pricing from "../views/pages/Pricing.vue";
import RTL from "../views/pages/Rtl.vue";
import Charts from "../views/pages/Charts.vue";
import SweetAlerts from "../views/pages/SweetAlerts.vue";
import Notifications from "../views/pages/Notifications.vue";
import Kanban from "../views/applications/Kanban.vue";
import Wizard from "../views/applications/wizard/Wizard.vue";
import DataTables from "../views/applications/DataTables.vue";
import Calendar from "../views/applications/Calendar.vue";
import Analytics from "../views/applications/analytics/Analytics.vue";
import EcommerceOverview from "../views/ecommerce/overview/Overview.vue";
import NewProduct from "../views/ecommerce/products/NewProduct.vue";
import EditProduct from "../views/ecommerce/EditProduct.vue";
import ProductPage from "../views/ecommerce/ProductPage.vue";
import ProductsList from "../views/ecommerce/ProductsList.vue";
import OrderDetails from "../views/ecommerce/Orders/OrderDetails.vue";
import OrderList from "../views/ecommerce/Orders/OrderList.vue";
import Referral from "../views/ecommerce/Referral.vue";
import Reports from "../views/pages/Users/Reports.vue";
import NewUser from "../views/pages/Users/NewUser.vue";
import Settings from "../views/pages/Account/Settings.vue";
import Billing from "../views/pages/Account/Billing.vue";
import Invoice from "../views/pages/Account/Invoice.vue";
import TravelerTrips from "../views/travelers/views/travelerTrips.vue";
import Security from "../views/pages/Account/Security.vue";
import Widgets from "../views/pages/Widgets.vue";
import Basic from "../views/auth/signin/Basic.vue";
import Cover from "../views/auth/signin/Cover.vue";
import Illustration from "../views/auth/signin/Illustration.vue";
import ResetBasic from "../views/auth/reset/Basic.vue";
import ResetVerify from "../views/auth/reset/verify.vue";
import ResetCover from "../views/auth/reset/Cover.vue";
import ResetIllustration from "../views/auth/reset/Illustration.vue";
import VerificationBasic from "../views/auth/verification/Basic.vue";
import VerificationCover from "../views/auth/verification/Cover.vue";
import VerificationIllustration from "../views/auth/verification/Illustration.vue";
import SignupBasic from "../views/auth/signup/Basic.vue";
import SignupCover from "../views/auth/signup/Cover.vue";
import SignupIllustration from "../views/auth/signup/Illustration.vue";
import Error404 from "../views/auth/error/Error404.vue";
import Error500 from "../views/auth/error/Error500.vue";
import lockBasic from "../views/auth/lock/Basic.vue";
import lockCover from "../views/auth/lock/Cover.vue";
import lockIllustration from "../views/auth/lock/Illustration.vue";

//admin imports
import viewTrips from "../views/trips/View.vue";
import viewGallery from "../views/trips/Gallery.vue";

//import viewTripsByYear from "../views/trips/ViewByYear.vue";

import listInvoices from "../views/invoices/View.vue";
import viewInvoice from "../views/invoices/view/[id].vue";
import createInvoice from "../views/invoices/Add.vue";

import viewInboundPrograms from "../views/trips/InboundTripsView.vue";

import listInboundPrograms from "../views/inbound_programs/List.vue";
import createInboundProgram from "../views/inbound_programs/Create.vue";

import viewFlights from "../views/flights/View.vue";
import viewFlightDetails from "../views/flights/view/[id].vue";

import vewInboundFlightDetails from "../views/flights/view/inbound/[id].vue";
import addFlight from "../views/flights/Add.vue";
import viewInboundFlights from "../views/flights/ViewInbound.vue";
import addInboundFlight from "../views/flights/AddInbound.vue";

import viewOutboundFlightsCalendar from "../views/applications/CalendarOutbound.vue";
import viewInboundFlightsCalendar from "../views/applications/CalendarInbound.vue";

import viewOutbound from "../views/trips/Outbound.vue";
import viewInbound from "../views/trips/Inbound.vue";
import viewTripDetails from "../views/trips/view/[id].vue";
import tripDelete from "../views/trips/delete/[id].vue";
import addTrip from "../views/trips/Add.vue";
import addInboundTrip from "../views/trips/AddInbound.vue";
import addItenerary from "../views/itenerary/Add.vue";

import addPartner from "../views/partners/Add.vue";
import viewOutboundPartners from "../views/partners/ViewPartnersOutBound.vue";
import viewInboundPartners from "../views/partners/ViewPartnersInBound.vue";
import partnerDetails from "../views/partners/view/[id].vue";

import viewItenerary from "../views/itenerary/View.vue";
import iteneraryDetails from "../views/itenerary/view/[id].vue";
import iteneraryDuplicate from "../views/itenerary/duplicate/[id].vue";
import iteneraryDelete from "../views/itenerary/delete/[id].vue";

import viewLocations from "../views/locations/View.vue";
import addLocation from "../views/locations/Add.vue";
import locationDetails from "../views/locations/view/[id].vue";
import viewAdmins from "../views/admins/Admins.vue";
import viewAll from "../views/admins/View.vue";
import viewStudents from "../views/admins/Students.vue";
import viewStudentsInbound from "../views/admins/Students.vue";
import viewStudentsOutbound from "../views/admins/Students.vue";
import viewStudentDetails from "../views/admins/view/students/[id].vue";
import viewGroupLeaderDetails from "../views/admins/view/groupleaders/[id].vue";
import viewLocalCoordinatorDetails from "../views/admins/view/coordinators/[id].vue";
import viewHosts from "../views/admins/Hosts.vue";
import viewCoordinators from "../views/admins/Coordinators.vue";
import viewGroupLeaders from "../views/admins/GroupLeaders.vue";
import addAdmin from "../views/admins/Add.vue";
import viewAdminDetails from "../views/admins/view/[id].vue";
import viewPayments from "../views/payments/View.vue";
import viewPaymentDetails from "../views/payments/view/[id].vue";
import Login from "../views/auth/signin/Index.vue";
import viewCheckLists from "../views/checklists/View.vue";
import addCheckList from "../views/checklists/Add.vue";
import viewCheckListDetails from "../views/checklists/view/[id].vue";
import viewMessaging from "../views/messaging/View.vue";
import addMessage from "../views/messaging/Add.vue";
import viewMessageDetails from "../views/messaging/view/[id].vue";
import addSchool from "../views/school/Add.vue";
import viewSchool from "../views/school/View.vue";
import viewSchoolDetails from "../views/school/view/[id].vue";
import reportsView from "../views/reports/ReportsIndex.vue";
import generateReports from "../views/reports/Generate.vue";
import additionalInformation from "../views/travelers/forms/AdditionalInfoForm.vue";
import travelerInformation from "../views/travelers/forms/TravelerInformation.vue";
import travelerHealthForm from "../views/travelers/forms/HealthForm.vue";
import travelerPassport from "../views/travelers/forms/PassportForm.vue";
import createTravelerAccount from "../views/travelers/forms/CreateAccountForm.vue";

//forms
import termsAndConditions from "../views/travelers/policies/termsAndConditions.vue";
import parentalConsentForm from "../views/travelers/policies/parentalConsent.vue";
import studentCoC from "../views/travelers/policies/studentCoC.vue";
import cancelPolicy from "../views/travelers/policies/cancelPolicy.vue";
import medicalInsurancePolicy from "../views/travelers/policies/medicalInsurancePolicy.vue";

//payment imports
import travelerPaymentMethod from "@/views/payments/travelers/view/[id].vue";

const routes = [
    {
        path: "/",
        name: "/",
        redirect: "/dashboards/dashboard-default",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboards/dashboard-default",
        name: "Default",
        component: Default,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboards/dashboard-default/:year",
        name: "DefaultYear",
        props: true,
        component: Default,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/dashboards/automotive",
        name: "Automotive",
        component: Automotive,
    },
    {
        path: "/dashboards/smart-home",
        name: "Smart Home",
        component: SmartHome,
    },
    {
        path: "/dashboards/vr/vr-default",
        name: "VR Default",
        component: VRDefault,
    },
    {
        path: "/dashboards/vr/vr-info",
        name: "VR Info",
        component: VRInfo,
    },
    {
        path: "/dashboards/crm",
        name: "CRM",
        component: CRM,
    },
    {
        path: "/pages/profile/overview",
        name: "Profile Overview",
        component: Overview,
    },
    {
        path: "/pages/profile/teams",
        name: "Teams",
        component: Teams,
    },
    {
        path: "/pages/profile/projects",
        name: "All Projects",
        component: Projects,
    },
    {
        path: "/pages/projects/general",
        name: "General",
        component: General,
    },
    {
        path: "/pages/projects/timeline",
        name: "Timeline",
        component: Timeline,
    },
    {
        path: "/pages/projects/new-project",
        name: "New Project",
        component: NewProject,
    },
    {
        path: "/pages/pricing-page",
        name: "Pricing Page",
        component: Pricing,
    },
    {
        path: "/pages/rtl-page",
        name: "RTL",
        component: RTL,
    },
    {
        path: "/pages/charts",
        name: "Charts",
        component: Charts,
    },
    {
        path: "/pages/widgets",
        name: "Widgets",
        component: Widgets,
    },
    {
        path: "/pages/sweet-alerts",
        name: "Sweet Alerts",
        component: SweetAlerts,
    },
    {
        path: "/pages/notifications",
        name: "Notifications",
        component: Notifications,
    },
    {
        path: "/applications/kanban",
        name: "Kanban",
        component: Kanban,
    },
    {
        path: "/applications/wizard",
        name: "Wizard",
        component: Wizard,
    },
    {
        path: "/applications/data-tables",
        name: "Data Tables",
        component: DataTables,
    },
    {
        path: "/applications/calendar",
        name: "Calendar",
        component: Calendar,
    },
    {
        path: "/applications/analytics",
        name: "Analytics",
        component: Analytics,
    },
    {
        path: "/ecommerce/overview",
        name: "Overview",
        component: EcommerceOverview,
    },
    {
        path: "/ecommerce/products/new-product",
        name: "New Product",
        component: NewProduct,
    },
    {
        path: "/ecommerce/products/edit-product",
        name: "Edit Product",
        component: EditProduct,
    },
    {
        path: "/ecommerce/products/product-page",
        name: "Product Page",
        component: ProductPage,
    },
    {
        path: "/ecommerce/products/products-list",
        name: "Products List",
        component: ProductsList,
    },
    {
        path: "/ecommerce/Orders/order-details",
        name: "Order Details",
        component: OrderDetails,
    },
    {
        path: "/ecommerce/Orders/order-list",
        name: "Order List",
        component: OrderList,
    },
    {
        path: "/ecommerce/referral",
        name: "Referral",
        component: Referral,
    },
    {
        path: "/pages/users/reports",
        name: "Reports",
        component: Reports,
    },
    {
        path: "/pages/users/new-user",
        name: "New User",
        component: NewUser,
    },
    {
        path: "/pages/account/settings",
        name: "Settings",
        component: Settings,
    },
    {
        path: "/pages/account/billing",
        name: "Billing",
        component: Billing,
    },
    {
        path: "/pages/account/invoice",
        name: "Invoice",
        component: Invoice,
    },
    {
        path: "/pages/account/Security",
        name: "Security",
        component: Security,
    },
    {
        path: "/authentication/signin/basic",
        name: "Signin Basic",
        component: Basic,
    },
    {
        path: "/authentication/signin/cover",
        name: "Signin Cover",
        component: Cover,
    },
    {
        path: "/authentication/signin/illustration",
        name: "Signin Illustration",
        component: Illustration,
    },
    {
        path: "/authentication/reset/basic",
        name: "Reset Basic",
        component: ResetBasic,
    },
    {
        path: "/authentication/reset/cover",
        name: "Reset Cover",
        component: ResetCover,
    },
    {
        path: "/reset-password/:token",
        name: "Reset Password",
        component: ResetVerify,
    },
    {
        path: "/authentication/reset/illustration",
        name: "Reset Illustration",
        component: ResetIllustration,
    },
    {
        path: "/authentication/lock/basic",
        name: "Lock Basic",
        component: lockBasic,
    },
    {
        path: "/authentication/lock/cover",
        name: "Lock Cover",
        component: lockCover,
    },
    {
        path: "/authentication/lock/illustration",
        name: "Lock Illustration",
        component: lockIllustration,
    },
    {
        path: "/authentication/verification/basic",
        name: "Verification Basic",
        component: VerificationBasic,
    },
    {
        path: "/enter-registation-key",
        name: "Verification",
        component: VerificationCover,
    },
    {
        path: "/authentication/verification/illustration",
        name: "Verification Illustration",
        component: VerificationIllustration,
    },
    {
        path: "/authentication/signup/basic",
        name: "Signup Basic",
        component: SignupBasic,
    },
    {
        path: "/authentication/signup/cover",
        name: "Signup Cover",
        component: SignupCover,
    },
    {
        path: "/authentication/signup/illustration",
        name: "Signup Illustration",
        component: SignupIllustration,
    },
    {
        path: "/authentication/error/error404",
        name: "Error Error404",
        component: Error404,
    },
    {
        path: "/authentication/error/error500",
        name: "Error Error500",
        component: Error500,
    },
    {
        path: "/trips/view",
        name: "View Trips",
        component: viewTrips,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/gallery",
        name: "View Trips Images Gallery",
        component: viewGallery,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/inbound/view",
        name: "View Inbound Programs",
        component: viewInboundPrograms,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/inbound_programs/list",
        name: "List Inbound Programs",
        component: listInboundPrograms,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/inbound_programs/create",
        name: "Create Inbound Program",
        component: createInboundProgram,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/view",
        name: "View Upcoming Flights",
        component: viewFlights,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/outbound/calendar",
        name: "View Outbound Flights Calendar",
        component: viewOutboundFlightsCalendar,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/inbound/calendar",
        name: "View Inbound Flights Calendar",
        component: viewInboundFlightsCalendar,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/:id",
        name: "View Trip Flight Details",
        component: viewFlightDetails,
        props: true,
        requiresAuth: true,
    },
    {
        path: "/flights/inbound/:id",
        name: "View Inbound Trip Flight Details",
        component: vewInboundFlightDetails,
        props: true,
        requiresAuth: true,
    },
    {
        path: "/flights/add",
        name: "Add New Flight",
        component: addFlight,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/viewinbound",
        name: "View Upcoming Inbound Flights",
        component: viewInboundFlights,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/flights/addinbound",
        name: "Add New Inbound Flight",
        component: addInboundFlight,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/outbound",
        name: "View Outbound Programs",
        component: viewOutbound,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/:id",
        name: "View Trip Details",
        component: viewTripDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/add",
        name: "Create Outbound Trip",
        component: addTrip,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/itinerary/add",
        name: "Add Itinerary",
        component: addItenerary,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/partners/add",
        name: "Add Partner",
        component: addPartner,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/partners/outbound/view",
        name: "View Outbound Partners",
        component: viewOutboundPartners,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/partners/inbound/view",
        name: "View Inbound Partners",
        component: viewInboundPartners,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/itinerary/view",
        name: "View Itinerary",
        component: viewItenerary,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/itinerary/:id",
        name: "Edit Itinerary",
        component: iteneraryDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/partners/:id",
        name: "Edit Partner",
        component: partnerDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/itinerary/duplicate/:id",
        name: "Duplicate Itinerary",
        component: iteneraryDuplicate,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/itinerary/delete/:id",
        name: "Delete Itinerary",
        component: iteneraryDelete,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/trips/delete/:id",
        name: "Delete Trip",
        component: tripDelete,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/locations/view",
        name: "View Locations",
        component: viewLocations,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/locations/add",
        name: "Add Location",
        component: addLocation,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/locations/:id",
        name: "Edit Details",
        component: locationDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/admins",
        name: "View Admins",
        component: viewAdmins,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/all",
        name: "View All Users",
        component: viewAll,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/students/:studenttype",
        name: "View Students",
        component: viewStudentsInbound,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/traveler/:id",
        name: "Traveler Details",
        component: viewStudentDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/traveler/trips",
        name: "Traveler Details",
        component: TravelerTrips,
        props: true,
        meta: {
            requiresAuth: true,
        },

    },
    {
        path: "/groupleader/:id",
        name: "Group Leader Details",
        component: viewGroupLeaderDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/coordinator/:id",
        name: "Local Coordinator Details",
        component: viewLocalCoordinatorDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/hosts",
        name: "View Hosts",
        component: viewHosts,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/coordinators",
        name: "View Local Coordinators",
        component: viewCoordinators,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/group_leaders",
        name: "View Group Leaders",
        component: viewGroupLeaders,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: "/admins/:id",
        name: "View Admin User Details",
        component: viewAdminDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/admins/add",
        name: "Add Users",
        component: addAdmin,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/payments/view",
        name: "View Program Payments",
        component: viewPayments,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/payments/:id",
        name: "View Program Payment Details",
        component: viewPaymentDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/checklist/view",
        name: "View Forms",
        component: viewCheckLists,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/checklist/add",
        name: "Add Form",
        component: addCheckList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/checklist/:id",
        name: "View Form Details",
        component: viewCheckListDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/auth/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/messaging/view",
        name: "View Messages",
        component: viewMessaging,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/messaging/:id",
        name: "View Admin Message Details",
        component: viewMessageDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/messaging/add",
        name: "Send New Message",
        component: addMessage,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/school/view",
        name: "View Schools",
        component: viewSchool,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/school/add",
        name: "Add School",
        component: addSchool,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/school/:id",
        name: "View School Details",
        component: viewSchoolDetails,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Reports - Marcus
     */
    {
        path: "/reports/view",
        name: "View Reports",
        component: reportsView,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/reports/generate",
        name: "Generate Report",
        component: generateReports,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    /*
     * Invoices - Dennis
     */
    {
        path: "/invoices/view",
        name: "List Invoices",
        component: listInvoices,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/invoices/:id",
        name: "View invoice",
        component: viewInvoice,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/invoices/add",
        name: "Create invoice",
        component: createInvoice,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Traveler Dahsboard - Marcus
     */
    {
        path: "/dashboards/traveler",
        name: "Traveler Dashboard",
        component: TravelerDash,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/traveler/payment-method/:id",
        name: "Traveler Payment Method",
        component: travelerPaymentMethod,
        props: true,
        meta: {
            requiresAuth: true,
        },
    },

    /**
     * Travelers consent Policy - Auroiah
     */
    {
        path: "/travelers/policy/terms-conditons",
        name: "Terms and Conditions",
        component: termsAndConditions,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Travelers Parent consent policy - Auroiah
     */
    {
        path: "/travelers/policy/parent-consent",
        name: "Parental Consent",
        component: parentalConsentForm,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Travelers student CoC policy - Auroiah
     */
    {
        path: "/travelers/policy/student-coc",
        name: "Student Code of Conduct",
        component: studentCoC,
        meta: {
            requiresAuth: true,
        },
    },
      /**
     * Travelers cancel policy - Auroiah
     */
    {
        path: "/travelers/policy/cancel-policy",
        name: "Cancellation Policy",
        component: cancelPolicy,
        meta: {
            requiresAuth: true,
        },
    },
       /**
     * Travelers medical insurance policy - Auroiah
     */
    {
        path: "/travelers/policy/medical-insurance",
        name: "Medical Insurance Policy",
        component: medicalInsurancePolicy,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Travelers' form - Auroiah
     */
    {
        path: "/travelers/add",
        name: "Create Traveler",
        component: createTravelerAccount,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     * Travelers' Program form Traveler Information - Auroiah
     */
    {
        path: "/travelers/program/form_traveler",
        name: "Traveler Information",
        component: travelerInformation,
        meta: {
            requiresAuth: true,
        },
    },

    /**
     * Travelers' Program form Health- Auroiah
     */
    {
        path: "/travelers/program/form_health",
        name: "Traveler Health",
        component: travelerHealthForm,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     *  Travelers' Program form Passport- Auroiah
     */
    {
        path: "/travelers/program/passport",
        name: "Traveler Passport",
        component: travelerPassport,
        meta: {
            requiresAuth: true,
        },
    },
    /**
     *  Travelers' Program form Additional Information- Auroiah
     */
    {
        path: "/travelers/program/additional",
        name: "Traveler Additional Information",
        component: additionalInformation,
        meta: {
            requiresAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
    linkActiveClass: "active",
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem("token");
        if (token) {
            next();
        } else {
            next("/auth/login");
        }
    } else {
        // Non-protected route, allow access
        next();
    }
});

export default router;
