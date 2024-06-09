<template>

    <head>
        <title>Админ панель | Хабарламалар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Хабарламалар тізімі</h1>
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
                            Хабарламалар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-danger mr-3" :href="route('admin.message.index')">
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
                                        <th>Жіберуші</th>
                                        <th>Қабылдаушы</th>
                                        <th>Хабарлама</th>
                                        <th>Файл</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(message, index) in message.data" :key="'message' + message.id">
                                        <td>
                                            {{ message.from ? message.from + index : index + 1 }}
                                        </td>
                                        <td>{{ message.user.fio }}</td>
                                        <td>{{ message.user2.fio }}</td>
                                        <td v-if="message.message">{{ message.message }}</td>
                                        <td v-else>Жоқ</td>
                                        <td v-if="message.file_name">
                                            <div class="c-p hover_file" @click.prevent="download(message.file_name, message.id)">{{ message.file_name }}</div>
                                        </td>
                                        <td v-else>Жоқ</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button @click.prevent="deleteData(message.id)" class="btn btn-danger"
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
                    <Pagination :links="message.links" />
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
    props: ["message"],
    data() {
        return {
            loading: 0,
        };
    },
    methods: {
        download(filename, id) {
            axios.get(`/admin/download?url=/chat_files/${filename}`, {
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
                    this.$inertia.delete(route('admin.message.destroy', id))
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