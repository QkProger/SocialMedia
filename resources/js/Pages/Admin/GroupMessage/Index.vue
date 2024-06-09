<template>

    <head>
        <title>Админ панель | Группалар хабарламалары</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Группалар хабарламалары</h1>
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
                            Группалар хабарламалары
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.group_message.create')">
                <i class="fa fa-plus"></i> Қосу
                </Link>

                <Link class="btn btn-danger mr-3" :href="route('admin.group_message.index')">
                <i class="fa fa-trash"></i> Фильтрді тазалау
                </Link>
                <div v-if="loading" class="spinner-border text-primary mx-3" role="status">
                    <span class="sr-only">Loading...</span>
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
                                        <th>Группа</th>
                                        <th>Қолданушы</th>
                                        <th>Хабарлама</th>
                                        <th>Файл</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(group_message, index) in group_message.data"
                                        :key="'group_message' + group_message.id">
                                        <td>
                                            {{ group_message.from ? group_message.from + index : index + 1 }}
                                        </td>
                                        <td>{{ group_message.group.name }}</td>
                                        <td>{{ group_message.user.fio }}</td>
                                        <td v-if="group_message.message">{{ group_message.message }}</td>
                                        <td v-else>Жоқ</td>
                                        <td v-if="group_message.file_name">
                                            <div class="c-p hover_file"
                                                @click.prevent="download(group_message.file_name, group_message.id)">{{
                                                    group_message.file_name }}</div>
                                        </td>
                                        <td v-else>Жоқ</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button @click.prevent="deleteData(group_message.id)"
                                                    class="btn btn-danger" title="Жою">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="group_message.links" />
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
    props: ["group_message"],
    data() {
        return {
            loading: 0,
        };
    },
    methods: {
        download(filename, id) {
            axios.get(`/admin/download?url=/group_chat_files/${filename}`, {
                responseType: 'blob',
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', id + '.png');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).catch(error => {
                console.error('An error occurred:', error);
            });
        },
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
                    this.$inertia.delete(route('admin.group_message.destroy', id))
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