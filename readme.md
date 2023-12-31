# Тестовое задание Калькулятор

Сделать калькулятор на текущих версиях PHP и Symfony.
Данные в калькулятор вводятся через форму с тремя обязательными полями: первый аргумент, операция и второй аргумент.
Калькулятор поддерживает сложение, вычитание, умножение и деление.
В случае успешного вычисления под формой выводятся выражение и результат вычисления.
Предусмотреть валидацию и обработку ошибок. 
Написать тесты.
Разместить код на github

Будут плюсом реализация доп. функционала: 
- не запускать вычисление сразу, а добавлять его в очередь;
- добавить кнопку для обработки заданий из очереди.

## Примечания для проверки
Проект написан с использованием фреймворка Symfony 6. Для успешного запуска необходима версия языка PHP 8.1 или выше.
В качестве базы данных используется SQLite 3, поэтому необходим соответствующий модуль PHP.

Перед запуском необходимо инициализировать базу данных следующими командами из каталога проекта:
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

Запуск тестирования:
Реализован один модуль тестирования, проверяющий запрос на вычисления.
Форма отправляет запрос на вычисление выражения 5 + 4 на сервер и ожидает увидеть результат в ответе  в блоке DIV "5 + 4 = 9"

```
php bin/phpunit
```

