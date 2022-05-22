<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() =>
  props.active
    ? "block px-4 py-2 rounded-md bg-blue-500 text-white"
    : "block px-4 py-2 rounded-md"
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
