# sql-upload-users

Загружает пользователей из БД в Карты офиса

## Настройка

### БД

В config/DBConfig указать настройки подключения к бд и sql запрос для загрузки пользователей.
Для теста запроса есть скрипт test-sql.php

### Карты офиса

В config/mapping.php нужно установить соответствие загружаемых полей полям карт офиса.
Для того, чтобы узнать поля карт офиса есть скрипт get-user.php

В config/SaveLeaderMapUserConfig.php можно указать, чтобы скрипт только загружал или только обновлял пользователей.
Также нужно указать дефолтные поля для нового пользователя
