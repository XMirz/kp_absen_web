<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";

const props = defineProps({ title: String });
</script>

<template>
  <div class="overflow-auto">
    <slot />
  </div>
</template>
