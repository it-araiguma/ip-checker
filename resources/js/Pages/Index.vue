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
    timezone: string,
    isp: string,
    browser_info: {
        browser: string,
        os: string,
        device: string
    },
    headers: Record<string, string>,
    connection_info: {
        protocol: string,
        method: string,
        port: number,
        is_secure: boolean,
        is_ajax: boolean
    },
    is_twa: boolean,
}>();

const dense = ref(false);
const loading = ref(false);
const expandedSections = ref({
    headers: false,
    connectionInfo: false
});

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

const toggleSection = (section: string) => {
    expandedSections.value[section] = !expandedSections.value[section];
}
</script>

<template>
    <q-layout view="lHh Lpr lFf" :class="{ 'bg-dark': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
        <Header />
        <q-page-container class="flex justify-center items-start"
            :class="{ 'bg-grey-9': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
            <div class="q-pa-md q-my-md" style="width: 800px; max-width: 95%;">
                <q-card class="q-pa-md shadow-5" :class="{ 'bg-dark': $q.dark.isActive, 'bg-white': !$q.dark.isActive }">
                    <q-card-section>
                        <div class="text-h6 q-mb-md"
                            :class="{ 'text-blue-4': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">あなたのネットワーク情報
                        </div>

                        <div class="q-gutter-y-md">
                            <!-- IPアドレス情報 -->
                            <q-card flat bordered v-if="props.ipv4" class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                IPアドレス (v4)</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }">{{
                                                props.ipv4 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.ipv4)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <q-card flat bordered v-if="props.ipv6" class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                IPアドレス (v6)</div>
                                            <div class="text-body1 break-all" :class="{ 'text-white': $q.dark.isActive }">
                                                {{ props.ipv6 }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.ipv6)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- 位置情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                国 / 都市</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }">{{
                                                CountryAndCity }}</div>
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- タイムゾーン情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }"
                                v-if="props.timezone">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                タイムゾーン</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }">{{
                                                props.timezone }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.timezone)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- ISP情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }"
                                v-if="props.isp">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                インターネットサービスプロバイダ</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }">{{
                                                props.isp }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.isp)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- ホスト情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                ホスト</div>
                                            <div class="text-body1 break-all" :class="{ 'text-white': $q.dark.isActive }">
                                                {{ props.host }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.host)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- ブラウザ情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                ブラウザ / OS / デバイス</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }">
                                                {{ props.browser_info.browser }} / {{ props.browser_info.os }} / {{
                                                props.browser_info.device }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy"
                                                @click="copyToClipboard(`${props.browser_info.browser} / ${props.browser_info.os} / ${props.browser_info.device}`)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>

                            <!-- 接続情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap cursor-pointer"
                                        @click="toggleSection('connectionInfo')">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                接続情報</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }"
                                                v-if="!expandedSections.connectionInfo">
                                                {{ props.connection_info.protocol }} / ポート: {{
                                                props.connection_info.port }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                :icon="expandedSections.connectionInfo ? 'keyboard_arrow_up' : 'keyboard_arrow_down'"
                                                text-color="white" />
                                        </div>
                                    </div>
                                    <q-slide-transition>
                                        <div v-show="expandedSections.connectionInfo" class="q-mt-md">
                                            <q-list dense>
                                                <q-item>
                                                    <q-item-section>
                                                        <q-item-label caption
                                                            :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">プロトコル</q-item-label>
                                                        <q-item-label :class="{ 'text-white': $q.dark.isActive }">{{
                                                            props.connection_info.protocol }}</q-item-label>
                                                    </q-item-section>
                                                </q-item>
                                                <q-item>
                                                    <q-item-section>
                                                        <q-item-label caption
                                                            :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">メソッド</q-item-label>
                                                        <q-item-label :class="{ 'text-white': $q.dark.isActive }">{{
                                                            props.connection_info.method }}</q-item-label>
                                                    </q-item-section>
                                                </q-item>
                                                <q-item>
                                                    <q-item-section>
                                                        <q-item-label caption
                                                            :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">ポート</q-item-label>
                                                        <q-item-label :class="{ 'text-white': $q.dark.isActive }">{{
                                                            props.connection_info.port }}</q-item-label>
                                                    </q-item-section>
                                                </q-item>
                                                <q-item>
                                                    <q-item-section>
                                                        <q-item-label caption
                                                            :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">セキュア接続</q-item-label>
                                                        <q-item-label :class="{ 'text-white': $q.dark.isActive }">{{
                                                            props.connection_info.is_secure ? 'はい' : 'いいえ'
                                                            }}</q-item-label>
                                                    </q-item-section>
                                                </q-item>
                                            </q-list>
                                        </div>
                                    </q-slide-transition>
                                </q-card-section>
                            </q-card>

                            <!-- HTTPヘッダー情報 -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap cursor-pointer"
                                        @click="toggleSection('headers')">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                HTTPヘッダー</div>
                                            <div class="text-body1" :class="{ 'text-white': $q.dark.isActive }"
                                                v-if="!expandedSections.headers">
                                                {{ Object.keys(props.headers).length }}件のヘッダー情報
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                :icon="expandedSections.headers ? 'keyboard_arrow_up' : 'keyboard_arrow_down'"
                                                text-color="white" />
                                        </div>
                                    </div>
                                    <q-slide-transition>
                                        <div v-show="expandedSections.headers" class="q-mt-md">
                                            <q-list dense>
                                                <q-item v-for="(value, key) in props.headers" :key="key">
                                                    <q-item-section>
                                                        <q-item-label caption
                                                            :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">{{
                                                            key }}</q-item-label>
                                                        <q-item-label class="break-all"
                                                            :class="{ 'text-white': $q.dark.isActive }">{{ value
                                                            }}</q-item-label>
                                                    </q-item-section>
                                                </q-item>
                                            </q-list>
                                        </div>
                                    </q-slide-transition>
                                </q-card-section>
                            </q-card>

                            <!-- ユーザーエージェント -->
                            <q-card flat bordered class="q-mb-sm"
                                :class="{ 'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive }">
                                <q-card-section>
                                    <div class="row items-center no-wrap">
                                        <div class="col">
                                            <div class="text-subtitle2"
                                                :class="{ 'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive }">
                                                ユーザーエージェント</div>
                                            <div class="text-body1 break-all" :class="{ 'text-white': $q.dark.isActive }">
                                                {{ props.user_agent }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <q-btn flat round :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
                                                icon="content_copy" @click="copyToClipboard(props.user_agent)"
                                                text-color="white" />
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn :color="$q.dark.isActive ? 'blue-8' : 'blue-9'" @click="reload" :loading="loading"
                            class="q-px-md" text-color="white">
                            <q-icon name="refresh" class="q-mr-xs" />
                            <span>更新</span>
                        </q-btn>
                    </q-card-actions>
                </q-card>
            </div>
        </q-page-container>
        <Footer />
    </q-layout>
</template>

<style>
.break-all {
    word-break: break-all;
}

.q-card--bordered {
    border: 1px solid rgba(100, 150, 255, 0.2);
}
</style>
