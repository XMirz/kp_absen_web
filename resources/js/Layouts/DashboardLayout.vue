<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";

const props = defineProps({ title: String });
</script>

<template>
  <div>
    <div class="bg-gray-50 flex flex-row">
      <!-- Page Heading -->
      <!-- <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header> -->

      <!-- Page Content -->
      <Sidebar />
      <div
        class="flex flex-col justify-start items-start w-[calc(100vw-18rem)]">
        <!-- Header -->
        <div
          class="bg-white w-full border-black/15 shadow-black/10 shadow-sm border-b flex flex-row items-center px-8 py-4 relative z-10">
          <div class="">
            <h1 class="font-inter text-2xl text-blue-600 font-semibold">
              {{ props.title }}
            </h1>
          </div>
        </div>
        <main class="space-y-8 w-full">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
