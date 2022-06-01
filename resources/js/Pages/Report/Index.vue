<script setup>
import axios from "axios";
import moment from "moment";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Label.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
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
        <div class="ml-auto flex items-end">
          <Button @click="printReport">Cetak</Button>
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
                class="!static font-normal border border-black/20">
                #
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-normal border border-black/20">
                Nama
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-normal border border-black/20">
                Jabatan
              </th>
              <th
                scope="col"
                :colspan="totalDaysInMonth"
                class="font-normal border border-black/20">
                Tanggal
              </th>
            </tr>
            <tr>
              <th
                v-for="(day, index) in daysInMonth"
                :key="index"
                class="!static font-normal border border-black/20"
                :class="
                  (day.isHoliday == true ? 'bg-red-500' : '') ||
                  (day.isWeekend == true ? 'bg-yellow-500' : '')
                ">
                <div
                  :class="day.isHoliday ? 'tooltip normal-case' : ''"
                  :data-tip="day.isHoliday ? day.holidayName : ''">
                  {{ moment(day["date"]).format("D") }}
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(staffsPresences, indexStaff) in monthlyStaffsPresences"
              :key="indexStaff">
              <td class="font-normal border border-black/20">
                {{ indexStaff + 1 }}
              </td>
              <td class="font-normal border border-black/20">
                {{ staffsPresences.name }}
              </td>
              <td class="font-normal border border-black/20">
                {{ staffsPresences.roles[0].title }}
              </td>
              <template v-for="(day, index) in daysInMonth" :key="index">
                <td
                  class="text-center font-normal border border-black/20"
                  :class="
                    (day.isHoliday == true ? 'bg-red-500' : '') ||
                    (day.isWeekend == true ? 'bg-yellow-500' : '')
                  ">
                  <template v-if="!(day.isWeekend || day.isHoliday)">
                    <span
                      v-for="(presence, j) in relatedStaffPresence(
                        indexStaff,
                        day.date
                      )"
                      :key="j"
                      >🗸</span
                    >
                  </template>
                </td>
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
  props: ["reportYearsMonths"],
  data() {
    return {
      selectedReportYear: "",
      selectedReportMonth: "",
      reportYearsMonths: this.$props.reportYearsMonths, // Array of years, that array of month
      day: "", // Used to generate month and year name by moment js
      totalDaysInMonth: 30,
      daysInMonth: [],
      reportYears: [],
      reportMonths: {},
      monthlyStaffsPresences: {}, // Object ,Changed when year selected ,
    };
  },
  mounted() {
    console.log(this.$props.reportYearsMonths);
    let newReportYear = [];
    Object.keys(this.reportYearsMonths).forEach(function (year) {
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
      this.reportMonths = this.reportYearsMonths[this.selectedReportYear];
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
    printReport() {
      window
        .open(
          `${route("report.show")}?year=${this.selectedReportYear}&month=${
            this.selectedReportMonth
          }`,
          "_blank"
        )
        .focus();
    },
  },
};
</script>
