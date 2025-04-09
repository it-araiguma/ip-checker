<script lang="ts" setup>
import { useQuasar } from 'quasar';

const $q = useQuasar();

const toggleDarkMode = () => {
  $q.dark.toggle();
}
</script>

<template>
    <q-header elevated :class="{'bg-blue-9': $q.dark.isActive, 'bg-blue-7': !$q.dark.isActive}" class="text-white">
        <q-toolbar>
            <q-toolbar-title class="row items-center">
                <q-icon name="public" size="md" class="q-mr-sm" />
                <a href="/" style="color: #fff; text-decoration: none; font-weight: 500;">
                    IPアドレスチェッカー
                </a>
            </q-toolbar-title>
            
            <q-btn flat round icon="brightness_medium" @click="toggleDarkMode" class="text-blue-1">
                <q-tooltip>ダークモード切替</q-tooltip>
            </q-btn>
            
            <q-btn flat round icon="help_outline" href="/privacy" class="text-blue-1">
                <q-tooltip>プライバシーポリシー</q-tooltip>
            </q-btn>
        </q-toolbar>
    </q-header>
</template>

<style>
.q-header {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
</style>
