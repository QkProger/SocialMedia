<template>
    <div class="wrapper" style="overflow: auto">
        <NavBar />

        <SideBar />
        <div class="content-wrapper">
            <ResultMessage></ResultMessage>
            <div class="content-header">
                <div class="container-fluid">
                    <!-- <div class="row mb-2"> -->
                        <!-- <div class="col-sm-6"> -->
                            <slot name="breadcrumbs"></slot>
                        <!-- </div> -->
                    <!-- </div> -->
                </div>
            </div>
            <section class="content" >
                <div class="container-fluid" v-if="headerSlot">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <slot name="header"></slot>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <slot></slot>
            </section>
        </div>
        <Footer />
    </div>
</template>
<script>
import Footer from "@/Components/Footer.vue";
import NavBar from "@/Components/NavBar.vue";
import SideBar from "@/Components/SideBar.vue";
import ResultMessage from '@/Components/ResultMessage.vue'
// require('../../../public/js/jquery-36.min.js')
// require('../../../public/js/overlayScrollbars.min.js')
// require('../../../public/js/adminlte.min.js')
export default {
    components: {
        Footer,
        NavBar,
        SideBar,
        ResultMessage
    },
    mounted() {
        this.init()
    },
    computed: {
        headerSlot() {
            return Boolean (this.$slots.header)
        }
    },
    methods: {
        init() {
            let SELECTOR_LOADER = ".preloader";
            setTimeout(() => {
                let $loader = $(SELECTOR_LOADER);
                if ($loader) {
                    $loader.css("height", 0);
                    setTimeout(() => {
                        $loader.children().hide();
                    }, 200);
                }
            }, 2000);
        },
    },
};
</script>
<style>
.red {
    color:  #dc3545;
    }
</style>
