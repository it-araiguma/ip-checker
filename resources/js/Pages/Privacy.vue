<script setup lang="ts">
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <Header />
        <q-page-container class="flex justify-center items-start">
            <div class="q-pa-md" style="width: 800px;">
                <div class="q-gutter-y-md column">
                    <div class="q-gutter-md">
                        <div class="text-h4">
                            プライバシーポリシー
                        </div>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">
                            最終更新日: 2024年7月7日
                        </div>
                        <div>
                            このプライバシーポリシー（以下、「本ポリシー」といいます）は、IPアドレスチェッカー（以下、「本アプリ」といいます）を利用するユーザー（以下、「ユーザー」といいます）から収集する情報、その利用方法、および情報の保護に関する事項を説明するものです。
                        </div>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">1. 収集する情報</div>
                        <div>本アプリでは、以下の情報を収集する場合があります。</div>
                        <ul>
                            <li>デバイス情報（デバイスID、オペレーティングシステム、ブラウザの種類など）</li>
                            <li>ログ情報（IPアドレス、アクセス日時、使用言語など）</li>
                            <li>利用状況情報（アプリの利用履歴、クリック動作など）</li>
                        </ul>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">2. 情報の利用目的</div>
                        <div>収集した情報は、以下の目的で利用します。</div>
                        <ul>
                            <li>本アプリの提供および運営</li>
                            <li>ユーザーサポートおよびお問い合わせ対応</li>
                            <li>サービスの改善および新機能の開発</li>
                            <li>利用状況の分析および統計データの作成</li>
                            <li>法律、規制の遵守および法的要求への対応</li>
                        </ul>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">3. 情報の共有</div>
                        <div>
                            ユーザーの情報は、以下の場合を除き第三者に提供しません。
                        </div>
                        <ul>
                            <li>ユーザーの同意がある場合</li>
                            <li>法律または規制に基づき必要とされる場合</li>
                            <li>本アプリの運営に必要な業務委託先に対する提供（業務委託先は、本ポリシーに従い情報を適切に管理します）</li>
                        </ul>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">4. セキュリティ対策</div>
                        <div>
                            本アプリは、ユーザーの情報を不正アクセス、紛失、改ざん、漏洩から保護するために、合理的なセキュリティ対策を講じています。
                        </div>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">5. ユーザーの権利</div>
                        <div>
                            ユーザーは、以下の権利を有します。
                        </div>
                        <ul>
                            <li>自己情報の閲覧、修正、削除の要求</li>
                            <li>情報の利用停止または削除の要求</li>
                            <li>本ポリシーに関するお問い合わせや苦情の申し立て</li>
                        </ul>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">6. プライバシーポリシーの変更</div>
                        <div>
                            本ポリシーは、必要に応じて改訂することがあります。改訂後のポリシーは、本アプリに掲示された時点で効力を生じます。
                        </div>
                    </div>
                    <div class="q-gutter-md">
                        <div class="text-h5">7. お問い合わせ先</div>
                        <div>
                            本ポリシーに関するお問い合わせは、以下の連絡先までご連絡ください。<br>
                            <a href="https://it-araiguma.com/contact" target="_blank">ITアライグマ</a>
                        </div>
                    </div>
                </div>
            </div>
        </q-page-container>
        <Footer />
    </q-layout>
</template>

<style></style>
