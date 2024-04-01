<template>
  <policy-container policy-title="Student Code Of Conduct">
    <div class="row">
      <div class="col-10 p-2 mx-auto">
        <p class="font-weight-light text-left w-100 block">
          When you travel abroad you are representing your family, school,
          community and country, so do your best to leave a good impression! It’s
          important to keep an open mind, adapt to the foreign culture and always
          behave appropriately. In order to achieve this you must adhere to these
          Live N Learn policies:
        </p>
      </div>
      <div class="row">
        <div class="col-10 p-2 mx-auto">
          <ul class="list-group list-group-flush p-2 mx-auto">
            <li>
              <p class="font-weight-light text-left w-100 block ">
                If I am traveling to a country that speaks a different language, I will do my best to improve the target
                language and use it as much as possible. I will make a constant effort to embrace the target language
                and
                culture of the destination country.
              </p>

            </li>
            <li>
              <p class="font-weight-light text-left w-100 block ">

                I will respect Live N Learn rules and those of my group leaders,
                chaperones, tour guides, host family, etc.
              </p>

            </li>
            <li>
              <p class="font-weight-light text-left w-100 block ">
                I will not partake in behavior that is detrimental to my health,
                welfare or safety or to that of others.
              </p>

            </li>
            <li>
              <p class="font-weight-light text-left w-100 block ">
                I will always be courteous and congenial, even when I encounter
                inconveniences or things I don’t like. I will be flexible when plans
                must be changed.
              </p>

            </li>
            <li>
              <p class="font-weight-light text-left w-100 block ">I will also arrive on time when a meeting time has
                been set and will
                respect any curfews set by Live N Learn, my group leaders or host
                family.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">Once Group Leaders have done the nightly check-ins, I
                will not exit my
                room or enter into any other hotel rooms besides the one to which I’m
                assigned unless in case of emergency. Additionally, I will not enter
                the room of someone of the opposite sex.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will dress appropriately and wear respectful and
                neat attire.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will not drink alcohol, smoke tobacco, vape, or
                consume any illegal
                drugs.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will not buy, bring or carry any type of weapon,
                including knives,
                firearms, firecrackers, etc.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will not engage in any form of sexual contact or
                relationship.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will attend all group meals and activities, unless
                I’ve received
                permission from my group leader.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will not rent or drive any type of motor vehicle or
                be a passenger
                on a motorcycle/scooter.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">I will keep my hotel rooms and buses clean and will
                not damage
                anything. I understand that I am responsible for anything damaged,
                stolen or consumed in my hotel room.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block "> I will never go off on my own or in a group without
                my group leader’s
                permission.</p>

            </li>
            <li class="p-2">
              <p class="font-weight-light text-left w-100 block ">For a trip that includes a homestay experience: I will
                try to engage
                with my host family and will limit the use of my mobile phone while
                spending time with them.</p>

            </li>
          </ul>
        </div>
      </div>
      <div class="row p-4">
        <div class="col-10 p-2 mx-auto">
          <p class="fw-bolder text-center">

            I agree to adhere to all of these guidelines and understand that
            violations will result in disciplinary action and possibly expulsion
            from the program at my own expense.
          </p>
        </div>
      </div>


    </div>
    <div class="row">
      <div class="col-md-12">
        <signature-pad formId="4"></signature-pad>
      </div>
    </div>
  </policy-container>


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
