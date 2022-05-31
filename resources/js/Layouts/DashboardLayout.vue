<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";

const props = defineProps({ title: String });
</script>

<template>
  <div>
    <div class="bg-white flex flex-row">
      <!-- Page Heading -->
      <!-- <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header> -->

      <!-- Page Content -->
      <Sidebar />
      <div
        class="flex flex-col justify-start items-start h-screen overflow-auto w-[calc(100vw-18rem)]">
        <!-- Header -->
        <div
          class="bg-white w-full border-black/15 shadow-black/10 shadow-sm border-b flex flex-row items-center px-8 py-4 relative z-10">
          <div class="">
            <h1 class="font-inter text-2xl text-blue-600 font-semibold">
              {{ props.title }}
            </h1>
          </div>
        </div>
        <main
          class="bg-white flex-1 flex flex-col space-y-4 py-8 w-full border-b shadow-sm">
          <slot />
        </main>
        <footer class="w-full py-4">
          <div class="text-center font-semibold font-inter">
            <h6><span class="text-blue-600">Hafez Almirza</span> @ 2022</h6>
          </div>
        </footer>
      </div>
    </div>
  </div>
</template>
