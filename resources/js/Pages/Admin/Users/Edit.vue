<template>

    <head>
        <title>Админ панель | Қолданушы жайлы ақпаратты өзгерту</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Қолданушы жайлы ақпаратты өзгерту</h1>
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
                            Қолданушы жайлы ақпаратты өзгерту
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
                            <input type="text" class="form-control" v-model="user.name" name="name" placeholder="Аты" />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">Әкесінің аты</label>
                            <input type="text" class="form-control" v-model="user.lastname" name="lastname"
                                placeholder="Әкесінің аты" />
                            <validation-error :field="'lastname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Фамилиясы</label>
                            <input type="text" class="form-control" v-model="user.surname" name="surname"
                                placeholder="Фамилиясы" />
                            <validation-error :field="'surname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Псеводонимы</label>
                            <input type="text" class="form-control" v-model="user.nickname" name="nickname"
                                placeholder="Псеводонимы" />
                            <validation-error :field="'nickname'" />
                        </div>
                        <div class="form-group">
                            <label for="">Поштасы</label>
                            <input type="text" class="form-control" v-model="user.email" name="email"
                                placeholder="Поштасы" />
                            <validation-error :field="'email'" />
                        </div>
                        <div class="form-group">
                            <label for="">ИИН</label>
                            <input type="text" class="form-control" v-model="user.iin" name="iin" placeholder="ИИН" />
                            <validation-error :field="'iin'" />
                        </div>
                        <!-- <div class="form-group">
                            <label for="image">Суреті</label>
                            <input type="file" class="form-control" @change="handleImageChange" name="image" />
                            <br>
                            <img v-if="imageUrl" :src="imageUrl" alt="Current Image" style="max-width: 10%;" />
                            <validation-error :field="'image'" />
                        </div> -->
                        <!-- <img :src="'/storage/' + user.avatar"> -->
                        <div class="form-group">
                            <label for="">Құпия сөзі</label>
                            <input type="text" class="form-control" v-model="user.real_password" name="real_password"
                                placeholder="Құпия сөзі" />
                            <validation-error :field="'real_password'" />
                        </div>
                        <input class="switch mb-2" type="checkbox" v-model="user.admin">
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
    props: ["user", "imageUrl"],
    methods: {
        submit() {
            this.user["_method"] = "put";
            this.$inertia.post(
                route("admin.users.update", this.user.id),
                this.user,
                {
                    FormData: true,
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
        handleImageChange(event) {
            const file = event.target.files[0];
            this.post.image = file;
            this.post.updateImage = true;
        },
    },
};
</script>
<style>
input.switch {
    -moz-appearance: none;
    -webkit-appearance: none;
    -o-appearance: none;
    appearance: none;
    height: 1em;
    width: 2em;
    border-radius: 1em;
    box-shadow: inset -1em 0px 0px 0px rgba(192, 192, 192, 1);
    background-color: white;
    border: 1px solid rgba(192, 192, 192, 1);
    outline: none;
    -webkit-transition: 0.2s;
    transition: 0.2s;
}

input.switch:checked {
    box-shadow: inset 1em 0px 0px 0px rgba(33, 150, 243, 0.5);
    border: 1px solid rgba(33, 150, 243, 1);
}

input.switch:focus {
    outline-width: 0;
}
</style>