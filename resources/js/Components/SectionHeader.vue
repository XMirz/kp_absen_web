<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["title"]);
</script>

<template>
  <div class="flex flex-row justify-between items-center text-sm">
    <h1 class="font-sans text-xl font-semibold text-gray-700">
      {{ props.title }}
    </h1>
    <div class="flex flex-row justify-around">
      <slot />
    </div>
  </div>
</template>
