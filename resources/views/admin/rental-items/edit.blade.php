<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('admin.rental-items.update', $rental_item) }}">
            @csrf
            @method('patch')
            <div class="mt-8">
                <div class="w-full flex flex-col">
                    <label for="stock_quantity" class="font-semibold mt-4">在庫数</label>
                    <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                    <input id="stock_quantity" type="text" name="stock_quantity" value="{{old('stock_quantity', $rental_item->stock_quantity )}}" class="w-auto py-2 border border-gray-300 rouned-md">
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
                変更
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
