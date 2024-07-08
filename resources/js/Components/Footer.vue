<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <q-footer elevated class="bg-grey-8 text-white q-pt-sm q-pb-sm">
        <q-toolbar>
            <q-toolbar-title>
                <div class="copyright text-center ">
                    <Link href="/privacy">プライバシーポリシー</Link>
                </div>
                <div class="copyright text-center">
                    Copyright © <a href="https://it-araiguma.com" target="_blank">ITアライグマ</a> AllRights Reserved.
                </div>
            </q-toolbar-title>
        </q-toolbar>
    </q-footer>
</template>

<style scoped>
.copyright {
    font-size: 14px;
}

.copyright>a {
    color: #fff;
}
</style>
