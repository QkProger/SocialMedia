<template>
    <nav>
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"
                :class="[
                    link.url === null ? 'disabled' : '',
                    link.active ? 'active' : ''
                ]"
                v-for="(link, index) in links"
                :key="index"
            >
                <Link class="page-link" :href="link.url === null ? '#' : link.url" v-html="link.label"></Link>
            </li>
        </ul>
    </nav>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
    export default {
        props: ['links'],
        components: {
            Link
        }
    }
</script>
