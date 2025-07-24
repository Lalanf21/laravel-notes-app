<template>
  <div class="mx-auto mt-10 p-6 rounded shadow">
    <button
        @click="goBackToIndex"
        class="mb-4 inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium px-4 py-2 rounded transition duration-200"
        >
        ← Kembali ke Daftar Notes
    </button>
    <h1 class="text-2xl font-bold mb-2">{{ note.title }}</h1>
    <p class="text-gray-600 mb-6">{{ note.content }}</p>

    <div class="border-t pt-4">
      <h2 class="text-lg font-semibold mb-3">Komentar</h2>

      <div v-if="note.comments.length === 0" class="text-gray-500">Belum ada komentar.</div>

      <div v-for="comment in note.comments" :key="comment.id" class="mb-4">
        <div class="text-sm text-gray-600">{{ comment.user.name }}</div>
        <div class="p-2 bg-gray-100 rounded text-sm mt-1">{{ comment.content }}</div>
      </div>


      <form v-if="isLoggedIn" @submit.prevent="submitComment" class="mt-6">
        <textarea v-model="form.content" class="w-full p-2 border rounded" rows="3" placeholder="Tulis komentar..." required />
        <button class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">Kirim Komentar</button>
      </form>

      <div v-else class="mt-6 text-sm text-gray-600">
        <p>Login untuk menulis komentar. </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { router, usePage } from '@inertiajs/vue3'

const goBackToIndex = () => {
  router.visit('/')
}

const props = defineProps({ note: Object })

const page = usePage()

const isLoggedIn = computed(() => !!page.props.auth?.user)

const form = reactive({
  content: ''
})

function submitComment() {
  Inertia.post(`/notes/${props.note.id}/comment`, form, {
    onSuccess: () => {
      form.content = ''
    }
  });
}
</script>
