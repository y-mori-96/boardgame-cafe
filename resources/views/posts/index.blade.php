<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>
        
            <!--検索-->
            <div class="flex justify-center items-center">
                <div class="xl:w-96">
                    <form method="get" action="{{ route('posts.index') }}">
                        <div class="relative flex w-full flex-wrap items-stretch">
                            <input
                                type="search"
                                name="search"
                                placeholder="キーワード検索"
                                value="{{ $search ?? '' }}"
                                class="relative m-0 -mr-px block w-[1%] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out"
                            />
                            <button class="relative z-[2] rounded-r border-2 border-blue-500 px-6 py-2 text-blue-500 text-xs font-medium uppercase transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0">
                                検索
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- おすすめユーザー表示 -->
    <div class="container max-w-7xl my-6 px-6 mx-auto">
      <section class="text-center lg:text-left">
        <h2 class="text-3xl font-bold mb-2">
          おすすめユーザ
        </h2>
    
        <div class="grid md:grid-cols-3 gap-6 xl:gap-x-12">
            {{-- デバッグ用
            --}}
            @forelse($recommended_users as $recommended_user)
                <div class="mb-6 lg:mb-0">
                    <div class="relative block rounded-lg shadow-lg bg-white p-6">
                        <div class="lg:flex flex-row items-center">
                            
                            <!--プロフィール画像を追加したとき-画像領域-を追加する-->
                            
                            <!--画像領域-->
                            <!--<div class="grow-0 shrink-0 basis-auto w-full lg:w-5/12 lg:pr-6">-->
                            <!--    <img-->
                            <!--        src="https://mdbootstrap.com/img/new/avatars/2.jpg"-->
                            <!--        alt="Trendy Pants and Shoes"-->
                            <!--        class="w-full rounded-md mb-6 lg:mb-0"-->
                            <!--     />-->
                            <!--</div>-->
                            
                            <!--プロフィール画像を追加したとき-本文領域-を変更する-->
                            <!--本文領域-->
                            <!--<div class="grow-0 shrink-0 basis-auto w-full lg:w-7/12">-->
                            <div class="mx-auto">
                                <!--名前-->
                                <p class="text-lg font-bold mb-2 hover:underline">
                                    <a href="{{ route('users.show', $recommended_user) }}">
                                        {{ $recommended_user->name }}
                                    </a>
                                </p>
                                <!--フォローボタン-->
                                <div class="list-inside flex mx-auto justify-center lg:justify-start">
                                    @if(Auth::user()->isFollowing($recommended_user))
                                        <form method="post" action="{{route('follows.destroy', $recommended_user)}}">
                                            @csrf
                                            @method('delete')
                                            <x-primary-button class="bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                                フォロー解除
                                            </x-primary-button>
                                        </form>
                                    @else
                                    <form method="post" action="{{route('follows.store')}}">
                                        @csrf
                                        <input type="hidden" name="follow_id" value="{{ $recommended_user->id }}">
                                        <x-primary-button>
                                            フォロー
                                        </x-primary-button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="mb-6 lg:mb-0">
                    <div class="relative block rounded-lg shadow-lg bg-white p-6">
                        <p>他のユーザーが存在しません。</p>
                    </div>
                </div>
            @endforelse
            {{-- デバッグ用
            --}}
        </div>
      </section>
    </div>

    <!-- 投稿表示 -->
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-2">
          タイムライン
        </h2>
        @forelse( $posts as $post )
        <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
            <h1 class="p-4 text-lg font-semibold">
                {{ $post->title }}
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4 whitespace-pre-wrap">{{ $post->body }}</p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{ $post->created_at->format('Y/m/d H:i' )}}　/　{{ $post->user->name }}
                </p>
                <!--ボタン-->
                @if($post->user_id == Auth::user()->id)
                    <div class="flex justify-start">
                        <a href="{{ route('posts.edit', $post) }}" >
                            <x-primary-button>
                                編集
                            </x-primary-button>
                        </a>
                        
                        <form method="post" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('delete')
                            <x-primary-button class="ml-2 bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                削除
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
            <p class="p-4 text-lg font-semibold">
                投稿がありません
            </p>
        </div>
    　　@endforelse
    　　<div class="mb-4">
            {{ $posts->links('vendor.pagination.tailwind')}}
        </div>
    </div>
</x-app-layout>
