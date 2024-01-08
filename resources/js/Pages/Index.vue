<script setup lang="ts">
import { InertiaLink } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps<{
    ip: string,
    host: string,
    userAgent: string,
}>();

const leftDrawerOpen = ref(false);
const dense = ref(true);
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
            <div class="q-pa-md">
                <div class="q-gutter-y-md column" style="max-width: 400px">
                    <div class="q-gutter-md q-tile justify-center items-center">
                        <q-input filled :dense="dense" readonly label="IPアドレス">
                            {{ props.ip }}
                        </q-input>
                    </div>

                    <div class="q-gutter-md q-tile justify-center items-center">
                        <q-input filled :dense="dense" label="ホスト" readonly>
                            {{ props.host }}
                        </q-input>
                    </div>

                    <div class="q-gutter-md q-tile justify-center items-center">
                        <q-input filled :dense="dense" label="ユーザーエージェント" readonly autogrow>
                            {{ props.userAgent }}
                        </q-input>
                    </div>
                </div>
            </div>
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