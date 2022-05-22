<script setup>
import NavLink from "@/Components/NavLink.vue";
</script>
<template>
  <aside
    class="bg-white border-black/15 shadow-black/10 shadow-md border-r w-72 py-8 !h-screen font-inter">
    <div class="flex h-full flex-col">
      <div class="flex-1 px-2 font-medium space-y-2 w-full">
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
      </div>
      <div class="font-poppins px-4 space-x-4 flex flex-row">
        <img
          src="{{ asset('images/logo_kota_pekanbaru.png') }}"
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
