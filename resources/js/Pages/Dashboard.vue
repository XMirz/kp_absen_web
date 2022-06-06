<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
// import DashboardLayout from "@/Layouts/Authenticated.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
const props = usePage().props.value;
</script>

<template>
  <Head title="Dashboard" />

  <DashboardLayout title="Dasbor">
    <section class="space-y-4 px-8">
      <h1 class="font-sans text-2xl font-bold text-gray-700">
        Selamat datang,
        <span class="text-blue-600">{{ props.auth.user.name }}</span>
      </h1>
      <div class="flex flex-row gap-x-8">
        <!-- Card -->
        <div
          class="min-w-[18rem] flex flex-col shadow-md px-8 py-4 rounded-lg gap-y-2 text-blue-600">
          <h2 class="text-lg font-poppins font-semibold">Jumlah Pegawai</h2>
          <div class="self-end">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-12 w-12"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="font-bold text-lg text-gray-600">
            {{ props.staffsCount ?? "0" }}
          </h2>
        </div>
        <!-- Card -->
        <div
          class="min-w-[18rem] flex flex-col shadow-md px-8 py-4 rounded-lg gap-y-2 text-blue-600">
          <h2 class="text-lg font-poppins font-semibold">Presensi Hari Ini</h2>
          <div class="self-end">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-12 w-12"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h2 class="font-bold text-lg text-gray-600">
            {{ `${props.todayPresenceCount} / ${props.staffsCount}` }}
          </h2>
        </div>
      </div>
    </section>
  </DashboardLayout>
</template>
