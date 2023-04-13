<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('admin.exhibitions.store') }}">
            @csrf
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="barcode" class="font-semibold mt-4">バーコード</label>
                    <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                    <input id="barcode" type="text" name="barcode" value="{{old('barcode')}}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
            
                <div class="w-full flex flex-col">
                    <label for="description" class="font-semibold mt-4">商品説明</label>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    <textarea id="description" name="description" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md">{!! nl2br(e(old('description'))) !!}</textarea>
                </div>
                
                <div class="w-full flex flex-col">
                    <label for="price" class="font-semibold mt-4">価格</label>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    <input id="price" type="text" name="price" value="{{old('price')}}" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
                                {{--
                <div class="w-full flex flex-col">
                    <label for="image" class="font-semibold mt-4">画像を選択:</label>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    <input id="image" type="file" name="image" value="" class="w-auto py-2 border border-gray-300 rouned-md">
                </div>
                --}}
            </div>
            
            <x-primary-button class="mt-4">
                追加
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
