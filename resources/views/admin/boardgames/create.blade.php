<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('admin.boardgames.store') }}">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="name" class="font-semibold mt-4">名前</label>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <input id="name" type="text" name="name" value="{{old('name')}}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
            </div>
            
            <div class="w-full flex flex-col">
                <label for="barcode" class="font-semibold mt-4">バーコード</label>
                <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                <input id="barcode" type="text" name="barcode" value="{{old('barcode')}}" class="w-auto py-2 border border-gray-300 rouned-md">
            </div>

            
            <div class="w-full flex flex-col">
                <label for="outline" class="font-semibold mt-4">概要</label>
                <x-input-error :messages="$errors->get('outline')" class="mt-2" />
                <textarea id="outline" name="outline" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md">{!! nl2br(e(old('outline'))) !!}</textarea>
            </div>
            
            <x-primary-button class="mt-4">
                追加
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
