<template>
    <head>
        <title>Админ панель | Материалды өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Материалды өзгерту</h1>
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
                            <a :href="route('admin.material.index')">
                                <i class="fas fa-dashboard"></i>
                                Материалдар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Материалдар өзгерту
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
                            <input type="text" class="form-control" v-model="material.title" name="title" placeholder="Аты" />
                        </div>
                        <div class="form-group">
                            <label for="file">Файлы</label>
                            <input type="file" class="form-control" @change="handleFileChange" name="file" />
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
    props: ["material"],
    methods: {
        submit() {
            this.material["_method"] = "put";
            this.$inertia.post(
                route("admin.material.update", this.material.id),
                this.material,
                {
                    FormData:true,
                }
            );
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            this.material.file = file;
        },
    },
};
</script>