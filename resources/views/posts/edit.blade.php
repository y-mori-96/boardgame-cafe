<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="mb-24 max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('patch')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="title" class="font-semibold mt-4">件名</label>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
            </div>
            
            <div class="w-full flex flex-col">
                <label for="body" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                <textarea id="body" name="body" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md" >{{ old('body', $post->body) }}</textarea>
            </div>
            
            <x-primary-button class="mt-4">
                保存
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
