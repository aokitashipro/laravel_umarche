<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ホーム
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <div class="flex flex-wrap">
                    
                     @foreach($products as $product)
                       <div class="w-1/4 p-2 md:p-4">
                       <a href="">  
                       <div class="border rounded-md p-2 md:p-4">
                         <x-thumbnail filename="{{$product->imageFirst->filename ?? ''}}" type="products" />
                            <div class="mt-4">
                                <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category->name }}</h3>
                                <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円(税込)</span></p>
                              </div>
                       </div>
                       </a>
                       </div>
                       @endforeach
                     
                     </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
