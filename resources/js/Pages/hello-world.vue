<script setup lang="ts">
import { InertiaLink } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps<{
    ip: string,
    host: string,
    userAgent: string,
}>();

const leftDrawerOpen = ref(false);
const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value
}
</script>

<template>
    <q-layout view="hHh lpR fFf">

        <q-header elevated class="bg-primary text-white" height-hint="98">
            <q-toolbar>
                <q-toolbar-title>
                    IPチェッカー
                </q-toolbar-title>
            </q-toolbar>
        </q-header>

        <q-page-container>
            <!-- <router-view /> -->
            <p class="greeting">{{ props.ip }}</p>
            <p class="greeting">{{ props.host }}</p>
            <p class="greeting">{{ props.userAgent }}</p>
        </q-page-container>

        <q-footer elevated class="bg-grey-8 text-white">
            <q-toolbar>
                <q-toolbar-title>
                    <div class="copyright">
                        Copyright © <a href="https://it-araiguma.com" target="_blank">ITアライグマ</a> AllRights Reserved.
                    </div>
                </q-toolbar-title>
            </q-toolbar>
        </q-footer>

    </q-layout>
</template>

<style>
.greeting {
    color: red;
    font-weight: bold;
}

.copyright {
    font-size: 14px;
}

.copyright>a {
    color: #fff;
}
</style>