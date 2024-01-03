<script setup lang="ts">
import { ref } from "vue";

const props = defineProps<{
    ip: string,
    host: string,
    userAgent: string,
}>();
</script>

<template>
    <p class="greeting aaa">{{ props.ip }}</p>
    <p class="greeting">{{ props.host }}</p>
    <p class="greeting">{{ props.userAgent }}</p>
</template>

<style>
.greeting {
    color: red;
    font-weight: bold;
}
</style>