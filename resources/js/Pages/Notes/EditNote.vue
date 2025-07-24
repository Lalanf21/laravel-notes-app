<script setup>
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const props = defineProps({
  note: Object
})

const form = reactive({
  title: props.note.title,
  content: props.note.content,
})

const update = () => {
  router.put(`/notes/${props.note.id}`, form)
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-xl font-semibold mb-4">Edit Note</h1>
    <form @submit.prevent="update" class="space-y-4">
      <div>
        <label class="block text-sm">Title</label>
        <input v-model="form.title" type="text" class="w-full border p-2 rounded" />
      </div>
      <div>
        <label class="block text-sm">Content</label>
        <textarea v-model="form.content" class="w-full border p-2 rounded"></textarea>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
  </div>
</template>
