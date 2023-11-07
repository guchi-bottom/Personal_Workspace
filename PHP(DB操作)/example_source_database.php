// Historyモデル
class History extends Model {
    public function messages() {
        return $this->belongsToMany(Message::class, 'messaging', 'history_id', 'message_id');
    }
}

// Messageモデル
class Message extends Model {
    public function contents() {
        return $this->hasMany(Content::class);
    }
}

// Contentモデル
class Content extends Model {
    // 何かContentモデルに関する設定があれば追加
}

/* 
以下前提 
Eloquentを使ったシステムを開発したい。

テーブル/リレーション仕様は以下とする。
1. テーブルは3つ、それぞれhistory, messaging, message, contentと命名する
2. historyテーブル用のクラスではbelongsToMany関数でmessageテーブルとのリレーションを定義している(messagingテーブルでhistoryテーブルとmessageテーブルのリレーションを保持している)
3. messageテーブル用のクラスではhasMeny関数でcontentテーブルとのリレーションを定義している

処理仕様は以下とする。
1. 引数としてmessageテーブルのPKが渡される。
2. messagingテーブルから引数のmessageテーブルのPKと紐づいているhistoryテーブルのキーをすべて取り出す
3. 2.で取り出したレコードから、紐づいているレコードをcontentテーブルから削除する
*/