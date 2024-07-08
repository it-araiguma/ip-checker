<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import Footer from "../Components/Footer.vue";

const props = defineProps<{
    ip: string,
    host: string,
    user_agent: string,
}>();

const dense = ref(false);

const reload = () => {
    router.reload();
}
</script>

<template>
    <q-layout view="lHh Lpr lFf">

        <q-header elevated class="bg-primary text-white">
            <q-toolbar>
                <q-toolbar-title>
                    <a href="/" style="color: #fff;text-decoration: none;">
                        IPチェッカー
                    </a>
                </q-toolbar-title>
            </q-toolbar>
        </q-header>

        <q-page-container class="flex justify-center items-start">
            <div class="q-pa-md" style="width: 800px;">
                <div class="q-gutter-y-md column">
                    <div class="q-gutter-md">
                        <q-input label="IPアドレス" stack-label :dense="dense" readonly v-model="props.ip" />
                    </div>

                    <div class="q-gutter-md">
                        <q-input stack-label :dense="dense" label="ホスト" readonly v-model="props.host" />
                    </div>

                    <div class="q-gutter-md">
                        <q-input stack-label :dense="dense" label="ユーザーエージェント" class="break-all" readonly autogrow
                            v-model="props.user_agent" />
                    </div>

                    <div>
                        <q-btn icon="refresh" color="blue" fab @click="reload" class="float-right q-mt-lg" />
                    </div>
                </div>
            </div>
        </q-page-container>
        <Footer />
    </q-layout>
</template>

<style>
.break-all {
    word-break: break-all;
}
</style>
