<template>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">My Flats</div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item active" aria-current="page">
            {{ title }}
          </li>
        </ol>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
defineProps(['title']);
</script>