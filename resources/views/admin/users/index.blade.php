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
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">名前</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">メールアドレス</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">作成日</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $user->name }}</font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $user->email }}</font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">{{ $user->created_at->diffForHumans() }}</font>
                                                    </font>
                                                </td>
                                                <td class="w-16 text-center">
                                                    {{--詳細を表示できるようにする--}}
                                                    <x-secondary-button class="bg-blue-500">
                                                        詳細
                                                    </x-secondary-button>
                                                    <!--<input name="plan" type="radio">-->
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
            <div class="mt-4">
                {{ $users->links('vendor.pagination.tailwind')}}
            </div>            
        </div>
    </div>
</x-app-layout>
