<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($exhibitions) > 0)
                        @foreach ($exhibitions as $exhibition)
                        <div class="md:flex md:items-center mb-2">
                            {{-- 画像 --}}
                            <div class="md:w-3/12">
                                {{-- 売り切れ判定 --}}
                                @if($exhibition->isSold())
                                    <p>sold</p>
                                @endif
                                
                                @if($exhibition->boardgame->image !== '')
                                    <img src="{{ asset('storage/' . $exhibition->boardgame->image ) }}" class="h-52">
                        　　      @else
                                    <img src="{{ asset('img/no_image.png') }}" class="h-52">
                                @endif
                        
                            </div>
                            {{-- タイトル --}}
                            <div class="md:w-4/12 md:ml-2">
                                {{ $exhibition->boardgame->name }}
                            </div>
                            {{-- 料金 --}}
                            <div class="md:w-3/12">
                                <p class="title-font font-medium text-2xl text-gray-900">
                                    {{ number_format($exhibition->price) }}<span class="text-sm">円(税込み)</span>
                                </p>
                            </div>
                            {{-- 削除ボタン --}}
                            <div class="md:w-2/12">
                                <div class="flex justify-around items-center">
                                    <a href="{{ route('exhibitions.show', $exhibition ) }}">
                                        <button class="text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded">
                                            詳細
                                        <button>
                                    </a>
                                    <form method="post" action="{{ route('cart.destroy', $exhibition) }}">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button class="bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </x-primary-button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="my-2">
                            小計：{{ number_format($totalPrice) }}<span class="text-sm">円(税込み)</span>
                        </div>
                        <div class="flex justify-end">
                            <button onclick="location.href='{{ route('exhibitions.index') }}'" class="mr-4 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                もっと探す
                            </button>
                            {{--
                            <button onclick="location.href='{{ route('cart.checkout') }}'" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                購入する
                            </button>
                            --}}
                            <form method="post" action="{{ route('exhibitions.add_soldItem', $exhibition) }}">
                                @csrf
                                @method('patch')
                                <button class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    購入する
                                </button>
                            </form>
                        </div>
                    @else
                        カートに商品が入っていません。
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
