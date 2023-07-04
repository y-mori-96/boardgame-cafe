<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="mb-24 max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('admin.boardgames.update', $boardgame) }}">
            @csrf
            @method('patch')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="name" class="font-semibold mt-4">名前</label>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <input id="name" type="text" name="name" value="{{ old('name', $boardgame->name) }}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
            
                <div class="w-full flex flex-col">
                    <label for="barcode" class="font-semibold mt-4">バーコード</label>
                    <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                    <input id="barcode" type="text" name="barcode" value="{{old('barcode', $boardgame->barcode)}}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
    
                <div class="w-full flex flex-col">
                    <label for="outline" class="font-semibold mt-4">概要</label>
                    <x-input-error :messages="$errors->get('outline')" class="mt-2" />
                    <textarea id="outline" name="outline" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md">{{ old('outline', $boardgame->outline) }}</textarea>
                </div>
                
                <div class="w-full flex flex-col">
                    <label for="description" class="font-semibold mt-4">説明</label>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    <textarea id="description" name="description" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md">{{ old('description', $boardgame->description) }}</textarea>
                </div>
            </div>
            
            <x-primary-button class="mt-4">
                変更
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
