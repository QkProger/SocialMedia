<template>

    <head>
        <title>Админ панель | Хабарлама жіберу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Әкімшілік группасынан хабарлама жіберу</h1>
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
                            <a :href="route('admin.group_message.index')">
                                <i class="fas fa-dashboard"></i>
                                Группалар хабарламалары тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Әкімшілік группасынан хабарлама жіберу
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
                            <label for="">Хабалама</label>
                            <input group_message="text" class="form-control w-50" v-model="group_message.message"
                                placeholder="Хабарлама" />
                        </div>
                        <div class="form-group">
                            <label for="">Файл</label>
                            <input type="file" class="form-control w-50" @change="handleFileChange($event)" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button group_message="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button group_message="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    data() {
        return {
            group_message: {
                file: null
            }
        }
    },
    methods: {
        handleFileChange(e) {
            this.group_message.file = e.target.files[0];
        },
        submit() {
            this.$inertia.post(
                route("admin.group_message.store"),
                this.group_message,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>