<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="mb-24 max-w-7xl mx-auto px-6">
        <form method="POST" action="{{ route('admin.review.store', $boardgame) }}">
            @csrf
            {{--
            --}}
            <input type="hidden" name="boardgame_id" value="{{ $boardgame->id }}">
            <div class="mt-8">
                <div class="form-group">
                    <label for="score" class="font-semibold mt-4">5段階評価</label>
                    <x-input-error :messages="$errors->get('score')" class="mt-2" />
                    <div>
                        <select class="form-control" id="score" name="score">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="w-full flex flex-col">
                <label for="title" class="font-semibold mt-4">件名</label>
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <input id="title" type="text" name="title" value="{{old('title')}}" class="w-auto py-2 border border-gray-300 rouned-md">
            </div>

            <div class="w-full flex flex-col">
                <label for="body" class="font-semibold mt-4">本文</label>
                <x-input-error :messages="$errors->get('body')" class="mt-2" />
                <textarea id="body" name="body" cols="30" rows="5" class="w-auto py-2 border border-gray-300 rouned-md">{!! nl2br(e(old('body'))) !!}</textarea>
            </div>
            
            <x-primary-button class="mt-4">
                投稿
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
