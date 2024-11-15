<template>
  <Layout/>
  <div class="container">
    <router-view></router-view>
  </div>
</template>

<script>
import Layout from '/OSPanel/home/laravel.vue/resources/js/ui/layouts/layout.vue'

export default {
  components: {
    Layout
  }
}
</script>
