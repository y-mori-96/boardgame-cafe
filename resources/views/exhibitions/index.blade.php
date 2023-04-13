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
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <!-- 商品表示 -->
                <div class="container mx-auto px-5 py-2 lg:px-32 lg:pt-12">
                    <div class="-m-1 flex flex-wrap md:-m-2">
                        {{--
                        --}}
                        @forelse( $exhibitions as $exhibition ) 
                            <div class="flex w-1/3 flex-wrap">
                                <div class="w-full p-1 md:p-2 relative">
                                    <a href="{{ route('exhibitions.show', $exhibition ) }}" class="bg-white block relative h-48 rounded overflow-hidden shadow-sm">
                                        @if($exhibition->boardgame->image !== '')
                                            <img src="{{ asset('storage/' . $exhibition->boardgame->image ) }}"  class="mx-auto  block h-full max-w-full rounded-lg object-cover object-center">
                                　　      @else
                                            <img src="{{ asset('img/no_image.png') }}" class="mx-auto block h-full max-w-full rounded-lg object-cover object-center">
                                        @endif
                                        {{-- 売り切れ判定 --}}
                                        @if($exhibition->isSold())
                                            <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 rounded">
                                                <span class="text-white text-sm">売り切れ</span>
                                            </div>
                                        @endif
                                        <div class="absolute bottom-0 w-full bg-black bg-opacity-60 text-white text-xs py-1 px-2 text-right rounded-b">
                                            {{ $exhibition->price }} 円
                                        </div>
                                    </a>
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
                {{--
                <section class="text-gray-600 body-font">
                  <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap -m-4">
                    @forelse( $exhibitions as $exhibition ) 
                      <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                            @if($exhibition->boardgame->image !== '')
                                <a href="{{ route('exhibitions.show', $exhibition ) }}" class="block relative h-48 rounded overflow-hidden">
                                    <img src="{{ asset('storage/' . $exhibition->boardgame->image ) }}"  class="h-52">
                                </a>
                    　　      @else
                                <img src="{{ asset('img/no_image.png') }}" class="h-52">
                            @endif
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">CATEGORY</h3>
                            <h2 class="text-gray-900 title-font text-lg font-medium">{{ $exhibition->boardgame->name }}</h2>
                            <p class="mt-1">{{ number_format($exhibition->price) }}<span class="text-sm">円(税込み)</span></p>
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
                --}}
                {{--
                @empty
                <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
                    <p class="p-4 text-lg font-semibold">
                        ボードゲームがありません
                    </p>
                </div>
            　　@endforelse
            　　--}}
            　　{{-- ペジネーション作成時追加
            　　<div class="mb-4">
                    {{ $posts->links('vendor.pagination.tailwind')}}
                </div>
                --}}
            </div>
        </div>
    </div>
</x-app-layout>

                                        {{--
                                    <!--ボタン-->
                                    <div class="flex justify-start">
                                        
                                        <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" >
                                            <x-primary-button>
                                                編集
                                            </x-primary-button>
                                        </a>
                                        
                                        <a href="{{ route('admin.boardgames.edit', $boardgame) }}" >
                                            <x-primary-button>
                                                画像編集
                                            </x-primary-button>
                                        </a>
                                        
                                        <form method="post" action="{{ route('admin.exhibitions.destroy', $exhibition) }}">
                                            @csrf
                                            @method('delete')
                                            <x-primary-button class="ml-2 bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                                削除
                                            </x-primary-button>
                                        </form>
                                    </div>
                                        --}}