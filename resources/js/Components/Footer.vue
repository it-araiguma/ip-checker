<script lang="ts" setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
    <q-footer elevated class="bg-primary text-white">
        <q-toolbar>
            <q-toolbar-title>
                <div class="row justify-center q-mb-sm">
                    <q-btn flat dense size="sm" :to="route('index')" icon="home" label="ホーム" class="q-mx-xs" />
                    <q-btn flat dense size="sm" :to="route('privacy')" icon="policy" label="プライバシーポリシー" class="q-mx-xs" />
                </div>
                <div class="copyright text-center">
                    <div class="row justify-center items-center">
                        <span>Copyright {{ new Date().getFullYear() }} </span>
                        <a href="https://it-araiguma.com" target="_blank" class="q-px-xs text-white">
                            ITアライグマ
                        </a>
                        <span> All Rights Reserved.</span>
                    </div>
                </div>
            </q-toolbar-title>
        </q-toolbar>
    </q-footer>
</template>

<style scoped>
.copyright {
    font-size: 14px;
}

.q-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
