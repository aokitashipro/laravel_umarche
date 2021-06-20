<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品一覧
            </h2>
                <form method="get" action="{{ route('user.items.index')}}">
                    <div class="lg:flex lg:justify-around">
                        <div class="lg:flex items-center">
                            <select name="category" class="mb-2 lg:mb-0 lg:mr-2">
                                <option value="0" @if(\Request::get('category') === '0') selected @endif>全て</option>
                                @foreach($categories as $category)
                                <optgroup label="{{ $category->name }}">
                                 @foreach($category->secondary as $secondary)
                                   <option value="{{ $secondary->id}}" @if(\Request::get('category') == $secondary->id) selected @endif >
                                    {{ $secondary->name }}
                                   </option>
                                 @endforeach
                               @endforeach  
                            </select>
                            <div class="flex space-x-2 items-center">
                                <div><input name="keyword" class="border border-gray-500 py-2" placeholder="キーワードを入力"></div>
                                <div><button class="ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">検索する</button></div>
                            </div>
                        </div>
                        <div class="flex">
                        <div>
                            <span class="text-sm">表示順</span><br>
                            <select id="sort" name="sort" class="mr-4">
                                <option value="{{ \Constant::SORT_ORDER['recommend']}}"
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['recommend'] ) 
                                    selected 
                                    @endif>おすすめ順
                                </option>
                                <option value="{{ \Constant::SORT_ORDER['higherPrice']}}" 
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['higherPrice'] ) 
                                    selected 
                                    @endif>料金の高い順
                                </option>
                                <option value="{{ \Constant::SORT_ORDER['lowerPrice']}}"
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['lowerPrice'] ) 
                                    selected 
                                    @endif>料金の安い順    
                                </option>
                                <option value="{{ \Constant::SORT_ORDER['later']}}"
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['later'] ) 
                                    selected 
                                    @endif>新しい順
                                </option>
                                <option value="{{ \Constant::SORT_ORDER['older']}}"
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['older'] ) 
                                    selected 
                                    @endif>古い順
                                </option>
                            </select>
                        </div>
                        <div>
                            <span class="text-sm">表示件数</span><br>
                            <select id="pagination" name="pagination">
                                <option value="20"
                                    @if(\Request::get('pagination') === '20')
                                    selected
                                    @endif>20件
                                </option>
                                <option value="50"
                                    @if(\Request::get('pagination') === '50')
                                    selected
                                    @endif>50件
                                </option>
                                <option value="100"
                                    @if(\Request::get('pagination') === '100')
                                    selected
                                    @endif>100件
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div class="flex flex-wrap">
                    
                     @foreach($products as $product)
                       <div class="w-full lg:w-1/4 p-2 md:p-4">
                        <a href="{{ route('user.items.show', ['item' => $product->id ])}}">    
                       <div class="border rounded-md p-2 md:p-4">
                         <x-thumbnail filename="{{$product->filename ?? ''}}" type="products" />
                            <div class="mt-4">
                                <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category }}</h3>
                                <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円(税込)</span></p>
                              </div>
                       </div>
                       </a>
                       </div>
                       @endforeach
                     
                     </div>
                     {{ $products->appends([
                         'sort' => \Request::get('sort'),
                         'pagination' => \Request::get('pagination')
                     ])->links() }}
                </div>
            </div>
        </div>
    </div>
<script>
    const select = document.getElementById('sort')
    select.addEventListener('change', function(){
        this.form.submit()
    })
    const paginate = document.getElementById('pagination')
    paginate.addEventListener('change', function(){
        this.form.submit()
    })

</script>
</x-app-layout>
