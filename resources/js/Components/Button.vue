<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  class: String,
  type: {
    type: String,
    default: "submit",
  },
});

const classes = computed(
  () =>
    `block px-3 py-2 font-semibold rounded-md bg-blue-500 text-white hover:shadow-blue-600/30 hover:shadow-xl transition-all duration-500 ${props.class}`
);
</script>

<template>
  <button :type="type" :class="classes">
    <slot />
  </button>
</template>
