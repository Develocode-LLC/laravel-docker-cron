<template>
  <div class="container-fluid" @scroll="checkScroll">
    <div ref="policy-container">
      <div class="col-md-10 card mx-auto">
        <div class="card-body">
          <h6 class="text-center fs-3 m-4 text-info">
            {{ policyTitle }}
          </h6>
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import SignaturePad from "./signaturePad.vue";
export default {
  props: {
    policyTitle: String,
  },
  components: {
    SignaturePad,
  },
  data() {
    return {
      scrolledToBottom: false,
    };
  },
  methods: {
    checkScroll() {
      const container = this.$refs.policyContainer;
      console.log(container);
      console.log("hello");
      if (
        container.scrollHeight - container.scrollTop ===
        container.clientHeight
      ) {
        this.scrolledToBottom = true;
      }
    },
  },
};
</script>
<style>
.policy-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40vh;
  overflow: hidden;
}

.policy-content {
  width: 80%;
  max-height: 100%;
  overflow-y: auto;
  border: 1px solid #ccc;
  padding: 0.75rem;
  scroll-padding: 0.75rem; /* 12px*/
}
</style>
