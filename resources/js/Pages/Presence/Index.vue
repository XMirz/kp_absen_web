<script setup>
import moment from "moment";
import Swal from "sweetalert2";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import { CheckIcon } from "@heroicons/vue/outline";
import VueHtmlToPaper from "vue-html-to-paper";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { TrashIcon, EyeIcon, CalendarIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import NavLink from "@/Components/NavLink.vue";
import { computed } from "vue";
import Label from "@/Components/Label.vue";
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
                <div class="flex flex-row gap-x-1 justify-around">
                  <a
                    :href="route('presence.show', { user: staff.id })"
                    target="_blank"
                    class="py-2 px-2 bg-amber-500 cursor-pointer rounded-md shadow-md">
                    <CalendarIcon class="h-5 w-5 text-white" />
                  </a>
                  <template
                    v-if="
                      staff.todayPresence != null &&
                      staff.todayPresence.type != 'inArea'
                    ">
                    <a
                      :href="
                        'http://www.google.com/maps/place/' +
                        JSON.parse(staff.todayPresence.checkInLocation)
                          .latitude +
                        ',' +
                        JSON.parse(staff.todayPresence.checkInLocation)
                          .longitude
                      "
                      target="_blank"
                      class="py-2 px-2 bg-gray-500 cursor-pointer rounded-md shadow-md">
                      <EyeIcon class="h-5 w-5 text-white" />
                    </a>
                    <button
                      v-if="staff.todayPresence.isVerified == false"
                      class="py-2 px-2 bg-green-500 cursor-pointer rounded-md shadow-md"
                      @click="
                        swal(
                          'verify',
                          staff.todayPresence.id,
                          'Verifikasi presensi ' + staff.name + ' ?'
                        )
                      ">
                      <CheckIcon class="h-5 w-5 text-white" />
                    </button>
                    <button
                      v-if="staff.todayPresence.isVerified == false"
                      class="py-2 px-2 bg-red-500 cursor-pointer rounded-md shadow-md"
                      @click="
                        swal(
                          'delete',
                          staff.todayPresence.id,
                          'Hapus presensi ' + staff.name + ' ?'
                        )
                      ">
                      <TrashIcon class="h-5 w-5 text-white" />
                    </button>
                  </template>
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
    // Function to generate hourMinute for checkInOutTime
    getCheckInOutTime(presence, time) {
      if (presence == null) {
        return "-";
      }
      if (presence[time] == null) {
        return "-";
      } else {
        return moment(presence[time]).subtract(7, "hours").format("HH:mm");
      }
    },
    // Function to chceck and return status string;
    todayPresenceStatus(presence) {
      if (presence == null) {
        return "Absen";
      } else if (presence.checkInTime == null) {
        return "Absen";
      } else if (presence.type == "inArea") {
        return "Kantor";
      } else if (presence.type == "diseased") {
        return "Sakit";
      } else if (presence.type == "permit") {
        return "Izin";
      } else {
        return "Lapangan";
      }
    },
    swal(type, id, title, subtitle) {
      function onFinish(type) {
        Swal.fire({
          title: "Berhasil",
          text: `Data presensi pegawai ${
            type == "delete" ? "dihapus" : "diverifikasi"
          }`,
          icon: "success",
          closeOnClickOutside: false,
        }).then((result) => {
          window.location.reload();
        });
      }
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
          if (type == "delete") {
            this.$inertia.delete("/presences/" + id, {
              onSuccess: () => onFinish(type),
            });
          } else {
            this.$inertia.put(
              "/presences/" + id,
              {},
              {
                onSuccess: () => onFinish(type),
              }
            );
          }
        }
      });
    },
  },
};
</script>
