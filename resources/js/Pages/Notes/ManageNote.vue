<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Notes App</h1>
        <div class="flex gap-2">
            <template v-if="isLoggedIn">
                <button
                @click="goToCreatePage"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition duration-200"
                >
                + Create Note
                </button>
                <button
                @click="logout"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm transition duration-200"
                >
                Logout
                </button>
            </template>

            <template v-else>
                <button
                @click="goToLoginPage"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm transition duration-200"
                >
                Login
                </button>
            </template>
        </div>
    </div>


    <!-- Flash Message -->
    <transition name="fade" appear>
        <div
            v-if="flash.error || flash.success" class="mb-4">
            <div v-if="flash.success" class="bg-green-100 text-green-800 px-4 py-2 rounded border border-green-300">
                {{ flash.success }}
            </div>
            <div
            v-if="flash.error" class="bg-red-100 text-red-800 px-4 py-2 rounded border border-red-300">
                {{ flash.error }}
            </div>
        </div>
    </transition>


    <!-- Table -->
    <table class="w-full bg-white border rounded shadow text-sm">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border-b">Judul</th>
          <th class="p-2 border-b">Status</th>
          <th class="p-2 border-b">Dibagikan ke</th>
          <th class="p-2 border-b">Aksi</th>
        </tr>
      </thead>
      <template v-if="isLoggedIn">
          <tbody>
            <tr v-for="note in notes" :key="note.id" class="hover:bg-gray-50">
              <td class="p-2 border-b text-blue-600 cursor-pointer" @click="goToDetail(note.id)">
                {{ note.title }}
              </td>
              <td class="p-2 border-b">
                <span :class="note.is_public ? 'text-green-600' : 'text-gray-600'">
                  {{ note.is_public ? 'Public' : 'Private' }}
                </span>
              </td>
              <td class="p-2 border-b">
                <span v-if="note.shared_with.length">
                  {{ note.shared_with.map(u => u.name).join(', ') }}
                </span>
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="p-2 border-b space-x-2">
                  <button @click="togglePublic(note)" class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-1 rounded text-xs">
                    {{ note.is_public ? 'Set Private' : 'Set Public' }}
                  </button>
                  <button @click="openShareModal(note)" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">
                    Share
                  </button>
                  <button @click="openEditModal(note)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                    Edit
                  </button>
                  <button @click="deleteNote(note)" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                    Delete
                  </button>
              </td>
            </tr>
          </tbody>
      </template>

      <template v-else>
        <tbody>
            <tr v-for="note in pulicNote" :key="note.id" class="hover:bg-gray-50">
              <td class="p-2 border-b text-blue-600 cursor-pointer" @click="goToDetail(note.id)">
                {{ note.title }}
              </td>
              <td class="p-2 border-b">
                <span :class="note.is_public ? 'text-green-600' : 'text-gray-600'">
                  {{ note.is_public ? 'Public' : 'Private' }}
                </span>
              </td>
              <td class="p-2 border-b">
                <span v-if="note.shared_with.length">
                  {{ note.shared_with.map(u => u.name).join(', ') }}
                </span>
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="p-2 border-b space-x-2"></td>
            </tr>
          </tbody>
      </template>
    </table>

    <!-- Edit Modal -->
    <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit Note</h2>
        <form @submit.prevent="updateNote" class="space-y-4">
          <div>
            <label class="block text-sm">Judul</label>
            <input v-model="editForm.title" type="text" class="w-full border p-2 rounded" />
          </div>
          <div>
            <label class="block text-sm">Konten</label>
            <textarea v-model="editForm.content" class="w-full border p-2 rounded" rows="4"></textarea>
          </div>
          <div class="flex justify-end space-x-2">
            <button type="button" @click="closeModals" class="border px-3 py-1 rounded">Cancel</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Update</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Share Modal -->
    <div v-if="showShareModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Bagikan ke User</h2>
        <form @submit.prevent="shareNote" class="space-y-4">
          <div>
            <label class="block text-sm mb-1">Pilih User</label>
            <div class="space-y-2 max-h-40 overflow-y-auto">
              <div v-for="user in users" :key="user.id" class="flex items-center space-x-2">
                <input type="checkbox" :value="user.id" v-model="shareForm.user_ids" />
                <label>{{ user.name }}</label>
              </div>
            </div>
          </div>
          <div class="flex justify-end space-x-2">
            <button type="button" @click="closeModals" class="border px-3 py-1 rounded">Cancel</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Share</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const flash = reactive({
  success: null,
  error: null,
})

const page = usePage()

const isLoggedIn = computed(() => !!page.props.auth?.user)

// Watch flash message dari Inertia dan set timer
watch(
  () => page.props.flash,
  (newFlash) => {
    if (!newFlash) return;
    flash.success = newFlash.success || null
    flash.error = newFlash.error || null

    if (flash.success || flash.error) {
      setTimeout(() => {
        flash.success = null
        flash.error = null
      }, 2000)
    }
  },
  { immediate: true }
)

const props = defineProps({
  notes: Array,
  users: Array,
  pulicNote: Array,
})

const showEditModal = ref(false)
const showShareModal = ref(false)
const selectedNote = ref(null)
const editForm = reactive({ title: '', content: '' })
const shareForm = reactive({ user_ids: [] })

const logout = () => {
  router.post(route('logout'))
}

const goToLoginPage = () => {
  router.visit('/login')
}

const goToCreatePage = () => {
  router.visit('/notes/create')
}

const goToDetail = (id) => {
  router.visit(`/notes/${id}`)
}

const openEditModal = (note) => {
  selectedNote.value = note
  editForm.title = note.title
  editForm.content = note.content
  showEditModal.value = true
}

const openShareModal = (note) => {
  selectedNote.value = note
  shareForm.user_ids = note.shared_with.map(u => u.id)
  showShareModal.value = true
}

const closeModals = () => {
  showEditModal.value = false
  showShareModal.value = false
}

const updateNote = () => {
  router.put(`/notes/${selectedNote.value.id}`, editForm, {
    onSuccess: () => closeModals()
  })
}

const shareNote = () => {
  router.post(`/notes/${selectedNote.value.id}/share`, shareForm, {
    onSuccess: () => closeModals()
  })
}

const togglePublic = (note) => {
  router.put(`/notes/${note.id}/toggle-public`)
}

const deleteNote = (note) => {
  if (confirm(`Yakin ingin menghapus catatan "${note.title}"?`)) {
    router.delete(`/notes/${note.id}`)
  }
}
</script>

<style scoped>

    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s ease;
    }

    .fade-enter-from, .fade-leave-to {
        opacity: 0;
    }

    .fade-enter-to, .fade-leave-from {
        opacity: 1;
    }

</style>

