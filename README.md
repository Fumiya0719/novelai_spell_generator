# novelai_spell_generator

## 概要

AIイラスト生成サービスの[**NovelAI**](https://novelai.net/image)において、イラスト生成をする際列挙するコマンドの作成を支援するWebアプリケーションです。

ここでは本ツールの機能・使用技術・今後の展望などを、この説明を書いている人(以下私)の感想を交えて紹介しています。

尚、本解説は全て私の解釈で記述しているので、多分色々間違っています。~~考えていることを口や文章にするのが壊滅的に苦手な人間なのでお許しください~~

### はじめに

本ツールを使用する前に、************************************************************************************************利用規約とプライバシーポリシーの一読をお願いします。************************************************************************************************

アカウント登録、または本ツールの使用をした時点で、利用規約・プライバシーポリシーに同意したとみなします。

また、NovelAIで利用されるものや本ツール独自の用語などを事前に説明します。

**NovelAI関連**

- プロンプト
    - NovelAIにおいて、イラスト生成時に列挙するコマンドの1つ1つを指します。
    - 各コマンド、または列挙したものをまとめて「**呪文**」とも呼ばれます。
    - 本解説では「**プロンプト**」という名前で統一します。

- BANプロンプト
    - NovelAIにおいて、イラスト生成時に不要な要素を排除する際に列挙するプロンプトです。
    - 上記プロンプトとは違う入力欄が設けられており、そこに不要なプロンプトを列挙します。
    - 例えば「木を画像に入れたくない」という場合は、treeと記入することで木は生成されにくくなります。
    - 必要な要素を列挙する「呪文」とは対象に「**反呪文**」とも呼ばれます。

- シード値
    - NovelAIでは全く同じプロンプト、BANプロンプトを記述しても生成する度に出力される画像が変化します。
    - それぞれの画像は「**シード値**」で管理されており、これがランダムに変化する為に毎回出力される画像が変化する訳です。
    - シード値を入力する欄があるので、そこに数値を入れることで固定され、同じ(100%ではない)画像が出力されます。

- 強化値
    - プロンプトを括弧でくくる事によって、そのプロンプトの主張を強く(弱く)することができます。
    - 波括弧 {} で強化、角括弧 [] で弱化します。この数が多いほど強化・弱化の効力は強くなります。
    - 例えば {wind} と記入すれば風が強くなるし、[long hair]と記入すれば長髪より若干短めになります。

**本ツール関連**

- プリセット
    - 本ツールにおいて、生成した画像に関わるデータを保存する際のデータをまとめて「**プリセット**」と呼んでいます。
    - 現在プリセットとして登録できるのは、「生成画像」「プロンプト」「BANプロンプト」「シード値」「画像の説明」「年齢制限」「解像度」「備考」の8種です。
    - このプリセットデータは、本ツールの機能で登録、読取、更新、削除(いわゆる**CRUD**)を自由に行うことができます。

- ジェネレーター
    - 本ツールにおいて、**プロンプトの作成を支援する**サービスを指します。
    - URLは(**[https://nai-pg.com/](https://nai-pg.com/#/)**)で、トップページに該当します。
    - 画像を除くプリセットデータをこのページから**********登録のみ**********することが可能です。

- セーバー
    - 本ツールにおいて、**プリセットのCRUD処理を行う**サービスを指します。
    - URLは([**https://nai-pg.com/#/saves**](https://nai-pg.com/#/saves))で、プリセット登録・更新ページが別であります。
    - プリセット登録・更新ページでは、**********************生成画像の登録**********************が可能です。

## 機能

### ジェネレーター

- プロンプトの作成支援
    - 約500の項目から、**マウス操作のみ**で必要なプロンプトの選択、強化値の設定、プロンプトの生成・コピーが可能です。
    - 項目にない**プロンプトの手動追加**や、プロンプト生成後の**修正**もできます。
    - 一部のプロンプト(衣装やアクセサリーなど)は、カラーバリエーションの選択が可能です。

- 作成したプロンプトのアップロード
    - 「プロンプトをアップロード」欄から、**既に生成したプロンプトを読み込む**ことができます。
    - 強化値も保持され、項目にないプロンプトは手動追加したとみなされます。
    - アップロード実行時、そ**れまでに設定していたデータはリセットされる**ので注意してください。

- 作成したプロンプトのデータベース保存
    - **ログイン時**、画面右下の「保存」ボタンからプロンプトをプリセットとして登録ができます。
    - 非ログイン時はボタンが存在しないので、後述のセーバーから**アカウント登録・ログインを事前に行って下さい**。
    - 生成したプロンプトが入力欄に自動で登録されるので、その他のデータを埋めて登録してください。(しなくても保存は可能です。)

- 年齢制限の切り替え
    - 画面上部中央「全年齢」ボタンを押すと、「全年齢」「R-15」「R-18」の順に**トグル切り替え**が可能です。
    - 切り替えた内容に合わせたプロンプトが表示されます。**「全年齢」は青色**、**「R-15」は緑色**、**「R-18」は赤色**になっています。
    - 「R-15」では「全年齢」のプロンプトが、「R-18」では全てのプロンプトが表示されます。
    - プロンプトアップロード時、各プロンプト内に1つでも「R-15」「R-18」の項目があればプロンプト一覧もその内容に自動更新されます。
    - 用途に応じた使い分けをしてください。尚、**「R-18」では過度な性的表現を含むプロンプトも含まれます**ので、**閲覧にはご注意ください**。

- その他
    - 強化値である波括弧 {} を丸括弧 () に変換する機能があります。
    - 一部AIイラスト生成ツールでは波括弧の代わりに丸括弧を使うケースがあるので、その際にご使用ください。
    

### セーバー

- アカウント登録機能
    - セーバーを利用する際は、**********************************アカウント登録が必須**********************************となっています。メールアドレス、ユーザーID、パスワードを入力してください。
    - メールはこちらから送ることは無いですが、質問等あった際の返信に利用させていただきます。
    - アカウント登録後はログイン画面に自動遷移されます。

- プリセット一覧検索・表示機能
    - [**https://nai-pg.com/#/saves**](https://nai-pg.com/#/saves)で利用できる機能です。
    - ログインユーザーが登録したプリセット一覧が表示されます。リストから1つ項目を選択すると、画面右に選択したプリセットの詳細が出現します。
    - プリセットの詳細からプロンプト・BANプロンプト・シード値のコピーが可能です。また、「編集」ボタンを押すとそのプリセットの編集ページに遷移します。
    - 画面上部から検索フォームを開くことができます。フォーム内容を変更すると自動でその内容に該当するデータのみが抽出され、一覧表示されます。

- プリセット登録・更新・削除機能
    - [**https://nai-pg.com/register/commands.php**](https://nai-pg.com/register/commands.php)で利用できる機能です。
    - **************************************画像を含む**************************************プリセットの登録や既存プリセットの更新・削除が可能です。
    - 画像は画面右からドラッグ&ドロップで投稿可能です。(画面左の「ファイルを選択」から直接投稿もできます。)
    - 既存データを編集する場合、フォーム右上の「削除」ボタンから、アラートを一度介してプリセットの削除が可能です。

## 更新履歴

詳細な履歴は後日本ツールの別ページで公開予定です。

- 2022/10/08
    - 開発開始。ジェネレーターのプロンプト生成機能を作成し、デモ環境に仮公開。

- 2022/10/12
    - セーバー機能の作成(当時はジェネレーターとセーバーでプロジェクトが別々だった)

- 2022/10/25
    - UIの大幅刷新、管理画面の追加等を行いアプリ本公開、プロジェクトを統一。

- ~ 2022/11/17
    - 年齢制限の細分化、UIの刷新、プリセットの画像アップロード機能等各種細かい機能の追加。

## 使用技術

(ここから私の所感が増えます)

- **Vue.js**
    - 開発開始1カ月前(2022/09初頭)のインターンで初めて使用した。
    - インターンで学んだ内容を活かしたいと思いつつ何も浮かばないと思っていたところにNovelAIの登場。非常にタイミングが良い。
    - Refの汎用性の高さやwatchEffectでの監視の分かりやすさ等、Reactと比べるととっつきやすい印象
    - 今回はVue3を使用。~~インターンでも3だったのでそれ以外知らない。~~
    - 今までPHPだけで事足りると思っていたが、モダンフロントエンド技術を習得してできる幅が広がりすぎてビビってる

- ******PHP******
    - 初めてまともに勉強したプログラミング言語。
    - アルバイトの時含め約1年半使っているが正直Class、Namespaceの概念はほぼ知らん (使う必要性が薄くてあまり手着けてない)
    - Laravelの導入も考えたが、RoutingやControllerの設定がダル過ぎたので断念。しかし思った以上にアプリの規模が大きくなってきたのでどうするか迷ってる
    - とりあえず生PHPをAPI利用して基本操作はVueに少しずつ移行していく形を取ろうと思う。

- TypeScript
    - 上記インターン直前、Reactの勉強を少しした時から使い始めた。
    - そもそもJavaScript自体ロクに触ってなかったので、分割代入だの参照渡しだのmapだの見たことない記法が多すぎてかなり大変だった
    - インターンを経て一応何となくで使えるようにはなっているが、型指定とかで中々苦労することが多い

- Sass
    - ~~とりあえずノリで使ってる奴~~
    - 何も知らな過ぎて入れ子にしてちょっとコード削減してるくらい
    - もうすぐレスポンシブ対応する予定なのでその時頑張る(投げやり)

## 今後の更新予定

- 画面のレスポンシブ対応
    - 現在アプリ全体がPC、それも横1560px以上の画面でないと見た目が大崩れする
    - スマホ(でNovelAIを使う人はおらんと思うが)でも使えるように整備する予定。ただ流石に機能性は落ちる

- プリセット登録の単純化
    - 現在セーバーはプリセット一覧ページと登録・編集ページで分かれているが、一覧ページで全部できるようにしたい。
    - 具体的にはプリセット一覧から1つ選択すると出る画面右の詳細の枠を利用して追加・編集をするような感じ
    - 現在画像のVue→PHP(API)送信が全くうまくいってないのでそこがネック。頑張りたい。

- 述式登録機能
    - 「この呪文を唱えるとこれが生成される」という奴の呪文を列挙している奴が述式(語彙力)。
    - これをユーザーごと登録してジェネレーターのプロンプト一覧に表示できないか考え中
    - つまりユーザー定義のプロンプトをジェネレーターのプロンプト一覧に置きたいという事。

- 差分登録機能
    - あるプリセットに対して、その画像の差分(のようなもの)をツリー形式で登録できる機能
    - NovelAIをずっと使っていると段々プリセット数が増えて検索がだるいのでそれの解消目的もある
    - ぶっちゃけ機能のメリットに対して開発コストが高すぎる気がしなくも無い(が別に個人で勝手にやってることなのでやる気になったらやると思われる)

- リファクタリング
    - **リファクタリング**
    - リファクタリング
    - `**リファクタリング**`
    - 絶対ここもっとコードと処理減らせるだろって所が無限にある。~~誰かリファクタリングの匠呼んでくれ~~

(2022/11/18) 

今の所モチベがこれの開発(とブルアカと音ゲー)にしかないので更新頻度は高いと思います。~~マリー可愛い~~

何かこんな機能があったら良いという要望があればemail → tosufumiya0719Ogmail.com (Oを@に変換)まで

本ツールの解説(と深夜テンションで作った駄文)は以上です。本ツールを通して皆さんがより良いNovelAIライフを送れたら幸いです。
