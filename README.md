# マイクロブログ

## URL

## 画面遷移

- プロフィール詳細
    - 共通ヘッダーのプルダウン
    - 他のユーザの詳細画面は「/users/{id}」を入力

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
    - 自分とフォローユーザの投稿を閲覧
    - 自分の投稿内容の編集・削除
    - フォロー表示（ランダム・３人）
    - フォロー
    - 本文内容の検索

## やったこと
- php  7.4.33 ⇒ 8.1.14にバージョンアップ
- Laravel 6.20.44 ⇒ 10.4.1にバージョンアップ
- Laravel Breezeで認証機能実装

## 今後の実装予定
- プロフィール画像を追加
- フォロー、フォロワー一覧画面作成

### リファクタリング
- 投稿表示の共通化
    - posts>index.blade.phpとusers>show.blade.php
