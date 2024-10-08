## Upgrade

Задача переработана под уточнённые условия! Поиск по оборудованию и типам оборудования теперь состоит из двух выборных опций и общего поиска (по "q"), валидируется в кастомных форм реквестах. Есть возможность загружать оборудование списком, таким образом, что правильно заполненное оборудование всегда попадает в базу данных, а неправильно заполненное возвращается обратно для перезаполнения. Обновил скриншоты в 1-TestTask и экспорт базы данных.

## Как запустить

Всё очень просто! Проект запускается с помощью 'Sail' (Docker), 'docker-compose.yml' содержит всё необходимое. В корне проекта есть папка '1-TestTask', там лежат: <b>экспорт базы данных</b>, <b>пдф с условиями задачи</b>, '.env.original' (для удобства). Ещё там есть папка 'screenshots' c изображениями и краткими описаниями на них.

В целом структура проекта такая же, как и в любом типовом приложении Laravel, стоит отметить только, что компоненты Vue находятся в 'resources/js/components', а 'App.vue' в 'resources/js'. Запускайте с помощью 'sail npm run build' или 'sail npm run dev'.

## Система учёта оборудования

### Описание

Данный проект представляет собой систему для учёта оборудования с возможностью управления оборудованием и типами оборудования через веб-интерфейс. Основной функционал включает:

1. Добавление, редактирование и удаление оборудования — пользователи могут добавлять новое оборудование, редактировать существующее, удалять его, а также искать оборудование по серийному номеру или описанию.
2. Генерация серийных номеров — система автоматически генерирует серийные номера, соответствующие маске выбранного типа оборудования.
3. Список типов оборудования — пользователи могут просматривать список доступных типов оборудования с возможностью поиска по названию.
4. Пагинация — в списках оборудования и типов оборудования реализована пагинация для удобной навигации по большому количеству записей.
5. Индикация загрузки и сообщения об успехе/ошибках — пользователи получают обратную связь в виде индикаторов загрузки, сообщений об успехе или ошибках при выполнении действий.

### Что было сделано

Начнём с того, что тестовое задание было выполнено в полном объёме и даже с бонусами.

1. Созданы компоненты Vue для управления оборудованием и типами оборудования.
2. Реализованы формы для добавления и редактирования оборудования с валидацией в том числе на клиентской стороне.
3. Добавлены индикаторы загрузки и сообщения об успехе для улучшения пользовательского опыта.
4. Добавлена пагинация для списков оборудования и типов оборудования, что позволяет пользователям удобно просматривать большие объемы данных.
5. Настроен backend с использованием Laravel для обработки запросов, валидации данных и управления данными в базе данных.

### Результат

В результате мы получили удобный интерфейс для управления оборудованием и типами оборудования с расширенными возможностями поиска, фильтрации и валидации. Пользователи могут легко добавлять, редактировать и удалять записи, а также получать обратную связь в реальном времени о выполнении их действий. Пагинация и индикаторы загрузки делают работу с приложением более удобной и интуитивно понятной.