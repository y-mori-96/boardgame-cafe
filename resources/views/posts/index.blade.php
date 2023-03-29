<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $header }}
            </h2>
        </div>
    </x-slot>
    
    <div class="max-w-7xl mx-auto px-6">
        @forelse( $posts as $post )
        <div class="mt-4 p-8 bg-white w-full rounded-2lx">
            <h1 class="p-4 text-lg font-semibold">
                {{ $post->title }}
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4 whitespace-pre-wrap">{{ $post->body }}</p>
            <div class="p-4 text-sm font-semibold">
                <p>
                    {{ $post->created_at->format('Y/m/d H:i' )}}　/　{{ $post->user->name }}
                </p>
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
            </div>
        </div>
        @empty
        <div class="mt-4 p-8 bg-white w-full rounded-2lx">
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
