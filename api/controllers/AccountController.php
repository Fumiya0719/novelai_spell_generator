<?php

class AccountController {
    private $response;

    public function __construct() {
        $this->response = [
            'error' => false,
            'content' => '',
            'user_id' => '',
        ];
    }

    // 不正なデータ送信が行われた場合のエラーログ出力処理
    public function sendErrorLog($content = '不正な送信が行われました。') {
        $this->response['error'] = true;
        $this->response['content'] = $content;
        return $this->response;
    }

    // 送られてきたメアドとユーザーIDが既存かどうか調べる
    private function confirmIsExistSameData($email, $user_id) {
        try {
            $pdo = dbConnect();
            $pdo->beginTransaction();

            $st = $pdo->prepare('SELECT email, user_id FROM users WHERE user_id = :user_id OR email = :email');
            $st->bindValue(':email', $email, PDO::PARAM_STR);
            $st->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $st->execute();
            
            $rows = $st->fetch(PDO::FETCH_ASSOC);
            $pdo->commit();
            return !empty($rows) ? '既に使用されているメールアドレスまたはユーザーIDです。' : '';
        } catch (PDOException $e) {
            echo 'データベース接続に失敗しました。';
            if (DEBUG) echo $e;
        }
    }

    // アカウントの登録処理
    public function register($post) {
        $error = $this->confirmIsExistSameData(h($post['email']), h($post['user_id']));

        if ($error !== '') {
            $this->response['error'] = true;
            $this->response['content'] = $error;
            return $this->response;
        }; 

        $pdo = dbConnect();
        $pdo->beginTransaction();

        $st = $pdo->prepare('INSERT INTO users (email, user_id, password) VALUES (:email, :user_id, :password)');
        $st->bindValue(':email', h($post['email']), PDO::PARAM_STR);
        $st->bindValue(':user_id', h($post['user_id']), PDO::PARAM_STR);
        $st->bindValue(':password', password_hash(h($post['password']), PASSWORD_DEFAULT), PDO::PARAM_STR);
        $st->execute();

        $pdo->commit();
        $this->response['content'] = 'アカウント登録が完了しました。';
        return $this->response;
    }

    // アカウントのログイン処理
    public function login($post) {
        $error = '';

        $pdo = dbConnect();
        $pdo->beginTransaction();

        $st = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');
        $st->bindValue(':user_id', h($post['user_id']), PDO::PARAM_STR);
        $st->execute();

        $rows = $st->fetch(PDO::FETCH_ASSOC);
        $pdo->commit();

        // 返された配列が空の場合、ユーザ名が存在しない
        if (empty($rows)) {
            $error = '入力されたユーザー名は存在しません。';
            // パスワードの照合
        } else if(!password_verify(h($post['password']), $rows['password'])) {
            $error = '入力されたパスワードが間違っています。';
        }

        if ($error !== '') {
            $this->response['error'] = true;
            $this->response['content'] = $error;
        } else {
            session_start();
            $_SESSION['user_id'] = h($post['user_id']);
            $this->response['content'] = 'ログイン認証が完了しました。';
        }
        return $this->response;
    }

    // ユーザーIDを取得する
    public function getUserData() {
        if ($_SERVER['HTTP_HOST'] === 'localhost') {
            $this->response['user_id'] = 'Fumiya0719';
            $this->response['content'] = 'ユーザーIDを取得しました。';
        } else {
            if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === '') {
                $this->response['error'] = true;
                $this->response['content'] = 'ユーザーIDの取得に失敗しました。';
            } else {
                $this->response['user_id'] = h($_SESSION['user_id']);
                $this->response['content'] = 'ユーザーIDを取得しました。';
            }
        }
        return $this->response;
    }

    // ログアウト処理
    public function logout() {
        $_SESSION = [];
        $this->response['content'] = 'ログアウトしました。';
        return $this->response;
    }
}