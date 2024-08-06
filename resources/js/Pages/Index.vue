<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted, nextTick } from "vue";
import { router } from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";

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

const reload = () => {
    router.reload();
}

const CountryAndCity = computed(() => {
    return `${props.country} / ${props.city}`;
});

// 広告コンテナの参照を作成
const adContainer = ref(null)

// Admob SDKをロードする関数
const loadAdmobSDK = () => {
    return new Promise((resolve) => {
        const script = document.createElement('script');
        script.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
        script.async = true;
        script.onload = resolve;
        document.head.appendChild(script);
    })
}

// 広告を表示する関数
const displayAd = () => {
    if (adContainer.value) {
        const rect = adContainer.value.getBoundingClientRect();
        console.log('Ad container size:', rect.width, rect.height);

        if (rect.width > 0) {
            const adElement = document.createElement('ins');
            adElement.className = 'adsbygoogle';
            adElement.style.display = 'block';
            adElement.dataset.adClient = 'ca-app-pub-9551028273212184';
            adElement.dataset.adSlot = '7613538463';
            adElement.dataset.adFormat = 'auto';
            adElement.dataset.fullWidthResponsive = 'true';

            adContainer.value.innerHTML = '';  // Clear existing content
            adContainer.value.appendChild(adElement);

            try {
                (adsbygoogle = window.adsbygoogle || []).push({});
            } catch (error) {
                console.error('Error initializing ad:', error);
            }
        } else {
            console.error('Ad container has no width');
        }
    }
}

onMounted(async () => {
    if (props.is_twa) {
        await loadAdmobSDK()
        nextTick(() => {
            displayAd()
        })

        // ウィンドウのリサイズイベントをリッスン
        window.addEventListener('resize', displayAd)
    }
})

// コンポーネントのアンマウント時にイベントリスナーを削除
onUnmounted(() => {
    window.removeEventListener('resize', displayAd)
    if (adContainer.value) {
        adContainer.value.innerHTML = ''
    }
})
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
                        <q-input stack-label :dense="dense" label="国 / 都市" readonly v-model="CountryAndCity" />
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
            <div ref="adContainer" class="ad-container" v-if="props.is_twa"></div>
        </q-page-container>
        <Footer />
    </q-layout>
</template>

<style>
.break-all {
    word-break: break-all;
}

.ad-container {
    width: 100%;
    min-height: 100px;
    background-color: #f0f0f0;
}

.ad-container ins.adsbygoogle {
    display: block;
    margin: 0 auto;
}
</style>
