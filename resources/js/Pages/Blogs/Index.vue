<template>
  <Head title="Blogs" />

  <div class="flex justify-between mb-6">
    <div class="flex items-center">
      <h1 class="text-3xl">Blog Yazıları</h1>

      <Link v-if="can.createBlog" href="/blogs/blog" class="text-blue-500 text-sm ml-3">Yeni Yazı Ekle</Link>
    </div>

    <input v-model="search" type="text" placeholder="Arama yap..." class="border px-2 rounded-lg" />
  </div>

  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="posts in posts.data" :key="posts.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div>
                      <div class="text-sm font-medium text-gray-900">
                        {{ posts.title }}
                      </div>
                    </div>
                  </div>
                </td>

                <td v-if="posts.can.edit" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <Link :href="`/users/${posts.id}/edit`" class="text-indigo-600 hover:text-indigo-900"> Düzenle</Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <Pagination :links="posts.links" class="mt-6" />
</template>

<script setup>
import Pagination from '../../Shared/Pagination';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import debounce from "lodash/debounce";

let props = defineProps({
  posts: Object,
  filters: Object,
  can: Object
});

let search = ref(props.filters.search);

watch(search, debounce(function (value) {
  Inertia.get('/blogs', { search: value }, { preserveState: true, replace: true });
}, 300));
</script>
