<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>
        </div>
    </x-slot>
    
    <!-- おすすめユーザー表示 -->
    <div class="max-w-7xl mx-auto px-6 my-6 font-semibold">
        <div class="w-full p-8 bg-white shadow-lg">
            <div class="flex flex-col">
                <!--名前-->
                <p class="text-lg text-center font-bold">
                    {{ $user->name }}
                </p>
            
                <!--フォローボタン-->
                @if($user != Auth::user())
                    <div class="mt-2 list-inside flex mx-auto justify-center lg:justify-start">
                        @if(Auth::user()->isFollowing($user))
                            <form method="post" action="{{route('follows.destroy', $user)}}">
                                @csrf
                                @method('delete')
                                <x-primary-button  class="bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                    フォロー解除
                                </x-primary-button>
                            </form>
                        @else
                        <form method="post" action="{{route('follows.store')}}">
                            @csrf
                            <input type="hidden" name="follow_id" value="{{ $user->id }}">
                            <x-primary-button>
                                フォロー
                            </x-primary-button>
                        </form>
                    @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- 投稿表示 -->
    <div class="max-w-7xl mx-auto px-6">
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
                @if($user == Auth::user())
                    <div class="flex justify-start">
                        <a href="{{ route('posts.edit', $post) }}" >
                            <x-primary-button>
                                編集
                            </x-primary-button>
                        </a>
                        
                        <form method="post" class="delete" action="{{ route('posts.destroy', $post) }}">
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
