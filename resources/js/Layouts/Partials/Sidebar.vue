<script setup>
import { computed } from "vue";
import NavLink from "@/Components/NavLink.vue";
import { usePage } from "@inertiajs/inertia-vue3";
const { user } = usePage().props.value.auth;
const avatarUrl = computed(
  () =>
    "https://ui-avatars.com/api/?background=0D8ABC&color=fff&size=96&name=" +
    user.name
);
</script>
<template>
  <aside
    class="bg-white border-black/15 shadow-black/10 shadow-md border-r w-72 py-8 !h-screen font-inter">
    <div class="flex h-full flex-col">
      <div class="flex-1 space-y-6">
        <div
          class="px-2 flex flex-col gap-2 justify-center text-center items-center">
          <img class="rounded-full w-12 h-12" alt="" :src="avatarUrl" />
          <div class="">
            <h6 class="">{{ user.name }}</h6>
            <h6 class="text-gray-600 text-sm">
              {{ user.role == "staff" ? "Pegawai" : "Kepala Bagian" }}
            </h6>
          </div>
        </div>
        <div class="px-2 font-medium space-y-2 w-full">
          <NavLink
            :href="route('dashboard')"
            :active="route().current('*dashboard*')">
            Dasbor</NavLink
          >
          <NavLink
            :href="route('staffs.index')"
            :active="route().current('*staff*')">
            Pegawai</NavLink
          >
          <NavLink
            :href="route('staffs.index')"
            :active="route().current('*events*')">
            Jadwal Kegiatan</NavLink
          >
          <NavLink
            :href="route('staffs.index')"
            :active="route().current('*presence*')">
            Absensi</NavLink
          >
          <NavLink
            :href="route('settings.index')"
            :active="route().current('*settings*')">
            Pengaturan</NavLink
          >
        </div>
      </div>
      <!-- Bottom -->
      <div class="font-poppins px-4 space-x-4 flex flex-row">
        <img
          :src="'images/logo_kota_pekanbaru.png'"
          alt="Lambang kota pekanbaru"
          class="w-12 object-contain mx-auto" />
        <div class="">
          <h2 class="text-lg font-semibold uppercase">Humas & Prokopim</h2>
          <h2 class="text-md font-medium leading-5">
            Sekretariat Daerah Kota Pekanbaru
          </h2>
        </div>
      </div>
    </div>
  </aside>
</template>
<script></script>
