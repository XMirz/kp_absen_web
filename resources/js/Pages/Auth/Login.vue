<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Guest from "@/Layouts/Guest.vue";
import Label from "@/Components/Label.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Checkbox from "@/Components/Breeze/Checkbox.vue";
import BreezeValidationErrors from "@/Components/Breeze/ValidationErrors.vue";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

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
  <Guest>
    <div class="flex flex-row w-screen h-screen overflow-hidden">
      <div class="relative w-3/5">
        <div
          class="w-full bg-center bg-[url('/images/bg_walikota.jpg')] h-full">
          <div
            class="
              absolute
              inset-0
              bg-gradient-to-r
              from-black/70
              via-black/30
              to-white
            "></div>
          <div
            class="
              relative
              h-full
              px-32
              py-24
              flex flex-col
              justify-center
              font-poppins
              text-white
            ">
            <div class="flex justify-end">
              <img class="w-48" src="/images/logo_kota_pekanbaru.png" alt="" />
            </div>
            <h1 class="text-6xl font-bold">Sistem Absensi Geolocator</h1>
            <h2 class="text-5xl font-semibold mt-2">Humas dan Prokopim</h2>
            <h2 class="text-4xl font-semibold mt-2">
              Pemerintah Kota Pekanbaru
            </h2>
          </div>
        </div>
      </div>
      <div class="h-full w-2/5 flex items-center justify-center">
        <div
          class="
            px-16
            min-h-[50vh]
            bg-white
            shadow-blue-500/30 shadow-2xl
            rounded-xl
            flex
            items-center
          ">
          <div class="">
            <h2 class="font-poppins text-xl font-semibold mb-6">
              Silahkan Login.
            </h2>
            <BreezeValidationErrors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
              {{ status }}
            </div>
            <form @submit.prevent="submit">
              <div>
                <Label for="email" value="Email" />
                <Input
                  id="email"
                  type="email"
                  class="mt-1 block w-full min-w-[18rem]"
                  v-model="form.email"
                  required
                  autofocus
                  autocomplete="username" />
              </div>

              <div class="mt-4">
                <Label for="password" value="Password" />
                <Input
                  id="password"
                  type="password"
                  class="mt-1 block w-full"
                  v-model="form.password"
                  required
                  autocomplete="current-password" />
              </div>

              <div class="block mt-4">
                <label class="flex items-center">
                  <Checkbox name="remember" v-model:checked="form.remember" />
                  <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
              </div>

              <div class="flex items-center justify-end mt-4">
                <!-- <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="underline text-sm text-gray-600 hover:text-gray-900">
                  Forgot your password?
                </Link> -->

                <Button
                  class="ml-4"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing">
                  Log in
                </Button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Guest>
</template>
