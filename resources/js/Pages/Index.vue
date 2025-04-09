<script setup lang="ts">
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";
import { useQuasar } from 'quasar';

const $q = useQuasar();

const props = defineProps<{
    ipv4: string,
    ipv6: string,
    host: string,
    user_agent: string,
    country: string,
    city: string,
    is_twa: boolean,
}>();

const dense = ref(false);
const loading = ref(false);

const reload = () => {
    loading.value = true;
    router.reload({
        onFinish: () => {
            loading.value = false;
        }
    });
}

const CountryAndCity = computed(() => {
    return `${props.country} / ${props.city}`;
});

const copyToClipboard = (text: string) => {
    navigator.clipboard.writeText(text);
    $q.notify({
        message: 'コピーしました',
        color: 'positive',
        icon: 'content_copy',
        position: 'top',
        timeout: 1000
    });
}
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <Header />
        <q-page-container class="flex justify-center items-start bg-grey-1">
            <div class="q-pa-md q-my-md" style="width: 800px; max-width: 95%;">
                <q-card class="q-pa-md shadow-5">
                    <q-card-section>
                        <div class="text-h6 text-primary q-mb-md">あなたのネットワーク情報</div>

                        <div class="q-gutter-y-md">
                            <q-card flat bordered v-if="props.ipv4" class="q-mb-sm">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2 text-grey">IPアドレス (v4)</div>
                                            <div class="text-body1">{{ props.ipv4 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round color="primary" icon="content_copy"
                                                @click="copyToClipboard(props.ipv4)" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <q-card flat bordered v-if="props.ipv6" class="q-mb-sm">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2 text-grey">IPアドレス (v6)</div>
                                            <div class="text-body1 break-all">{{ props.ipv6 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round color="primary" icon="content_copy"
                                                @click="copyToClipboard(props.ipv6)" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <q-card flat bordered class="q-mb-sm">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2 text-grey">国 / 都市</div>
                                            <div class="text-body1">{{ CountryAndCity }}</div>
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <q-card flat bordered class="q-mb-sm">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2 text-grey">ホスト</div>
                                            <div class="text-body1 break-all">{{ props.host }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round color="primary" icon="content_copy"
                                                @click="copyToClipboard(props.host)" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <q-card flat bordered class="q-mb-sm">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2 text-grey">ユーザーエージェント</div>
                                            <div class="text-body1 break-all">{{ props.user_agent }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round color="primary" icon="content_copy"
                                                @click="copyToClipboard(props.user_agent)" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn color="primary" icon="refresh" label="更新" @click="reload" :loading="loading" />
                    </q-card-actions>
                </q-card>

                <div class="q-mt-md">
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
