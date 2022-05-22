<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Setelan" />

  <DashboardLayout>
    <div class="">Ini halaman anu coek</div>
    {{ $page.props }}
  </DashboardLayout>
</template>
