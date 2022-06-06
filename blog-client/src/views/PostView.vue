<template>
  <h1
    class="block text-center text-4xl sm:text-6xl leading-10 font-extrabold tracking-tight text-gray-900"
  >
    {{ post.title }}
  </h1>
  <div
    class="mt-16 text-gray-500 prose prose-sm lg:prose"
    v-html="post.body"
  ></div>
</template>

<script setup>
import usePosts from "../api/usePosts";
import { onMounted } from "vue";

const props = defineProps({
  slug: {
    required: true,
    type: String,
  },
});

const { post, fetchPost } = usePosts();

onMounted(fetchPost(props.slug));
</script>
