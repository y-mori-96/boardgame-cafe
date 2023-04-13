<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ヒーロー --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-top.hero />
            </div>
            {{-- 特徴 --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-top.section-title>
                    お店について
                </x-top.section-title>
                
                <x-top.feature />
            </div>
            {{-- 料金・システム --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-top.section-title>
                    料金・システム
                </x-top.section-title>
                
                <x-top.system />
            </div>
            {{-- よくある質問 --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-top.section-title>
                    よくある質問
                </x-top.section-title>
                
                <x-top.faq />
            </div>
            {{-- アクセス --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-top.section-title>
                    アクセス
                </x-top.section-title>

                <x-top.access />
            </div>
        </div>
    </div>
</x-app-layout>