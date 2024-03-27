<template>
  <policy-container policy-title="Student Code Of Conduct">
    <div class="container-fluid">
      <p class="text-break">
        When you travel abroad you are representing your family, school,
        community and country, so do your best to leave a good impression! It’s
        important to keep an open mind, adapt to the foreign culture and always
        behave appropriately. In order to achieve this you must adhere to these
        Live N Learn policies:
      </p>
      <ul class="list-group list-group-flush p-2 mx-auto">
        <li class="p-2">
          If I am traveling to a country that speaks a different language, I
          will do my best to improve the target language and use it as much as
          possible. I will make a constant effort to embrace the target language
          and culture of the destination country.
        </li>
        <li class="p-2">
          I will respect Live N Learn rules and those of my group leaders,
          chaperones, tour guides, host family, etc.
        </li>
        <li class="p-2">
          I will not partake in behavior that is detrimental to my health,
          welfare or safety or to that of others.
        </li>
        <li class="p-2">
          I will always be courteous and congenial, even when I encounter
          inconveniences or things I don’t like. I will be flexible when plans
          must be changed.
        </li>
        <li class="p-2">
          I will also arrive on time when a meeting time has been set and will
          respect any curfews set by Live N Learn, my group leaders or host
          family.
        </li>
        <li class="p-2">
          Once Group Leaders have done the nightly check-ins, I will not exit my
          room or enter into any other hotel rooms besides the one to which I’m
          assigned unless in case of emergency. Additionally, I will not enter
          the room of someone of the opposite sex.
        </li>
        <li class="p-2">
          I will dress appropriately and wear respectful and neat attire.
        </li>
        <li class="p-2">
          I will not drink alcohol, smoke tobacco, vape, or consume any illegal
          drugs.
        </li>
        <li class="p-2">
          I will not buy, bring or carry any type of weapon, including knives,
          firearms, firecrackers, etc.
        </li>
        <li class="p-2">
          I will not engage in any form of sexual contact or relationship.
        </li>
        <li class="p-2">
          I will attend all group meals and activities, unless I’ve received
          permission from my group leader.
        </li>
        <li class="p-2">
          I will not rent or drive any type of motor vehicle or be a passenger
          on a motorcycle/scooter.
        </li>
        <li class="p-2">
          I will keep my hotel rooms and buses clean and will not damage
          anything. I understand that I am responsible for anything damaged,
          stolen or consumed in my hotel room.
        </li>
        <li class="p-2">
          I will never go off on my own or in a group without my group leader’s
          permission.
        </li>
        <li class="p-2">
          For a trip that includes a homestay experience: I will try to engage
          with my host family and will limit the use of my mobile phone while
          spending time with them.
        </li>
      </ul>
      <p class="fw-bolder text-center">
        <ins>
          I agree to adhere to all of these guidelines and understand that
          violations will result in disciplinary action and possibly expulsion
          from the program at my own expense.</ins
        >
      </p>
    </div>
    <div class="row">
      <div class="col-md-12"></div>
    </div>
  </policy-container>

  <signature-pad has-traveler="true"></signature-pad>
</template>
<script>
import SignaturePad from "../policies/signaturePad.vue";
import PolicyContainer from "../policies/policyContainer.vue";

export default {
  components: {
    SignaturePad,
    PolicyContainer,
  },
};
</script>
