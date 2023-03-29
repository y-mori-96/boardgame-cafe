# マイクロブログ

## URL

## 実行方法
1. ビルドの実行
    - npm run build
2. 開発環境用サーバ起動
    - php artisan serve --port=$PORT
3. テスト用ログインユーザ
    - ユーザ名：テストユーザ１
    - メール：testuser1@test.com
    - パスワード：password


## 使用技術
- AWS
    - Cloud9
- PHP：8.1.14
- Laravel：10.4.1
- Laravel Breeze：v1.20.0
- mysql：15.1
- node.js：8.19.3
- tailwindcss：3.2.7 

## 機能一覧
- ユーザー登録、ログイン機能(Laravel Breeze)
- ブログ
  - ログインユーザ
    - 記事投稿
    - 自分の投稿記事のみ閲覧
    - 自分の投稿記事の編集・削除

## やったこと
- php  7.4.33 ⇒ 8.1.14にバージョンアップ
- Laravel 6.20.44 ⇒ 10.4.1にバージョンアップ
- Laravel Breezeで認証機能実装

## 今後の実装予定
- フォロー機能の追加
- 検索機能の追加