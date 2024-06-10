<template>
    <head>
        <title>Админ панель | Пост өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пост өзгерту</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.posts.index')">
                                <i class="fas fa-dashboard"></i>
                                Пост тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Пост өзгерту
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="post.title" name="title" placeholder="Аты" />
                            <validation-error :field="'title'" />
                        </div>
                        <div class="form-group">
                            <label for="">Контент</label>
                            <input type="text" class="form-control" v-model="post.content" name="content"
                                placeholder="Контент" />
                            <validation-error :field="'content'" />
                        </div>
                        <div class="form-group">
                            <label for="">Сипаттамасы</label>
                            <input type="text" class="form-control" v-model="post.description" name="description"
                                placeholder="Сипаттамасы" />
                            <validation-error :field="'description'" />
                        </div>
                        <div class="form-group">
                            <label for="image">Суреті</label>
                            <input type="file" class="form-control" @change="handleImageChange" name="image" />
                            <br>
                            <img :src="'/storage/' + post.image" alt="Current Image" style="max-width: 10%;" />
                            <validation-error :field="'image'" />
                        </div>

                        <div class="form-group">
                            <label for="">Бейнебаяны</label>
                            <input type="text" class="form-control" v-model="post.video" name="video"
                                placeholder="Бейнебаян" />
                            <validation-error :field="'video'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import ValidationError from "@/Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    props: ["post", "imageUrl"],
    methods: {
        submit() {
            this.post["_method"] = "put";
            this.$inertia.post(
                route("admin.posts.update", this.post.id),
                this.post,
                {
                    FormData:true,
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.post.image = file;
        },
    },
};
</script>