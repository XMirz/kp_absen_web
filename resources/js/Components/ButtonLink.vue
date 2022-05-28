<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["href", "active", "classes"]);

const classes = computed(
  () =>
    `block px-3 py-2 font-semibold rounded-md bg-blue-500 text-white hover:shadow-blue-600/30 hover:shadow-xl transition-all duration-500 ${props.classes}`
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
