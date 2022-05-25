<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { TrashIcon } from "@heroicons/vue/outline";
</script>

<template>
  <button class="py-2 px-2 cursor-pointer rounded-md shadow-md">
    <TrashIcon class="h-5 w-5 text-red-500" />
  </button>
</template>
