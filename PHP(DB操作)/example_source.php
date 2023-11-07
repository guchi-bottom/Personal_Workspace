use App\Models\Message;
use App\Models\History;
use Illuminate\Support\Facades\DB;

// 引数としてmessageテーブルのPKを受け取る
$messagePK = 1; // 仮の値、実際の値に置き換えてください

// messagingテーブルから引数のmessageテーブルのPKと紐づいているhistoryテーブルのキーを取得
$historyIds = DB::table('messaging')
    ->where('message_id', $messagePK)
    ->pluck('history_id')
    ->all();

// 取得したhistoryテーブルのキーを使用して、contentテーブルから関連するレコードを削除
foreach ($historyIds as $historyId) {
    $history = History::find($historyId);
    $messages = $history->messages;
    
    foreach ($messages as $message) {
        $contents = $message->contents;
        foreach ($contents as $content) {
            $content->delete();
        }
    }
}

// historyテーブルのレコードを削除
History::whereIn('id', $historyIds)->delete();

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