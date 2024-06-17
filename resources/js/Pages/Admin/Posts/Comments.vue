<template>

    <head>
        <title>Админ панель | Пікірлер</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пікірлер тізімі</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Пікірлер тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr role="row">
                                        <th>№</th>
                                        <th>Автор</th>
                                        <th>Пікір</th>
                                        <th>Басты пікір</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(comments, index) in comments.data" :key="'comments' + comments.id">
                                        <td>
                                            {{ comments.from ? comments.from + index : index + 1 }}
                                        </td>
                                        <td>{{ comments.user.fio }}</td>
                                        <td>{{ comments.content }}</td>
                                        <td v-if="comments.main_comment">Бар</td>
                                        <td v-else>Жоқ</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button @click.prevent="deleteData(comments.id)" class="btn btn-danger"
                                                    title="Жою">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="comments.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head
    },
    props: ["comments"],
    data() {
        return {
            loading: 0,
        };
    },
    methods: {
        deleteData(id) {
            Swal.fire({
                title: "Жоюға сенімдісіз бе?",
                text: "Қайтып қалпына келмеуі мүмкін!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Иә, жоямын!",
                cancelButtonText: "Жоқ",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('admin.comments.destroy', id))
                }
            });
        },
    }
};
</script>
<style>
.c-p {
    cursor: pointer;
}

.hover_file {
    font-weight: bold;
}

.hover_file:hover {
    text-decoration: underline;
}
</style>