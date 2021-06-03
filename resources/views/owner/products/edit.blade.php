<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />  
                <x-flash-message status="session('status')" /> 
                <form method="post" action="{{ route('owner.products.update', ['product' => $product->id ])}}" >
                    @csrf
                    @method('put')
                    <div class="-m-2">
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                          <input type="text" id="name" name="name" value="{{ $product->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                          <textarea id="information" name="information" rows="10" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $product->information }}</textarea>
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                          <input type="number" id="price" name="price" value="{{ $product->price }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                          <input type="number" id="sort_order" name="sort_order" value="{{ $product->sort_order }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="current_quantity" class="leading-7 text-sm text-gray-600">現在の在庫</label>
                          <input type="hidden" id="current_quantity" name="current_quantity" value="{{ $quantity }}" >
                          <div class="w-full bg-gray-100 bg-opacity-50 rounded text-base outline-none text-gray-700 py-1 px-3 leading-8">{{ $quantity }}</div>
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative flex justify-around">
                          <div><input type="radio" name="type" value="{{ \Constant::PRODUCT_LIST['add']}}" class="mr-2" checked>追加</div>
                          <div><input type="radio" name="type" value="{{ \Constant::PRODUCT_LIST['reduce']}}" class="mr-2" >削減</div>
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="quantity" class="leading-7 text-sm text-gray-600">数量 ※必須</label>
                          <input type="number" id="quantity" name="quantity" value="0" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          <span class="text-sm">0〜99の範囲で入力してください</span>
                        </div>
                      </div>
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="shop_id" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                          <select name="shop_id" id="shop_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                          @foreach ($shops as $shop )
                          <option value="{{ $shop->id}}" @if($shop->id === $product->shop_id) selected @endif >
                            {{ $shop->name }}
                           </option>
                          @endforeach
                          </select>
                        </div>
                      </div> 
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                          <label for="category" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                          <select name="category" id="category" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            @foreach($categories as $category)
                             <optgroup label="{{ $category->name }}">
                              @foreach($category->secondary as $secondary)
                                <option value="{{ $secondary->id}}" @if( $secondary->id === $product->secondary_category_id ) selected @endif >
                                 {{ $secondary->name }}
                                </option>
                              @endforeach
                            @endforeach
                           </select>
                          
                        </div>
                      </div>
                      <x-select-image :images="$images" currentId="{{$product->image1}}" currentImage="{{$product->imageFirst->filename ?? ''}}" name="image1" />
                      <x-select-image :images="$images" currentId="{{$product->image2}}" currentImage="{{$product->imageSecond->filename ?? ''}}" name="image2" />
                      <x-select-image :images="$images" currentId="{{$product->image3}}" currentImage="{{$product->imageThird->filename ?? ''}}" name="image3" />
                      <x-select-image :images="$images" currentId="{{$product->image4}}" currentImage="{{$product->imageFourth->filename ?? ''}}" name="image4" />
                      <x-select-image :images="$images" name="image5" />
                      <div class="p-2 w-1/2 mx-auto">
                        <div class="relative flex justify-around">
                          <div><input type="radio" name="is_selling" value="1" class="mr-2" @if($product->is_selling === 1){ checked } @endif>販売中</div>
                          <div><input type="radio" name="is_selling" value="0" class="mr-2" @if($product->is_selling === 0){ checked } @endif>停止中</div>
                        </div>
                      </div>
                      <div class="p-2 w-full flex justify-around mt-4">
                        <button type="button" onclick="location.href='{{ route('owner.products.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                        <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>                        
                      </div>
                    </div>
                  </form>
                  <form id="delete_{{$product->id}}" method="post" action="{{ route('owner.products.destroy', ['product' => $product->id ] )}}">
                    @csrf
                    @method('delete')
                    <div class="p-2 w-full flex justify-around mt-32">
                      <a href="#" data-id="{{ $product->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">削除する</a>                        
                    </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <script>
    'use strict'
    const images = document.querySelectorAll('.image')
    
    images.forEach( image =>  {
      image.addEventListener('click', function(e){
        const imageName = e.target.dataset.id.substr(0, 6)
        const imageId = e.target.dataset.id.replace(imageName + '_', '')
        const imageFile = e.target.dataset.file
        const imagePath = e.target.dataset.path
        const modal = e.target.dataset.modal
        document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
        document.getElementById(imageName + '_hidden').value = imageId
        MicroModal.close(modal);
    }, )
    })  

    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除してもいいですか?')) {
        document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
    </script>

</x-app-layout>
