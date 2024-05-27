<template>
    <head>
        <title>Админ панель | Қолданушы қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Қолданушы қосу</h1>
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
                            <a :href="route('admin.users.index')">
                                <i class="fas fa-dashboard"></i>
                                Қолданушылар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Қолданушылар қосу
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="user" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="user.name" name="name" placeholder="Аты" />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">Әкесінің аты</label>
                            <input type="text" class="form-control" v-model="user.lastname" name="lastname" placeholder="Әкесінің аты" />
                            <validation-error :field="'lastname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Фамилиясы</label>
                            <input type="text" class="form-control" v-model="user.surname" name="surname" placeholder="Фамилиясы" />
                            <validation-error :field="'surname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Псеводонимы</label>
                            <input type="text" class="form-control" v-model="user.nickname" name="nickname" placeholder="Псеводонимы" />
                            <validation-error :field="'nickname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Поштасы</label>
                            <input type="text" class="form-control" v-model="user.email" name="email" placeholder="Поштасы" />
                            <validation-error :field="'email'" />
                        </div>
                        <div class="form-group">
                            <label for="">ИИН</label>
                            <input type="text" class="form-control" v-model="user.iin" name="iin" placeholder="ИИН" />
                            <validation-error :field="'iin'" />
                        </div>
                        <div class="form-group">
                            <label for="">Құпия сөзі</label>
                            <input type="text" class="form-control" v-model="user.real_password" name="real_password" placeholder="Құпия сөзі" />
                            <validation-error :field="'real_password'" />
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
            user: {}
        }
    },
    methods: {
        submit() {
            this.$inertia.post(
                route("admin.users.store"),
                this.user,
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