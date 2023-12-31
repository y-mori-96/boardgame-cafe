<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 予約について --}}
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="text-gray-600 body-font">
                    <div class="container py-4">
                        <div class="flex justify-center">
                        
                            <div class="flex items-center sm:flex-row flex-col mr-16">
                                  <div class="sm:w-20 sm:h-20 h-8 w-8 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="sm:w-16 sm:h-16 w-10 h-10">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5l3 4.5m0 0l3-4.5M12 12v5.25M15 12H9m6 3H9m12-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                  </div>
                                  <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
                                    <h2 class="text-gray-900 text-lg title-font font-medium mb-2">料金について</h2>
                                    <p class="leading-relaxed text-base">レンタル料金：￥１００円/１日</p>
                                    <p class="leading-relaxed text-base">延滞料金　：￥１００円/１日</p>
                                  </div>
                            </div>
                            <div class="flex items-center sm:flex-row flex-col">
                                  <div class="sm:w-20 sm:h-20 h-8 w-8 sm:mr-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="sm:w-16 sm:h-16 w-10 h-10">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                    </svg>
                                  </div>
                                  <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
                                    <h2 class="text-gray-900 text-lg title-font font-medium mb-2">支払いについて</h2>
                                    <p class="leading-relaxed text-base">店頭にて</p>
                                    <p class="leading-relaxed text-base">代金の支払いと商品の受け取りを行ってください。</p>
                                  </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
            {{-- 予約状態 --}}
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
                        <form method="get" action="{{ route('rental.index') }}" class="flex justify-center items-center mb-4" >
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
                                                        
                                                        <form method="post" action="{{ route('rental.destroy', $rental) }}">
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
