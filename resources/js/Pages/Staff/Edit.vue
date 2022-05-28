<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import Button from "@/Components/Button.vue";
import SectionHeader from "@/Components/SectionHeader.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
("@/Components/SectionHeader.vue");
const staff = usePage().props.value.staff;
const form = useForm({
  name: staff.name,
  email: staff.email,
  profile: staff.profile,
  nip: staff.nip,
  gender: staff.gender,
  address: staff.address,
  birthDate: staff.birthDate,
});

const submit = () => {
  if (form.name != "" && form.email) {
    form.post(route("staffs.update", staff), {});
  }
};
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Pegawai">
    <section class="space-y-4 px-8">
      <SectionHeader :title="'Tambah data pegawai'"></SectionHeader>
      <form @submit.prevent="submit" class="flex flex-row gap-x-8">
        <!-- Left -->
        <div class="flex-1 space-y-4">
          <div class="">
            <Label for="name" value="Nama" />
            <Input
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus />
          </div>
          <div class="">
            <Label for="nip" value="NIP" />
            <Input
              id="nip"
              type="text"
              class="mt-1 block w-full"
              v-model="form.nip" />
          </div>
          <div class="">
            <Label for="gender" value="Jenis kelamin" />
            <select
              id="gender"
              name="gender"
              v-model="form.gender"
              :onchange="debug(form.gender)"
              class="border-gray-300 focus:border-blue-300 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
        </div>
        <div class="flex-1 space-y-4">
          <div class="">
            <Label for="email" value="Email" />
            <Input
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required />
          </div>
          <div class="">
            <Label for="address" value="Alamat" />
            <Input
              id="address"
              type="text"
              class="mt-1 block w-full"
              v-model="form.address" />
          </div>
          <div class="">
            <Label for="birthDate" value="Tanggal lahir" />
            <Input
              id="birthDate"
              type="date"
              class="mt-1 block w-full"
              v-model="form.birthDate" />
          </div>
          <div class="pt-3 flex flex-row justify-end">
            <Button> Simpan</Button>
          </div>
        </div>
      </form>
    </section>
  </DashboardLayout>
</template>

<script>
export default {
  methods: {
    debug(thing) {
      console.log(thing);
    },
  },
};
</script>
