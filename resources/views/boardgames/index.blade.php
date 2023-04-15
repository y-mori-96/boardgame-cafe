<x-app-layout>
    <x-slot name="header">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    
        <!--検索-->
        <div class="flex justify-center items-center">
            <div class="xl:w-96">
                <form method="get" action="{{ route('boardgames.index') }}">
                    <div class="relative flex w-full flex-wrap items-stretch">
                        <input
                            type="search"
                            name="search"
                            placeholder="ボードゲームを検索"
                            value="{{ $search ?? '' }}"
                            class="relative m-0 -mr-px block w-[1%] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out"
                        />
                        <button class="relative z-[2] rounded-r border-2 border-blue-500 px-6 py-2 text-blue-500 text-xs font-medium uppercase transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0">
                            検索
                        </button>
                    </div>
                </form>
       　　  </div>
        </div>
      </div>
    </x-slot>

    <div class="py-12">
        {{--
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        --}}
            <!-- 投稿表示 -->
            <div class="max-w-7xl mx-auto px-6">
                <!-- Container for demo purpose -->
                <div class="container my-6 px-6 mx-auto">
                  <!-- Section: Design Block -->
                  <section class="mb-32 text-gray-800">
                    <div class="grid lg:grid-cols-3 gap-6 xl:gap-x-12">
                        @forelse( $boardgames as $boardgame )
                            <div class="mb-6 lg:mb-0">
                              <div class="relative block bg-white rounded-lg shadow-lg">
                                <div class="flex justify-center">
                                  <div class="relative overflow-hidden bg-no-repeat bg-cover bg-no-repeat bg-cover shadow-lg rounded-lg mx-4 -mt-4" data-mdb-ripple="true" data-mdb-ripple-color="light">
                                      @if($boardgame->image !== '')
                                          <img src="{{ asset('storage/' . $boardgame->image) }}" class="h-52">
                                      @else
                                          <img src="{{ asset('img/no_image.png') }}" class="h-52">
                                      @endif
                                    {{--
                                    <a href="#!">
                                      <div class="absolute top-0 right-0 bottom-0 left-0 w-full h-full overflow-hidden bg-fixed opacity-0 hover:opacity-100 transition duration-300 ease-in-out" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                                    </a>
                                    --}}
                                  </div>
                                </div>
                                <div class="p-6">
                                  <h5 class="font-bold text-lg mb-3">{{ $boardgame->name }}</h5>
                                  <p class="mb-4 pb-2">
                                      {{ $boardgame->outline }}
                                  </p>
                                  <div class="flex justify-center">
                                      {{--
                                      <a href="{{ route('boardgames.show', $boardgame) }}" >
                                          <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 active:bg-green-800">
                                              詳細
                                          </x-primary-button>
                                      </a>
                                      --}}
                                  </div>
                                  {{--
                                  <a href="#!" data-mdb-ripple="true" data-mdb-ripple-color="light" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                      詳細
                                  </a>
                                  --}}
                                </div>
                              </div>
                            </div>
                        @empty
                        <p class="text-lg font-semibold">
                            ボードゲームがありません
                        </p>
                        @endforelse
                    </div>
                  </section>
                  <!-- Section: Design Block -->
                </div>
                <!-- Container for demo purpose -->
            　　{{--
            　　<div class="mb-4">
                    {{ $posts->links('vendor.pagination.tailwind')}}
                </div>
                --}}
            </div>
        </div>
        {{--
        </div>
    </div>
        --}}
</x-app-layout>
