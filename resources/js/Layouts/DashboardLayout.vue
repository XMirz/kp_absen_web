<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
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
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
