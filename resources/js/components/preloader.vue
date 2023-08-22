<template>
    <div class="loading display-none" id="loader">
        <div class="spinner-border spinner-border-lg text-primary text-center" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="layouts" class="display-none"></div>
</template>
<script>
import "@/components/assets/preloader.css";
</script>
<style>
.display-none {
    display: none;
    text-align: center;
    margin-top: 14%;
}
</style>
