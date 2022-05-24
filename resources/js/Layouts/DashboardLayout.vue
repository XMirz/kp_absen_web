<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";

const props = defineProps({ title: String });
</script>

<template>
  <div>
    <div class="w-screen min-h-screen bg-gray-50 flex flex-row">
      <!-- Page Heading -->
      <!-- <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header> -->

      <!-- Page Content -->
      <Sidebar />
      <div class="flex flex-col w-full">
        <!-- Header -->
        <div
          class="bg-white w-full shadow-sm flex flex-row items-center px-8 py-4">
          <div class="">
            <h1 class="font-sans text-2xl font-semibold">
              {{ props.title }}
            </h1>
          </div>
        </div>
        <main class="flex flex-col space-y-8 px-8 py-4">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
