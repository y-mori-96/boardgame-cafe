<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- 投稿表示 -->
                <div class="max-w-7xl mx-auto px-6">
                    @forelse( $boardgames as $boardgame )
                    <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
                        <h1 class="p-4 text-lg font-semibold">
                            {{ $boardgame->name }}
                        </h1>
                        <hr class="w-full">
                        <p class="mt-4 p-4 whitespace-pre-wrap">{{ $boardgame->outline }}</p>
                        <div class="p-4 text-sm font-semibold">
                            <!--ボタン-->
                            <div class="flex justify-start">
                                <a href="{{ route('admin.boardgames.edit', $boardgame) }}" >
                                    <x-primary-button>
                                        編集
                                    </x-primary-button>
                                </a>
                                
                                <form method="post" action="{{ route('admin.boardgames.destroy', $boardgame) }}">
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
                    <div class="mt-4 p-8 bg-white w-full rounded-2lx shadow-lg">
                        <p class="p-4 text-lg font-semibold">
                            ボードゲームがありません
                        </p>
                    </div>
                　　@endforelse
                　　{{--
                　　<div class="mb-4">
                        {{ $posts->links('vendor.pagination.tailwind')}}
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
