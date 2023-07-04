<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
                {{ $boardgame->name }}
            </h2>
            <div class="flex font-semibold text-xl text-gray-800 leading-tight">
                <p>
                  　総評価：{{ number_format($average_score, 1) }}　/
                </p>
                <p>
                  　{{ $review_count }}個の評価
                </p>
            </div>
            {{-- 店長の声を追加する際コメントアウト外す
            <div class="relative">
                <a href="{{ route('review.create', $boardgame) }}">
                    <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                        レビューを投稿する
                    </x-primary-button>
                </a>
            </div>
            --}}
        </div>
    </x-slot>
    
    {{-- 概要 --}}
    <div class="my-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" md:flex-col md:justify-around">
                    
                    {{-- カテゴリ用
                    <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $boardgame->boardgame->name }}</h2>
                    --}}

                    {{-- 動画 --}}
                    <div class="w-full">
                        <iframe class="mx-auto" width="560" height="315"
                            src="{{$boardgame->video}}"
                            title="{{$boardgame->name}}"
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="flex justify-center">
                        {{-- 動画の下に何か追加したい場合
                        <a href="{{ route('reviews.create') }}" >
                            <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                                レビューを書く
                            </x-primary-button>
                        </a>
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 説明 --}}
    <div class="my-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold mb-2">
              概要
            </h3>
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex-col md:justify-around">
                    {{$boardgame->description}}                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- レビュー --}}
    <div class="my-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold mb-2">
              店内レビュー
            </h3>
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex-col md:justify-around">
                    @forelse($reviews as $review)
                    <div class="my-4 p-8 bg-white w-full rounded-2lx shadow-lg">
                        {{--評価値--}}
                        <div class="flex">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $review->score)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-500">
                                      <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-500">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        
                        <h4 class="p-4 text-lg font-semibold">
                            {{ $review->title }}
                        </h4>
                        <hr class="w-full">
                        <p class="mt-4 p-4 whitespace-pre-wrap">{{ $review->body }}</p>
                        <div class="p-4 text-sm font-semibold">
                            <p>
                                {{ $review->created_at->format('Y/m/d H:i' )}}　/　{{ $review->user->name }}
                            </p>
                            <!--ボタン-->
                            <div class="flex justify-start">
                                <a href="{{ route('review.edit', $review->id) }}" >
                                    <x-primary-button>
                                        編集
                                    </x-primary-button>
                                </a>
                                
                                <form method="post" action="{{ route('review.destroy', $review) }}">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button class="ml-2 bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                        削除
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p>レビューが存在しません。</p>
                    @endforelse
                </div>
                <div class="mb-4">
                    {{ $reviews->links('vendor.pagination.tailwind')}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
