<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>
            
            <div class="relative">
                <a href="{{ route('cart.index') }}">
                    @if(auth()->user()->carts()->count() !== 0)
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-xs absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">
                            {{ auth()->user()->carts()->count() }}
                        </span>
                    @endif
                    <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                        カートを表示
                    </x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex md:justify-around">
                    {{-- 画像領域 --}}
                    <div class="relative md:w-1/2">
                        {{-- 売り切れ判定 --}}
                        @if($exhibition->isSold())
                            <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 rounded">
                                <span class="text-white text-sm">売り切れ</span>
                            </div>
                        @endif
                        
                        @if($exhibition->boardgame->image !== '')
                            <img src="{{ asset('storage/' . $exhibition->boardgame->image ) }}" class="mx-auto lg:h-auto h-64 object-cover object-center rounded">
                        @else
                            <img src="{{ asset('img/no_image.png') }}" class="mx-auto lg:h-auto h-64 object-cover object-center rounded">
                        @endif
                    </div>
                    {{-- 本文領域 --}}
                    <div class="md:w-1/2 ml-4 flex flex-col justify-around">
                        <div>
                            {{-- カテゴリ用
                            <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $exhibition->boardgame->name }}</h2>
                            --}}
                            <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium mb-1">{{ $exhibition->boardgame->name }}</h1>
                            <p class="leading-relaxed">{{ $exhibition->description }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="title-font font-medium text-2xl text-gray-900">{{ number_format($exhibition->price) }}<span class="text-sm">円(税込み)</span></p>
                                {{-- 売り切れ判定 --}}
                                @if($exhibition->isSold())
                                    <button onclick="location.href='{{ route('exhibitions.index') }}'" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        商品一覧へ戻る
                                    </button>
                                @elseif(Auth::user()->exhibitions->contains('id', $exhibition->id))
                                    <button onclick="location.href='{{ route('cart.index') }}'" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        カートを表示
                                    </button>
                                @else
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                            カートに入れる
                                        </button>
                                        <input type="hidden" name="exhibition_id" value="{{ $exhibition->id }}">
                                    </form>
                                @endif
                            {{-- お気に入りの追加時
                            <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                </svg>
                            </button>
                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
