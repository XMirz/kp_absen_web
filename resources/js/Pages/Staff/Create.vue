<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import ButtonLink from "@/Components/ButtonLink.vue";
import SectionHeader from "@/Components/SectionHeader.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
("@/Components/SectionHeader.vue");
const staffs = usePage().props.value.staffs;
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Pegawai">
    <section class="space-y-4 px-8">
      <SectionHeader :title="'Tambah data pegawai'"></SectionHeader>
      <form @submit.prevent="submit" class="flex flex-col gap-x-4">
        <div class="">
          <Label for="name" value="Nama" />
          <Input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus />
        </div>
        <div class="">
          <Label for="email" value="Email" />
          <Input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus />
        </div>
      </form>
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
