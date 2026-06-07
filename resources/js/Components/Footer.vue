<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
import { useQuasar } from 'quasar';

const $q = useQuasar();
</script>

<template>
    <q-footer elevated :class="{'bg-blue-9': $q.dark.isActive, 'bg-blue-7': !$q.dark.isActive}" class="text-white">
        <q-toolbar>
            <q-toolbar-title>
                <div class="row justify-center q-mb-sm">
                    <q-btn flat dense size="sm" :to="route('index')" icon="home" label="ホーム" class="q-mx-xs text-blue-1" />
                    <q-btn flat dense size="sm" :to="route('privacy')" icon="policy" label="プライバシーポリシー" class="q-mx-xs text-blue-1" />
                </div>
                <div class="copyright text-center">
                    <div class="row justify-center items-center">
                        <span>Copyright {{ new Date().getFullYear() }} </span>
                        <a href="https://it-araiguma.com" target="_blank" class="q-px-xs text-blue-2">
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
    border-top: 1px solid rgba(100, 150, 255, 0.2);
}
</style>
