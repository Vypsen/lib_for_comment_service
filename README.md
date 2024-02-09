# Бибилотека для абстрактного сервиса http://example
# У этого сервиса есть 3 метода:
## GET http://example.com/comments - возвращает список комментариев 
## POST http://example.com/comment - добавить комментарий
## PUT http://example.com/comment/{id} - по идентификатору комментария обновляет поля, которые были в в запросе

```
composer require vypsen/comment-lib dev-master
```

```php

<?php

$client = new \Vypsen\CommentsLib\Classes\CommentClient();

//получение всех комментариев
$response = $client->getComments();

//методы из GuzzleHttp
$dataBody = json_decode($comments->getBody()->getContents(), true);
$statusCode = $comments->getStatusCode();


// добавить комментарий
$name = 'User';
$text = 'comment';

$client->setComments($name, $text);

//обновить существующий комментарий 
$id = 1
$name = 'User';
$text = 'comment';

$client->setComments($id, $name, $text);

````

``` 
./vendor/bin/phpunit ./vendor/vypsen/comment-lib/tests
```
