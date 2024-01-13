<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps<{
    ip: string,
    host: string,
    userAgent: string,
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
                    IPチェッカー
                </q-toolbar-title>
            </q-toolbar>
        </q-header>

        <q-page-container class="flex justify-center items-start">
            <div class="q-pa-md">
                <div class="q-gutter-y-md column">
                    <div class="q-gutter-md">
                        <q-input label="IPアドレス" stack-label :dense="dense" readonly>
                            {{ props.ip }}
                        </q-input>
                    </div>

                    <div class="q-gutter-md">
                        <q-input stack-label :dense="dense" label="ホスト" readonly>
                            {{ props.host }}
                        </q-input>
                    </div>

                    <div class="q-gutter-md">
                        <q-input stack-label :dense="dense" label="ユーザーエージェント" class="break-all" readonly autogrow>
                            {{ props.userAgent }}
                        </q-input>
                    </div>

                    <div>
                        <q-btn icon="refresh" color="blue" fab @click="reload" class="float-right q-mt-xl" />
                    </div>
                </div>
            </div>
        </q-page-container>

        <q-footer elevated class="bg-grey-8 text-white">
            <q-toolbar>
                <q-toolbar-title>
                    <div class="copyright text-center">
                        Copyright © <a href="https://it-araiguma.com" target="_blank">ITアライグマ</a> AllRights Reserved.
                    </div>
                </q-toolbar-title>
            </q-toolbar>
        </q-footer>

    </q-layout>
</template>

<style>
.copyright {
    font-size: 14px;
}

.copyright>a {
    color: #fff;
}

.break-all {
    word-break: break-all;
}
</style>