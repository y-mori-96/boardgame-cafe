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
                    <div class="flex justify-between items-center px-5">
                    {{-- 金額 --}}
                        <div>
                            @php
                                $reserveTotalPrice = 0;
                                $arrearsTotalPrice = 0;
                            @endphp
                            @foreach ($rentals as $rental)
                                @if($rental->state === '予約中')
                                    @php
                                        $price = \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->rental_date));
                                        $reserveTotalPrice += $price;
                                    @endphp
                                @elseif($rental->state === '延滞')
                                    @php
                                        $price = \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->rental_date));
                                        $arrearsTotalPrice += $price;
                                    @endphp
                                @endif
                            @endforeach
                            <div class="flex">
                                <p class="mr-6">予約の合計金額: ￥{{ number_format($reserveTotalPrice * 100) }}</p>
                                <p>延滞料金:
                                    @if($arrearsTotalPrice === 0)
                                        ￥{{ number_format($arrearsTotalPrice * 100) }}
                                    @else
                                        <span class="text-red-700 font-bold">￥{{ number_format($arrearsTotalPrice * 100) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        {{-- 検索 --}}
                        <form method="get" action="{{ route('admin.rentals.index') }}" class="flex justify-center items-center mb-4" >
                          <label class="inline-flex items-center mx-4 ">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-primary" name="reserve" value="true">
                            <span class="ml-2 text-gray-700">予約中</span>
                          </label>
                          <label class="inline-flex items-center mx-4 ">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-primary" name="rental" value="true">
                            <span class="ml-2 text-gray-700">貸出中</span>
                          </label>
                          <label class="inline-flex items-center mx-4 ">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-primary" name="arrears" value="true">
                            <span class="ml-2 text-gray-700">延滞</span>
                          </label>
                          <label class="inline-flex items-center mx-4 ">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-primary" name="completion" value="true">
                            <span class="ml-2 text-gray-700">完了</span>
                          </label>
                          <button type="submit" class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                              検索する
                          </button>
                        </form>
                    </div>
                    {{-- 予約テーブル --}}
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 mx-auto">
                            <div class="w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">ユーザ名</font>
                                                </font>
                                            </th>
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
                                                    <font style="vertical-align: inherit;">期間</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">料金</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">貸出状態</font>
                                                </font>
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                {{-- 貸出 --}}
                                            </th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                {{-- キャンセル --}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rentals as $rental)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <a href="{{ route('admin.users.rentals') }}" class="hover:underline">
                                                        <font style="vertical-align: inherit;">
                                                            <font style="vertical-align: inherit;">{{ $rental->user->name }}</font>
                                                        </font>
                                                    </a>
                                                </td>
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
                                                        <font style="vertical-align: inherit;">
                                                            {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->rental_date)) }}日間
                                                        </font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">
                                                            ￥{{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->rental_date)) * 100 }}
                                                        </font>
                                                    </font>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($rental->state === '予約中')
                                                        <font style="vertical-align: inherit;" class="text-yellow-700 font-bold">{{ $rental->state }}</font>
                                                    @elseif($rental->state === '貸出中')
                                                        <font style="vertical-align: inherit;" class="text-gray-700 font-bold">{{ $rental->state }}</font>
                                                    @elseif($rental->state === '完了')
                                                        <font style="vertical-align: inherit;" class="text-gray-700 font-bold">{{ $rental->state }}</font>
                                                    @elseif($rental->state === '延滞')
                                                        <font style="vertical-align: inherit;" class="text-red-700 font-bold">{{ $rental->state }}</font>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($rental->state === '予約中')
                                                        <form method="post" action="{{ route('admin.rentals.permission', $rental) }}">
                                                            @csrf
                                                            <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 ">
                                                                貸出
                                                            </x-primary-button>
                                                        </form>
                                                    @elseif($rental->state === '貸出中')
                                                        <form method="post" action="{{ route('admin.rentals.completion', $rental) }}">
                                                            @csrf
                                                            <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 ">
                                                                完了
                                                            </x-primary-button>
                                                        </form>
                                                    @elseif($rental->state === '完了')
                                                        {{-- ボタン表示なし --}}
                                                    @elseif($rental->state === '延滞')
                                                        <form method="post" action="{{ route('admin.rentals.completion', $rental) }}">
                                                            @csrf
                                                            <x-primary-button class="bg-green-700 hover:bg-green-600 focus:bg-green-600 ">
                                                                完了
                                                            </x-primary-button>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if( ($rental->state === '予約中') )
                                                        <form method="post" action="{{ route('admin.rentals.destroy', $rental) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <x-primary-button class="ml-2 bg-red-700 hover:bg-red-600 focus:bg-red-600 active:bg-red-800">
                                                                キャンセル
                                                            </x-primary-button>
                                                        </form>
                                                    @else
                                                        {{-- ボタン表示なし --}}
                                                    @endif
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
