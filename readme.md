панели - табы

1 - список видео
2 - список коллекций
3 - список курсов
4 - настройки

окна
1 - добавление/обновление видео (относительно просто)
2 - добавление/обновление коллекции (просто)
3 - добавление/обновление курса (просто)
4 - добавление видео к курсу (сложнее) - grid + окно с выбором элемента
5 - добавление коллекций в курсу (сложнее) - grid + окно с выбором элемента

списки
1 - список сложностей (статический)
2 - список коллекций для видео (динамический)
3 - список видео для курса
4 - список коллекций для курса (можно объединить со списком для видео, но могут быть различия в фильтрации)

-----------------

- удаление / скрытие - скрытие как мягкое удаление (удаление запускает триггер на очистку видео от парента)
- добавление / редактирование (нужно окно)
- обновление из таблицы (сортировка перетаскиванием) ?

--------------------

collection - отдельная коллекция с видео
- id | идентификатор
- title | название и заголовок (короткий)
- alias | ссылка для браузера на латиннице
- description | описание и анонс коллекции
- rank | порядок вывода
- publishedon | дата публикации

course - отдельный курс (+сложность)
- id | идентификатор
- alias | ссылка для браузера на латиннице
- title | название и заголовок курса
- description | описание и анонс коллекции
- complexity | сложность курса (юнлинг, падаван, рыцарь, мастер)

course_collection - списки коллекций в курсе
- course_id [FK] | идентификатор курса
- collection_id [FK] | идентификатор коллекции
- rank | порядок сортировки коллекций
* - сборный уникальный индекс на пару курс + коллекция

course_video - списки индивидуальных видео в курсе
- course_id [FK] | идентификатор курса
- video_id [FK] | идентификатор видео
- rank | порядок сортировки коллекций (пока вроде не используется, но на будущее)
* - сборный уникальный индекс на пару курс + видео
** - сортировка видео по дате публикации

video - модель для отдельного видео
- id | идентификатор
- alias | ссылка для браузера на латиннице
- title | название и заголовок видео
- description | краткое описание видео-урока текстом
- duration | продолжительность в секундах (автоматически)
- cover | обложка видео (автоматическая или ручная генерация)
- source | ссылка на файл с видео, который будет передан в плеер
- publishedon | дата публикации
- hidden | скрытый
- free | бесплатный
- collection [FK] | принадлежность коллекции, может быть 0|null (одиночное видео)


коллекция может быть пустая, но она как категория (без вложенностей)
курс будет наборный, задается список коллекций и видео
коллекции могут выставляться в нужном порядке, одиночные видео просто в порядке публикации (выбор из доступных с пустой коллекцией)

что делать, если видео было без коллекции, но перемещено в коллекцию. по уму нужно обновить курс и убрать из одиночек, так как есть в коллекции

----------------------------

Задачи:

- решить проблему с версией в сборщике, так как версия выше последней не обнуляет цифру ниже
- нужно перенести плагин, отвечающий за поиск видео и коллекций по урлу
- добавить точки входа (ресурсы) в системные настройки для видео/коллекций/курсов 
- доделать в списке с видео вывод 3 панели с деталями и статистикой
- добавить валидацию в модели
- вынести креденшелы к вимео в системные настройки пакета
- добавить указание креденшелов при установке пакета
