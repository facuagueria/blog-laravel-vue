<template>
  <div>
    <div
      class="absolute w-full left-0 top-0 p-6 flex justify-between items-center space-x-6"
    >
      <div class="flex-grow flex items-center">
        <span class="mr-1">/</span>
        <input
          type="text"
          class="p-0 border-none focus:ring-0 w-full"
          v-model="post.slug"
          spellcheck="false"
          @click="$event.target.select()"
        />
      </div>
      <div class="flex items-center space-x-6">
        <div><span class="text-sm text-gray-500">Autosaved</span></div>
        <button
          @click="post.published = !post.published"
          class="text-sm font-medium"
          :class="{ 'text-pink-500': post.published }"
        >
          {{ !post.published ? "Publish" : "Unpublish" }}
        </button>
        <router-link
          :to="{ name: 'post', params: { slug: uuid } }"
          class="text-sm font-bold text-gray-800"
        >
          Preview
        </router-link>
      </div>
    </div>
    <div>
      <ResizeTextArea v-if="post.title">
        <template v-slot:default="{ resize, el }">
          <textarea
            :ref="el"
            v-model="post.title"
            v-on:input="resize"
            class="w-full text-center text-4xl lg:text-6xl leading-10 font-extrabold tracking-tight text-gray-900 border-none focus:ring-0 resize-none p-0"
            rows="1"
          ></textarea>
        </template>
      </ResizeTextArea>
    </div>
  </div>
</template>

<script setup>
import useAdminPosts from "../../api/useAdminPosts.js";
import { onMounted, watch, watchEffect } from "vue";
import _ from "lodash";
import ResizeTextArea from "../../components/ResizeTextArea.vue";
import slugify from "slugify";

const props = defineProps({
  uuid: {
    required: true,
    type: String,
  },
});

const { post, fetchPost, patchPost } = useAdminPosts();

const updatePost = async () => {
  await patchPost(props.uuid);
};

const replaceSlug = () => {
  const slug = post.value.slug;

  if (slug.charAt(slug.length - 1) === " ") {
    return;
  }

  post.value.slug = slug ? slugify(slug, { strict: true }) : post.value.uuid;
};

onMounted(async () => {
  await fetchPost(props.uuid);

  watchEffect(() => {
    replaceSlug();
  });

  watch(
    () => _.cloneDeep(post),
    _.debounce(() => {
      updatePost();
    }, 500)
  );
});
</script>
