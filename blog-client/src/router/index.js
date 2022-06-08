import { createRouter, createWebHistory } from "vue-router";
import store from "../store";
import HomeView from "../views/HomeView.vue";
import PostView from "../views/PostView.vue";
import LoginView from "../views/LoginView.vue";
import PostsView from "../views/admin/PostsView.vue";
import EditPostView from "../views/admin/EditPostView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/admin/login",
    name: "admin.login",
    component: LoginView,
  },
  {
    path: "/admin/posts",
    name: "admin.posts",
    component: PostsView,
    beforeEnter: (to, from, next) => {
      if (!store.getters.authenticated) {
        return next({ name: "admin.login" });
      }
      return next();
    },
  },
  {
    path: "/admin/posts/:slug/edit",
    name: "admin.posts.edit",
    component: EditPostView,
    props: true,
    beforeEnter: (to, from, next) => {
      if (!store.getters.authenticated) {
        return next({ name: "admin.login" });
      }
      return next();
    },
  },
  {
    path: "/posts/:slug",
    name: "post",
    component: PostView,
    props: true,
  },
];

export default createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});
