# Бибилотека для абстрактоного сервиса http://example
# У этого сервиса есть 3 метода:
## GET http://example.com/comments - возвращает список комментариев 
## POST http://example.com/comment - добавить комментарий
## PUT http://example.com/comment/{id} - по идентификатору комментария обновляет поля, которые были в в запросе


```php

<?php

$client = new \Vypsen\CommentsLib\Classes\CommentClient();

//получение всех комментариев
var_dimp($client->getComments());

// добавить комментарий
$name = 'User';
$text = 'comment';

$client->setComments($name, $text);

//обновить существующий комментарий 
$id = 1
$name = 'User';
$text = 'comment';

$client->setComments($id, $name, $text);


\```