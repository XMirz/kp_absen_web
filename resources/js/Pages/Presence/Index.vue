<script setup>
import moment from "moment";
import Swal from "sweetalert2";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import VueHtmlToPaper from "vue-html-to-paper";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import MonthlyReportSectionVue from "@/Components/Presence/MonthlyReportSection.vue";
import { TrashIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import NavLink from "@/Components/NavLink.vue";
import { computed } from "vue";
import Label from "@/Components/Label.vue";
import MonthlyReportSection from "@/Components/Presence/MonthlyReportSection.vue";
const props = usePage().props.value;

const todayStaffsPresences = props.todayStaffsPresences;
// change momentJS locale
moment.locale("id");
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Presensi Pegawai">
    <section
      class="space-y-4 border-black/15 shadow-black/10 shadow-sm border-b px-8 pb-8">
      <h1 class="font-sans text-xl font-semibold text-gray-700">
        Presensi Pegawai hari ini,
        <span class="text-blue-600">{{
          moment(props.today).format("dddd DD MMMM yy")
        }}</span>
      </h1>
      <!-- {{ staffsPresence[1] }} -->
      <div class="overflow-x-auto w-full pb-4">
        <table class="table w-full">
          <thead class="text-center">
            <tr class="font-poppins">
              <th
                scope="col"
                rowspan="2"
                class="!static font-semibold border-b-0 border-r border-black/10">
                #
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-semibold border-b-0 border-r border-black/10">
                Nama pegawai
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-semibold border-b-0 border-r border-black/10">
                NIP
              </th>
              <th
                scope="col"
                colspan="3"
                class="font-semibold border-b border-r border-black/10">
                Presensi
              </th>
              <th scope="col" rowspan="2" class="font-semibold">Aksi</th>
            </tr>
            <tr class="font-poppins">
              <th class="font-semibold border-b-0 border-r border-black/10">
                Jenis
              </th>
              <th class="font-semibold border-b-0 border-r border-black/10">
                Masuk
              </th>
              <th class="font-semibold border-b-0 border-r border-black/10">
                Keluar
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(staff, index) in todayStaffsPresences"
              v-bind:key="index">
              <td class="">
                {{ index + 1 }}
              </td>
              <td class="">{{ staff.name }}</td>
              <td class="">{{ staff.nip ?? "" }}</td>
              <td class="">{{ todayPresenceStatus(staff.todayPresence) }}</td>
              <td class="">
                {{ getCheckInOutTime(staff.todayPresence, "checkInTime") }}
              </td>
              <td class="">
                {{ getCheckInOutTime(staff.todayPresence, "checkOutTime") }}
              </td>
              <td>
                <div class="flex flex-row justify-around">
                  <!-- <button
                    class="py-2 px-2 cursor-pointer rounded-md shadow-md"
                    @click="
                      deleteRow('', staff.id, 'Hapus ' + staff.name + ' ?')
                    ">
                    <TrashIcon class="h-5 w-5 text-red-500" />
                  </button> -->
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <MonthlyReportSection
      :reportYearsMonths="props.yearsMonths"></MonthlyReportSection>
  </DashboardLayout>
</template>

<script>
export default {
  methods: {
    // Function to generate hourMinute for checkInOutTime
    getCheckInOutTime(presence, time) {
      if (presence == null) {
        return "-";
      }
      if (presence[time] == null) {
        return "-";
      } else {
        return moment(presence[time]).format("HH:mm");
      }
    },
    // Function to chceck and return status string;
    todayPresenceStatus(presence) {
      if (presence == null) {
        return "Absen";
      } else if (presence.checkInTime == null) {
        return "Absen";
      } else if (presence.inArea) {
        return "Kantor";
      } else {
        return "Lapangan";
      }
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
          this.$inertia.delete("/staffs/" + id, {});
        }
      });
    },
  },
};
</script>
