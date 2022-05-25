<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import { TrashIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import NavLink from "@/Components/NavLink.vue";
const staffs = usePage().props.value.presences;
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Riwayat Presensi">
    <div
      class="bg-white flex flex-col space-y-4 px-8 py-4 w-full border-b shadow-md">
      <h1 class="font-sans text-xl font-semibold text-gray-700">
        Daftar Pegawai Humas & Prokopim
      </h1>
      <div class="overflow-x-auto w-full">
        <table class="table w-full">
          <thead>
            <tr class="font-poppins">
              <th scope="col" class="font-semibold">#</th>
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
                <div class="flex flex-row justify-around">
                  <button
                    class="py-2 px-2 cursor-pointer rounded-md shadow-md"
                    @click="
                      deleteRow('', staff.id, 'Hapus ' + staff.name + ' ?')
                    ">
                    <TrashIcon class="h-5 w-5 text-red-500" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
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
