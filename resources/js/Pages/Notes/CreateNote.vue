<template>
  <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded mt-10">
    <button
        @click="goBackToIndex"
        class="mb-4 inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium px-4 py-2 rounded transition duration-200"
        >
        ← Kembali ke Daftar Notes
    </button>
    <h2 class="text-xl font-semibold mb-4">Buat Catatan Baru</h2>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block font-medium">Judul</label>
        <input v-model="form.title" class="w-full border rounded p-2" required />
      </div>

      <div class="mb-4">
        <label class="block font-medium">Isi</label>
        <textarea v-model="form.content" class="w-full border rounded p-2" rows="5" required />
      </div>

      <div class="mb-4 flex items-center gap-2">
        <input type="checkbox" v-model="form.is_public" />
        <label>Tandai sebagai catatan publik</label>
      </div>

      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
        Simpan
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'

const form = reactive({
  title: '',
  content: '',
  is_public: false,
})

const goBackToIndex = () => {
  router.visit('/')
}

function submit() {
  Inertia.post('/notes', form)
}
</script>
