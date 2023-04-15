<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>

            <a href="{{ route('rental.index') }}">
                <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                    レンタル状態
                </x-primary-button>
            </a>
            {{--
            --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex md:justify-around">
                    {{-- 画像領域 --}}
                    <div class="relative md:w-1/2">
                        {{-- 売り切れ判定 
                        @if($rental_item->isSold())
                            <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 rounded">
                                <span class="text-white text-sm">売り切れ</span>
                            </div>
                        @endif
                        --}}
                        @if($rental_item->boardgame->image !== '')
                            <img src="{{ asset('storage/' . $rental_item->boardgame->image ) }}" class="mx-auto lg:h-auto h-64 object-cover object-center rounded">
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
                            <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium mb-1">{{ $rental_item->boardgame->name }}</h1>
                            <p class="leading-relaxed">{{ $rental_item->boardgame->outline }}</p>
                        </div>
                        <div>
                            <div class="flex justify-start">
                                @if($rental_item->stock_quantity <= 0 )
                                    <p class="title-font font-medium text-2xl text-gray-900 mr-10">
                                        在庫数：0 {{--マイナスはすべて0表示--}}
                                    </p>
                                    <p class="title-font font-medium text-2xl">
                                        状態：<span class="text-red-700">貸出中</span>
                                    </p>
                                @else
                                    <p class="title-font font-medium text-2xl text-gray-900 mr-10">
                                        在庫数：{{ $rental_item->stock_quantity }}
                                    </p>
                                    <p class="title-font font-medium text-2xl text-gray-900">
                                        状態：貸出可
                                    </p>
                                @endif
                            </div>
                            
                            @if($rental_item->stock_quantity <= 0 )
                                <button onclick="location.href='{{ route('rental.index') }}'" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                    レンタル状態へ
                                </button>
                            @else
                                <form method="POST" action="{{ route('rental.add') }}">
                                    <div class="flex flex-col">
                                        @csrf
                                        <div class="relative mb-3 xl:w-96">
                                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                            <label for="start_date" class="title-font font-medium text-2xl text-gray-900">レンタル予定日：</label>
                                            <input id="start_date" type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="relative mb-3 xl:w-96">
                                            <x-input-error :messages="$errors->get('rental_date')" class="mt-2" />
                                            <label for="rental_date" class="title-font font-medium text-2xl text-gray-900">レンタル終了日：</label>
                                            <input id="rental_date" type="date" name="rental_date" class="form-control" value="{{ \Carbon\Carbon::today()->addWeek()->format('Y-m-d') }}">
                                        </div>
                                        <button class="flex ml-auto text-white bg-green-700 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded">
                                            レンタル予約する
                                        </button>
                                        <input type="hidden" name="rental_item_id" value="{{ $rental_item->id }}">
                                    </div>
                                </form>
                            @endif
                            {{-- お気に入りの追加時
                            @endif
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
