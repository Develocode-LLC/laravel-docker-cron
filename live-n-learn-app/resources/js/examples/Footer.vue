<template>
  <footer class="py-3 footer">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="mb-4 col-lg-6 mb-lg-0">
          <div
            class="text-sm text-center copyright text-muted"
            :class="$store.state.isRTL ? 'text-lg-end' : 'text-lg-start'"
          >
            ©
            {{ new Date().getFullYear() }} Live N Learn
          </div>
        </div>
        <div class="col-lg-6">
          <ul
            class="nav nav-footer justify-content-center justify-content-lg-end"
          >
            <li class="nav-item">
              <a
                href="#"
                class="nav-link text-muted"
                target="_blank"
                >Help</a
              >
            </li>
            <li class="nav-item">
              <a
                href="#"
                class="nav-link text-muted"
                target="_blank"
                >FAQ</a
              >
            </li>
            <li class="nav-item">
                <a
                  href="#"
                  class="nav-link text-muted"
                  target="_blank"
                  >DOCS</a
                >
              </li>

          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "AppFooter",
};
</script>
