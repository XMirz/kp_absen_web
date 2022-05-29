<script setup>
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, usePage, useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
import Button from "@/Components/Button.vue";
import SectionHeader from "@/Components/SectionHeader.vue";
import Input from "@/Components/Input.vue";
import Label from "@/Components/Label.vue";
import { InertiaProgress } from "@inertiajs/progress";
("@/Components/SectionHeader.vue");
const { user } = usePage().props.value.auth;
const { defaultPassword } = usePage().props.value;
const form = useForm({
  name: "",
  role: "staff",
  email: "",
  profile: "",
  nip: "",
  gender: "choose",
  address: "",
  birthDate: "",
  password: defaultPassword,
});

const submit = function () {
  form.post(route("staffs.store"), {
    onSuccess: () => {
      Swal.fire({
        title: "Berhasil",
        text: "Data pegawai ditambahkan",
        icon: "success",
        closeOnClickOutside: false,
      });
    },
  });
};
</script>

<template>
  <Head title="Pegawai" />

  <DashboardLayout title="Pegawai">
    <section class="space-y-4 px-8">
      <SectionHeader :title="'Registrasi data pegawai'"></SectionHeader>
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
              required
              v-model="form.nip" />
          </div>
          <div class="">
            <Label for="gender" value="Jenis kelamin" />
            <select
              id="gender"
              name="gender"
              v-model="form.gender"
              required
              class="border-gray-300 focus:border-blue-300 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
              <option disabled value="choose">Pilih</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div v-if="user.roles[0].level <= 2" class="">
            <Label for="role" value="Role" />
            <select
              id="role"
              name="role"
              v-model="form.role"
              required
              class="border-gray-300 focus:border-blue-300 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
              <!-- <option value="dev">Developer</option> -->
              <option v-if="user.roles[0].level < 1" value="chief">
                Kepala bagian
              </option>
              <option v-if="user.roles[0].level < 2" value="admin">
                Administrator
              </option>
              <option value="staff">Pegawai biasa</option>
            </select>
          </div>
        </div>
        <div class="flex-1 flex flex-col gap-y-4">
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
              required
              v-model="form.address" />
          </div>
          <div class="">
            <Label for="birthDate" value="Tanggal lahir" />
            <Input
              id="birthDate"
              type="date"
              class="mt-1 block w-full"
              required
              v-model="form.birthDate" />
          </div>
          <div class="">
            <Label for="password" value="Password (default)" />
            <Input
              id="password"
              type="text"
              class="mt-1 block w-full bg-gray-200"
              disabled
              v-model="form.password" />
          </div>
          <div class="flex flex-row mt-auto justify-end">
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
    debug(thing) {},
  },
};
</script>
