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
                エロクアント
                @foreach ($e_all as $e_owner)
                  {{ $e_owner->name }}
                  {{ $e_owner->created_at->diffForHumans() }}
                @endforeach
                <br>
                クエリビルダ
                @foreach ($q_get as $q_owner)
                  {{ $q_owner->name }}
                  {{ Carbon\Carbon::parse($q_owner->created_at)->diffForHumans() }}
                @endforeach
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
