# Udemy Laravel講座「マルチログイン機能を構築し本格的なECサイトをつくってみよう【Breeze/tailwindcss】」のバグ修正の場所です

https://www.udemy.com/share/104J4k3@IMep40V66vX5HuXpdptkO5bpqHw07p5Cldci2D_3-B52HmHzrBrfjCs-4FmHZeBx/

この講座でLaravelの開発ができるようになったので、お礼も兼ねてバグフィックスなどのフォローします！
本サイトはあくまで講座で使われているGithubサイトからフォークしたものです。
フォロー専用ブランチ名には全てbugfix_という接頭辞を付けています。

## フォロー内容

- bugfix_cookie: 同じブラウザで同時にユーザー、オーナー、アドミンの画面をそれぞれ開いてログインし、各画面を切り替えて動作を確認すると、そのままではブラウザ内のセッション情報を共有してしまいます。これは、セキュリティホールになりますので必ず対処が必要です。このブランチは現在masterにもマージしています。
- bugfix_micromodal: コース98で講師のアオキさんが商品画像のアップロードの不具合について説明してくれています。なんとか修正したいのですが、私にも根本的な解決ができません。Micromodal.jsはdata-micromodal-triggerで指定した最後のボタンに紐づく$modalを勝手に書き換えてしまうように見えます。とりあえず、5番目の「ファイルを選択」ボタンを見えなくしておき、select-image.blade.phpで最後のボタンの$modalを書き換えないようにしました。5番目のボタンが存在すれば、4番目のボタンは正しく動作することを逆手に取った形です。
- bugfix_optional: resources/views/user/show.blade.phpで商品画像2から4が登録されていなかったとき、Trying to get property of non-objectのようなエラーが出ます。これは、if条件分の中に$product->imageSecond->filename !== nullがあるため、評価時点でデータが取れないことを指摘されています。そこで、2番目以降の画像についてoptional関数を付けることで、対処します。
------------

## ダウンロード方法

git clone

git clone https://github.com/aokitashipro/laravel_umarche.git

git clone ブランチを指定してダウンロードする場合

git clone -b ブランチ名 https://github.com/aokitashipro/laravel_umarche.git

もしくはzipファイルでダウンロードしてください

## インストール方法

- cd laravel_umarche
- composer install
- npm install
- npm run dev

.env.example をコピーして .env ファイルを作成

.envファイルの中の下記をご利用の環境に合わせて変更してください。

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=laravel_umarche
- DB_USERNAME=umarche
- DB_PASSWORD=password123

XAMPP/MAMPまたは他の開発環境でDBを起動した後に

php artisan migrate:fresh --seed

と実行してください。(データベーステーブルとダミーデータが追加されればOK)

最後に
php artisan key:generate
と入力してキーを生成後、

php artisan serve
で簡易サーバーを立ち上げ、表示確認してください。


## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg 〜 sample6.jpg として
保存しています。

php artisan storage:link で
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
(productsフォルダがない場合は作成してください。)

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。

## section7の補足

決済のテストとしてstripeを利用しています。
必要な場合は .env にstripeの情報を追記してください。
(講座内で解説しています)

## section8の補足

メールのテストとしてmailtrapを利用しています。
必要な場合は .env にmailtrapの情報を追記してください。
(講座内で解説しています)

メール処理には時間がかかるので、
キューを使用しています。

必要な場合は php artisan queue:workで
ワーカーを立ち上げて動作確認するようにしてください。
(講座内で解説しています)

