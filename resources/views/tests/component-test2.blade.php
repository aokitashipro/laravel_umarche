<x-tests.app>
  <x-slot name="header">ヘッダー2</x-slot>

  コンポーネントテスト2
  <x-test-class-base classBaseMessage="メッセージです" />
  <div class="mb-4"></div>
  <x-test-class-base classBaseMessage="メッセージです" defaultMessage="初期値から変更しています" />

</x-tests.app>