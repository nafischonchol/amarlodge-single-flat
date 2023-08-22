<template>
    <!--start top header-->
    <div class="wrapper">
        <Preloader />
        <router-view name="layouts" />
        <router-view />

        <div class="overlay nav-toggle-icon"></div>

        <a href="javaScript:;" class="back-to-top"><span class="material-symbols-outlined">
                arrow_upward
            </span></a>
    </div>
</template>

<script>
import "@/components/assets/app.css";
import Preloader from "@/components/preloader.vue";
export default {
    components: { Preloader }
}
</script>



