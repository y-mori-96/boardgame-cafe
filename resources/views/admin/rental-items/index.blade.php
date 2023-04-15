<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>

            <a href="{{ route('admin.rental-items.create') }}">
                <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                    新規レンタル商品
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="text-gray-600 body-font">
                  <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4">
                        @forelse( $rental_items as $rental_item ) 
                          <div class="xl:w-1/4 md:w-1/2 p-4">
                            <div class="bg-gray-100 p-6 rounded-lg">
                                <a href="{{ route('admin.rental-items.show', $rental_item) }}" class="mb-6 bg-white block relative h-48 rounded overflow-hidden shadow-sm">
                                    @if($rental_item->boardgame->image !== '')
                                        <img src="{{ asset('storage/' . $rental_item->boardgame->image ) }}"  class="mx-auto  block h-full max-w-full rounded-lg object-cover object-center">
                            　　      @else
                                        <img src="{{ asset('img/no_image.png') }}" class="mx-auto block h-full max-w-full rounded-lg object-cover object-center">
                                    @endif
                                        @if($rental_item->stock_quantity > 0 )
                                            <div class="absolute left-5 bottom-5 flex items-center justify-center bg-green-700 bg-opacity-60 rounded p-3">
                                                <span class="text-white text-sm">貸出可</span>
                                            </div>
                                        @else
                                            <div class="absolute left-5 bottom-5 flex items-center justify-center bg-red-700 bg-opacity-60 rounded p-3">
                                                <span class="text-white text-sm">貸出中</span>
                                            </div>
                                        @endif
                                </a>
                                <h3 class="text-lg text-gray-900 font-medium title-font mb-4">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">{{ $rental_item->boardgame->name }}</font>
                                    </font>
                                </h3>
                                <p class="leading-relaxed text-base">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">{{ $rental_item->boardgame->outline }}</font>
                                    </font>
                                </p>
                                <p class="leading-relaxed text-base">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            @if($rental_item->stock_quantity <= 0 )
                                                在庫数：0 {{--マイナスはすべて0表示--}}
                                            @else
                                                在庫数：{{ $rental_item->stock_quantity }}
                                            @endif
                                        </font>
                                    </font>
                                </p>
                            </div>
                          </div>
                        @empty
                            <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
                                <p class="p-4 text-lg font-semibold">
                                    ボードゲームがありません
                                </p>
                            </div>
                        @endforelse
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
