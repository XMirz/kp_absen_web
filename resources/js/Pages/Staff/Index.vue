<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import { TrashIcon, PlusSmIcon, PencilIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import SectionHeader from "@/Components/SectionHeader.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
const user = usePage().props.value.auth.user;
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Pegawai">
    <section class="space-y-4 px-8 pb-8">
      <SectionHeader :title="'Daftar Pegawai Humas & Prokopim'">
        <ButtonLink
          :href="route('staffs.create')"
          :active="route().current('*staff*')">
          <span class="flex flex-row gap-x-1 items-center"
            ><PlusSmIcon class="h-5 w-5 px-0 mx-0 text-white-500" />Tambah
            Data</span
          >
        </ButtonLink></SectionHeader
      >
      <div class="flex flex-row justify-end items-center gap-x-4">
        <Label for="search" value="Cari nama" />
        <Input
          id="search"
          type="text"
          name="search"
          v-model="search"
          @keyup="filterStaffs(search)"
          required
          class="mt-1"></Input>
      </div>
      <div class="overflow-x-auto w-full pb-4">
        <table class="table w-full">
          <thead>
            <tr class="font-poppins">
              <th scope="col" class="!static font-semibold">#</th>
              <th scope="col" class="font-semibold">Nama</th>
              <th scope="col" class="font-semibold">NIP</th>
              <th scope="col" class="font-semibold">Alamat</th>
              <th scope="col" class="font-semibold">Role</th>
              <th scope="col" class="font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <template
              v-for="(staff, index) in filteredStaffs"
              v-bind:key="index">
              <tr v-if="staff.roles[0].level != 0">
                <td class="">
                  {{ index + 1 }}
                </td>
                <td class="">
                  {{ staff.name }}
                  <span
                    v-if="staff.name == user.name"
                    class="text-blue-600 font-medium">
                    (Anda)
                  </span>
                </td>
                <td class="">{{ staff.nip ?? "" }}</td>
                <td class="">
                  {{ staff.address }}
                </td>
                <td class="">{{ staff.roles[0].title }}</td>
                <!-- <td class="">{{ staff.birthDate }}</td> -->
                <td>
                  <div
                    v-if="user.roles[0].level <= staff.roles[0].level"
                    class="flex flex-row gap-x-1 ustify-around">
                    <Link
                      class="py-2 px-2 bg-gray-500 cursor-pointer rounded-md shadow-md"
                      :href="route('staffs.edit', staff.id)">
                      <PencilIcon class="h-5 w-5 text-white" />
                    </Link>
                    <button
                      class="py-2 px-2 bg-red-500 cursor-pointer rounded-md shadow-md"
                      @click="
                        deleteRow('', staff.id, 'Hapus ' + staff.name + ' ?')
                      ">
                      <TrashIcon class="h-5 w-5 text-white" />
                    </button>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </section>
  </DashboardLayout>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      staffs: usePage().props.value.staffs,
      filteredStaffs: usePage().props.value.staffs,
    };
  },
  methods: {
    //Filter staffs by search
    filterStaffs(search) {
      var filtered = this.staffs.filter((staff) => {
        if (staff.name.includes(search)) {
          return staff;
        }
      });
      this.filteredStaffs = filtered;
    },
    deleteRow(routes, id, title, subtitle, successTitle, successSubtitle) {
      Swal.fire({
        title: title ?? "Title",
        text: subtitle ?? "",
        icon: "warning",
        showCancelButton: true,
        customClass: {
          confirmButton: "font-poppins font-medium uppercase tracking-wider",
          cancelButton: "font-poppins font-medium uppercase tracking-wider",
        },
        confirmButtonColor: "#22C55E",
        cancelButtonColor: "#ef4444",
        confirmButtonText: "Konfirmasi",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.delete("/staffs/" + id, {
            onFinish: () => {
              Swal.fire({
                title: "Berhasil",
                text: "Data pegawai ditambahkan",
                icon: "success",
                closeOnClickOutside: false,
              }).then((result) => {
                window.location.reload();
              });
            },
          });
        }
      });
    },
  },
};
</script>
