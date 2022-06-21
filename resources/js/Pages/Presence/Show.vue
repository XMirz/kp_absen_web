<script setup>
import axios from "axios";
import moment from "moment";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Label.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { usePage } from "@inertiajs/inertia-vue3";
// change momentJS locale
moment.locale("id");
</script>

<template>
  <DashboardLayout title="Laporan Bulanan">
    <section class="space-y-4 px-8">
      <h1 class="font-sans text-xl font-semibold text-gray-700">
        Rekapitulasi bulan
        {{ moment(day).format("MMMM") + " tahun " + moment(day).format("Y") }}
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

      <!-- Table  -->
      <div class="overflow-x-auto w-full pb-4 space-y-4">
        <table class="table border-collapse table-compact text-base w-full">
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
                Hari
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-semibold border-b-0 border-r border-black/10">
                Tanggal
              </th>
              <th
                scope="col"
                colspan="3"
                class="font-semibold border-b border-r border-black/10">
                Presensi
              </th>
              <th scope="col" rowspan="2" class="font-semibold">Keterangan</th>
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
            <tr v-for="(day, index) in daysInMonth" :key="index">
              <td class="">
                {{ index + 1 }}
              </td>
              <td class="">
                {{ moment(day.date).subtract(7, "hours").format("dddd") }}
              </td>
              <td class="">
                {{ moment(day.date).subtract(7, "hours").format("DD MMMM yy") }}
              </td>
              <template
                v-for="(presence, j) in filterPresenceDate(day.date)"
                :key="j">
                <td>
                  {{ todayPresenceStatus(presence) }}
                </td>
                <td>
                  {{ getCheckInOutTime(presence, "checkOutTime") }}
                </td>
                <td>
                  {{ getCheckInOutTime(presence, "checkOutTime") }}
                </td>
                <td>
                  {{ presence.description ?? "-" }}
                </td>
              </template>
              <template v-if="filterPresenceDate(day.date).length < 1">
                <td>Absen</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
              </template>
            </tr>
          </tbody>
        </table>
        <div class="">
          <div class="flex flex-row items-center justify-end gap-x-2">
            <span>Keterangan :</span>
            <span class="ml-4 w-3 h-3 bg-red-600"></span>
            <span>Hari libur nasional</span>
            <span class="ml-4 w-3 h-3 bg-yellow-500"></span>
            <span>Akhir pekan</span>
          </div>
        </div>
      </div>
    </section>
  </DashboardLayout>
</template>

<script>
export default {
  props: ["reportYearsMonths", "staff"],
  data() {
    return {
      // Get CSRF Token
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      selectedReportYear: "",
      selectedReportMonth: "",
      day: "", // Used to generate month and year name by moment js
      totalDaysInMonth: 30,
      daysInMonth: [],
      reportYears: [],
      reportMonths: {},
      monthlyStaffPresences: {}, // Object ,Changed when year selected ,
    };
  },
  mounted() {
    let newReportYear = [];
    Object.keys(this.$props.reportYearsMonths).forEach(function (year) {
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
      this.reportMonths =
        this.$props.reportYearsMonths[this.selectedReportYear];
      // Set avaible for selected years and set selected
      let reportMonthsKeys = Object.keys(this.reportMonths);
      this.selectedReportMonth = reportMonthsKeys[0];
      this.fetchReportMonth();
    },
    async fetchReportMonth() {
      let url = `/presence/${this.$props.staff.id}/?year=${this.selectedReportYear}&month=${this.selectedReportMonth}`;
      let response = await axios.get(url);
      console.log(url);
      if (response.status == 200) {
        let res = JSON.parse(JSON.stringify(response.data));
        console.log(res);
        // update, if there is no month or year provider on ther request., so its will return current month
        this.day = res["day"];
        this.selectedReportYear = res["year"];
        this.selectedReportMonth = res["month"];

        this.daysInMonth = res["daysInMonth"];
        this.totalDaysInMonth = res["totalDaysInMonth"];
        this.monthlyStaffPresences = res["staffMonthlyPresences"];
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

    // Fuction to filter presence by Date
    filterPresenceDate(loopDate) {
      return this.monthlyStaffPresences.filter((presence) => {
        return (
          moment(presence.checkInTime).format("D") ==
          moment(loopDate).format("D")
        );
      });
    },
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
  },
};
</script>
