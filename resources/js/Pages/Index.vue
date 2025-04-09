<script setup lang="ts">
import {ref, computed} from "vue";
import {router} from "@inertiajs/vue3";
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
  <q-layout view="lHh Lpr lFf" :class="{'bg-dark': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
    <Header/>
    <q-page-container class="flex justify-center items-start" :class="{'bg-grey-9': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
      <div class="q-pa-md q-my-md" style="width: 800px; max-width: 95%;">
        <q-card class="q-pa-md shadow-5" :class="{'bg-dark': $q.dark.isActive, 'bg-white': !$q.dark.isActive}">
          <q-card-section>
            <div class="text-h6 q-mb-md" :class="{'text-blue-4': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">あなたのネットワーク情報</div>
            
            <div class="q-gutter-y-md">
              <q-card flat bordered v-if="props.ipv4" class="q-mb-sm" :class="{'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
                <q-card-section>
                  <div class="row items-center no-wrap">
                    <div class="col">
                      <div class="text-subtitle2" :class="{'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">IPアドレス (v4)</div>
                      <div class="text-body1" :class="{'text-white': $q.dark.isActive}">{{ props.ipv4 }}</div>
                    </div>
                    <div class="col-auto">
                      <q-btn flat round :color="$q.dark.isActive ? 'blue-4' : 'blue-9'" icon="content_copy" @click="copyToClipboard(props.ipv4)" />
                    </div>
                  </div>
                </q-card-section>
              </q-card>

              <q-card flat bordered v-if="props.ipv6" class="q-mb-sm" :class="{'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
                <q-card-section>
                  <div class="row items-center no-wrap">
                    <div class="col">
                      <div class="text-subtitle2" :class="{'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">IPアドレス (v6)</div>
                      <div class="text-body1 break-all" :class="{'text-white': $q.dark.isActive}">{{ props.ipv6 }}</div>
                    </div>
                    <div class="col-auto">
                      <q-btn flat round :color="$q.dark.isActive ? 'blue-4' : 'blue-9'" icon="content_copy" @click="copyToClipboard(props.ipv6)" />
                    </div>
                  </div>
                </q-card-section>
              </q-card>

              <q-card flat bordered class="q-mb-sm" :class="{'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
                <q-card-section>
                  <div class="row items-center no-wrap">
                    <div class="col">
                      <div class="text-subtitle2" :class="{'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">国 / 都市</div>
                      <div class="text-body1" :class="{'text-white': $q.dark.isActive}">{{ CountryAndCity }}</div>
                    </div>
                  </div>
                </q-card-section>
              </q-card>

              <q-card flat bordered class="q-mb-sm" :class="{'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
                <q-card-section>
                  <div class="row items-center no-wrap">
                    <div class="col">
                      <div class="text-subtitle2" :class="{'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">ホスト</div>
                      <div class="text-body1 break-all" :class="{'text-white': $q.dark.isActive}">{{ props.host }}</div>
                    </div>
                    <div class="col-auto">
                      <q-btn flat round :color="$q.dark.isActive ? 'blue-4' : 'blue-9'" icon="content_copy" @click="copyToClipboard(props.host)" />
                    </div>
                  </div>
                </q-card-section>
              </q-card>

              <q-card flat bordered class="q-mb-sm" :class="{'bg-grey-8 q-card--bordered': $q.dark.isActive, 'bg-grey-1': !$q.dark.isActive}">
                <q-card-section>
                  <div class="row items-center no-wrap">
                    <div class="col">
                      <div class="text-subtitle2" :class="{'text-blue-2': $q.dark.isActive, 'text-blue-9': !$q.dark.isActive}">ユーザーエージェント</div>
                      <div class="text-body1 break-all" :class="{'text-white': $q.dark.isActive}">{{ props.user_agent }}</div>
                    </div>
                    <div class="col-auto">
                      <q-btn flat round :color="$q.dark.isActive ? 'blue-4' : 'blue-9'" icon="content_copy" @click="copyToClipboard(props.user_agent)" />
                    </div>
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </q-card-section>

          <q-card-actions align="right">
            <q-btn
              :color="$q.dark.isActive ? 'blue-8' : 'blue-9'"
              @click="reload"
              :loading="loading"
              class="q-px-md"
              text-color="white"
            >
              <q-icon name="refresh" class="q-mr-xs" />
              <span>更新</span>
            </q-btn>
          </q-card-actions>
        </q-card>

        <div class="q-mt-md">
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-9551028273212184"
               data-ad-slot="6291844166"
               data-ad-format="auto"
               data-full-width-responsive="true"></ins>
        </div>
      </div>
    </q-page-container>
    <Footer/>
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
