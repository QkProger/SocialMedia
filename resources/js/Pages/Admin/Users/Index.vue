<template>
    <head>
        <title>Админ панель | Қолданушылар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Қолданушылар тізімі</h1>
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
                            Қолданушылар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.users.create')">
                <i class="fa fa-plus"></i> Қосу
                </Link>

                <Link class="btn btn-danger" :href="route('admin.users.index')">
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
                                        <th>Аты</th>
                                        <th>Әкесі</th>
                                        <th>Фамилиясы</th>
                                        <th>Псеводоним</th>
                                        <th>Поштасы</th>
                                        <th>Құпия сөз</th>
                                        <th>Туған-күні</th>
                                        <th>Облыс</th>
                                        <th>Қала</th>
                                        <th>Мамандық</th>
                                        <th>Телефон нөмірі</th>
                                        <th>Әрекет</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <!-- <td>
                                            <input v-model="filter.name" class="form-control" placeholder="Іздеу..."
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.name" class="form-control" placeholder="Іздеу..."
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.name" class="form-control" placeholder="Іздеу..."
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.name" class="form-control" placeholder="Іздеу..."
                                                @keyup.enter="search" />
                                        </td> -->
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(user, index) in users.data" :key="'user' + user.id">
                                        <td>
                                            {{
                                                user.from
                                                ? user.from + index
                                                : index + 1
                                            }}
                                        </td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.lastname }}</td>
                                        <td>{{ user.surname }}</td>
                                        <td>{{ user.nickname }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.real_password }}</td>
                                        <td>{{ user.birthday }}</td>
                                        <td>{{ user.oblys }}</td>
                                        <td>{{ user.qala }}</td>
                                        <td>{{ user.mamandyq }}</td>
                                        <td>{{ user.phone }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route(
                                                    'admin.users.edit',
                                                    user)
                                                    " class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>

                                                <button @click.prevent="deleteData(user.id)" class="btn btn-danger"
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
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head
    },
    props: ["users"],
    data() {
        return {
            filter: {
                name: route().params.name ? route().params.name : null,
            },
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
                    this.$inertia.delete(route('admin.users.destroy', id))
                }
            });


        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('admin.users.index'), params)
        },
    }
};
</script>