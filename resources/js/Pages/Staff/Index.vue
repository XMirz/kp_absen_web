<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
const staffs = usePage().props.value.staffs;
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Pegawai">
    <div class="flex flex-col space-y-4">
      <h1 class="font-sans text-xl font-semibold text-gray-700">
        Daftar Pegawai Humas & Prokopim
      </h1>
      <table class="">
        <thead>
          <tr>
            <th>#</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal lahir</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(staff, index) in staffs" v-bind:key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ "NIP" }}</td>
            <td>{{ staff.name }}</td>
            <td>{{ staff.address }}</td>
            <td>{{ staff.birthDate }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </DashboardLayout>
</template>
