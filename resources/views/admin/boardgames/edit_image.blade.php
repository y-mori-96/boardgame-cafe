<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if($boardgame->image !== '')
            <img src="{{ \Storage::url($boardgame->image) }}">
        @else
            <p>画像はありません。</p>
        @endif
        <form method="POST" action="{{ route('admin.boardgames.update_image', $boardgame) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    {{--
                    @if($boardgame->image !== '')
                        <img src="{{ \Storage::url($boardgame->image) }}">
                    @else
                        画像はありません。
                    @endif
                    --}}
                    <label for="image" class="font-semibold mt-4">画像を選択:</label>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    <input id="image" type="file" name="image" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
            </div>
            
            <x-primary-button class="mt-4">
                変更
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
