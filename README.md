# Session

```console
composer require jiny/session
```

# how to

파일기반의 세션처리
세션을 저장할 경로를 매개변수로 전달합니다.
```php
\jiny\session_start("./session");
```


데이터베이스 기반의 세션처리
데이터베이스 PDO 컨넥션 정보를 전달합니다.
```php
\jiny\session_start($db->conn());
```

일반 세션 처리
매개변수를 전달하지 않으면 PHP 기본 세션으로 처리 됩니다.