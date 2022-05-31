<script setup>
import moment from "moment";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import { TrashIcon } from "@heroicons/vue/outline";
import DeleteButton from "@/Components/DeleteButton.vue";
import NavLink from "@/Components/NavLink.vue";
import { computed } from "vue";
import Label from "@/Components/Label.vue";
import axios from "axios";
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
    <section class="space-y-4 px-8">
      <h1 class="font-sans text-xl font-semibold text-gray-700">
        Laporan bulanan
      </h1>
      <div class="flex flex-row justify-start gap-x-8">
        <div class="w-1/4">
          <Label for="year" value="Tahun" />
          <select
            id="year"
            name="year"
            v-model="selectedReportYear"
            @change="updateReportMonths"
            class="border-gray-300 focus:border-blue-300 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
            <template v-for="(year, index) in reportYears" :key="index">
              <option :value="year">
                {{ year }}
              </option>
            </template>
          </select>
        </div>
        <div class="w-1/4">
          <Label for="month" value="Bulan" />
          <select
            id="month"
            name="month"
            v-model="selectedReportMonth"
            @click="fetchReportMonth"
            class="border-gray-300 focus:border-blue-300 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
            <template
              v-for="(monthNumber, index) in Object.keys(reportMonths)"
              :key="index">
              <option :value="monthNumber">
                {{ this.reportMonths[monthNumber] }}
              </option>
            </template>
          </select>
        </div>
      </div>

      <div class="">
        <h2 class="text-lg font-semibold">
          Rekapitulasi bulan
          {{ moment(day).format("MMMM") + " tahun " + moment(day).format("Y") }}
        </h2>
      </div>
      <!-- Table  -->
      <div class="overflow-x-auto w-full pb-4">
        <table class="table w-full">
          <thead class="text-center">
            <tr class="font-poppins">
              <th
                scope="col"
                rowspan="2"
                class="!static font-normal border-b-0 border-r border-black/10">
                #
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-normal border-b-0 border-r border-black/10">
                Nama pegawai
              </th>
              <th
                scope="col"
                :colspan="totalDaysInMonth"
                class="font-normal border-b border-r border-black/10">
                Tanggal
              </th>
            </tr>
            <tr>
              <th
                v-for="(day, index) in daysInMonth"
                :key="index"
                class="!static font-normal border-b-0 border-r border-black/10 py-2 px-2"
                :class="day.isWeekend == true ? 'bg-red-500' : ''">
                {{ moment(day["date"]).format("D") }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(staffsPresences, indexStaff) in monthlyStaffsPresences"
              :key="indexStaff">
              <td>{{ indexStaff + 1 }}</td>
              <td>
                {{ staffsPresences.name }}
              </td>
              <template v-for="(day, index) in daysInMonth" :key="index">
                <td class="py-2 px-2">
                  <span
                    v-for="(presence, j) in relatedStaffPresence(
                      indexStaff,
                      day.date
                    )"
                    :key="j"
                    >🗸</span
                  >
                </td>
              </template>
            </tr>
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
      selectedReportYear: "",
      selectedReportMonth: "",
      reportYearsMonth: usePage().props.value.yearsMonths, // Array of years, that array of month
      day: "", // Used to generate month and year name by moment js
      totalDaysInMonth: 30,
      daysInMonth: [],
      reportYears: [],
      reportMonths: {},
      monthlyStaffsPresences: {}, // Object ,Changed when year selected ,
    };
  },
  computed: {
    // Calculate if presence and staff is related
  },
  mounted() {
    let newReportYear = [];
    Object.keys(this.reportYearsMonth).forEach(function (year) {
      newReportYear.push(year);
    });
    // Set avaible years and set selected
    this.reportYears = newReportYear;
    this.selectedReportYear = this.reportYears[this.reportYears.length - 1];

    this.updateReportMonths();
  },
  methods: {
    async updateReportMonths() {
      // Selected year update by vue internally
      this.reportMonths = this.reportYearsMonth[this.selectedReportYear];
      // Set avaible for selected years and set selected
      let reportMonthsKeys = Object.keys(this.reportMonths);
      this.selectedReportMonth = reportMonthsKeys[0];
      this.fetchReportMonth();
    },
    async fetchReportMonth() {
      let response = await axios.get(
        `/api/presence/?year=${this.selectedReportYear}&month=${this.selectedReportMonth}`
      );

      if (response.status == 200) {
        let res = JSON.parse(JSON.stringify(response.data));
        // update, if there is no month or year provider on ther request., so its will return current month
        this.day = res["day"];
        this.selectedReportYear = res["year"];
        this.selectedReportMonth = res["month"];

        this.daysInMonth = res["daysInMonth"];
        this.totalDaysInMonth = res["totalDaysInMonth"];
        this.monthlyStaffsPresences = res["staffsMonthlyPresences"];
      }
      console.log(this.monthlyStaffsPresences);
      window.shit = this.monthlyStaffsPresences;
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
    // Fuction to filter presence of user array
    relatedStaffPresence(staffIndex, date) {
      return this.monthlyStaffsPresences
        .at(staffIndex)
        .presences.filter((presence) => {
          return (
            moment(presence.checkInTime).format("D") == moment(date).format("D")
          );
        });
    },
  },
};
</script>
