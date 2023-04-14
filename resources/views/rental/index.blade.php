<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 mx-auto">
                            <div class="w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">ゲーム名</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">レンタル開始日</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">レンタル終了日</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">貸出状態</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rentals as $rental)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $rental->boardgame->name }}</font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $rental->start_date }}</font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $rental->rental_date }}</font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $rental->state }}</font>
                                                    </font>
                                                </td>
                                                <td class="text-center">
                                                    <form method="post" action="{{ route('rental.destroy', $rental) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-primary-button class="ml-2 bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                                            キャンセル
                                                        </x-primary-button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                      </div>
                    </section>
                </div>
            </div>
            {{--
            <div class="mt-4">
                {{ $users->links('vendor.pagination.tailwind')}}
            </div>            
            --}}
        </div>
    </div>
</x-app-layout>
