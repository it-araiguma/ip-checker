<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";

const props = defineProps<{
    ipv4: string,
    ipv6: string,
    host: string,
    user_agent: string,
    country: string,
}>();

const dense = ref(false);

const reload = () => {
    router.reload();
}
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <Header />
        <q-page-container class="flex justify-center items-start">
            <div class="q-pa-md" style="width: 800px;">
                <div class="q-gutter-y-md column">
                    <div class="q-gutter-md" v-if="props.ipv4">
                        <q-input label="IPアドレス(v4)" stack-label :dense="dense" readonly v-model="props.ipv4" />
                    </div>

                    <div class="q-gutter-md" v-if="props.ipv6">
                        <q-input label="IPアドレス(v6)" stack-label :dense="dense" readonly v-model="props.ipv6" />
                    </div>

                    <div class="q-gutter-md">
                        <q-input stack-label :dense="dense" label="国" readonly v-model="props.country" />
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

#app > div > div > div > div > div:nth-child(3) > label > div {
    max-height: 100%;
}
</style>
