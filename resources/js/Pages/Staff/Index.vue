<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import { TrashIcon, PlusSmIcon, PencilIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import SectionHeader from "@/Components/SectionHeader.vue";
const staffs = usePage().props.value.staffs;
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
      <div class="overflow-x-auto w-full pb-4">
        <table class="table w-full">
          <thead>
            <tr class="font-poppins">
              <th scope="col" class="!static font-semibold">#</th>
              <th scope="col" class="font-semibold">NIP</th>
              <th scope="col" class="font-semibold">Nama</th>
              <th scope="col" class="font-semibold">Alamat</th>
              <th scope="col" class="font-semibold">Tanggal lahir</th>
              <th scope="col" class="font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(staff, index) in staffs" v-bind:key="index">
              <td class="">
                {{ index + 1 }}
              </td>
              <td class="">{{ staff.nip ?? "" }}</td>
              <td class="">{{ staff.name }}</td>
              <td class="">
                {{ staff.address }}
              </td>
              <td class="">{{ staff.birthDate }}</td>
              <td>
                <div class="flex flex-row gap-x-1 ustify-around">
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
          </tbody>
        </table>
      </div>
    </section>
  </DashboardLayout>
</template>

<script>
export default {
  methods: {
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
          this.$inertia.delete("/staffs/" + id, {});
        }
      });
    },
  },
};
</script>
