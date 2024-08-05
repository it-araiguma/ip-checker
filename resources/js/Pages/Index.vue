<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from "vue";
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
        const script = document.createElement('script')
        script.src = `https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=pub-9551028273212184`
        script.async = true
        script.onload = resolve
        document.head.appendChild(script)
    })
}

// 広告を表示する関数
const displayAd = () => {
    if (adContainer.value && window.adsbygoogle) {
        const adInsElement = document.createElement('ins')
        adInsElement.className = 'adsbygoogle'
        adInsElement.style.display = 'block'
        adInsElement.setAttribute('data-ad-client', 'pub-9551028273212184')
        adInsElement.setAttribute('data-ad-slot', 'ca-app-pub-3940256099942544/9214589741')
        adInsElement.setAttribute('data-ad-format', 'auto')
        adInsElement.setAttribute('data-full-width-responsive', 'true')

        adContainer.value.appendChild(adInsElement)
            ; (window.adsbygoogle = window.adsbygoogle || []).push({})
    }
}

// コンポーネントがマウントされたときの処理
onMounted(async () => {
    await loadAdmobSDK()
    displayAd()
})

// コンポーネントがアンマウントされたときのクリーンアップ
onUnmounted(() => {
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
                <div id="ad-container">
                    <ins class="adsbygoogle" style="display:block" data-ad-client="pub-9551028273212184"
                        data-ad-slot="ca-app-pub-9551028273212184/7613538463" data-ad-format="auto"
                        data-full-width-responsive="true"></ins>
                </div>
                <div ref="adContainer" class="ad-container"></div>
            </div>
        </q-page-container>
        <Footer />
    </q-layout>
</template>

<style>
.break-all {
    word-break: break-all;
}

.ad-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.ad-container ins.adsbygoogle {
    display: block;
    margin: 0 auto;
}
</style>
