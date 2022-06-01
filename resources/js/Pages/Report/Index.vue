<script setup>
import axios from "axios";
import moment from "moment";
import Button from "@/Components/Button.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
// change momentJS locale
moment.locale("id");
</script>

<template>
  <DashboardLayout>
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
        <div class="">
          <Button>Cetak</Button>
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
                Nama
              </th>
              <th
                scope="col"
                rowspan="2"
                class="font-normal border-b-0 border-r border-black/10">
                Jabatan
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
                :class="
                  (day.isWeekend == true ? 'bg-yellow-500' : '') ||
                  (day.isHoliday == true ? 'bg-red-500' : '')
                ">
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
              <td>
                {{ staffsPresences.roles[0].title }}
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
      console.log(this.monthlyStaffsPresences);
      window.shit = this.monthlyStaffsPresences;
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
