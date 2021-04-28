<h2>Сборка</h2>

Проект собран на официальном шаблоне Yii 2 Advanced Project Template с образом Docker.

Официальная сборка претерпела минимальные изменения - добавился phpmyadmin, имена контейнеров и файл .env.

<h2>Развертывание проекта</h2>

Скачать репозиторий

`git clone https://github.com/templton/yii2-test-apple.git`

Перейти в катлог с репозиторием:

`cd yii2-test-apple`

Сбилдить проект:

`docker-compose up -d --build`

Установить зависимости composer:

`docker exec -it apple_backend composer install`

Инициализация окружения:

`docker exec -it apple_backend php ./init`

Which environment do you want the application to be initialized in? - Выбрать [0] Development

Initialize the application under 'Development' environment? - Выбрать yes

Настроить подключение к базе данных. Открываем файл `common/config/main-local.php` и задаем настройки компонента db:

`
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host='.env('MYSQL_HOST').';dbname='.env('MYSQL_DB_NAME'),
            'username' => env('MYSQL_USER'),
            'password' => env('MYSQL_PASSWORD'),
            'charset' => 'utf8',
        ],
`

Перезапустить контейнер:

`docker-compose down`

`docker-compose up -d --build`

Запустить миграции:

`docker exec -it apple_backend php yii migrate`

Примечание: если контейнер уже сбилдился ранее, то после запуска `docker-compose up -d`, чтобы применить миграции, нужно подождать несколько 
секунд, чтобы контейнер с mysql успел развернуться. 

<h2>Страницы проекта</h2>

Доступ в админ часть предоставляется только авторизованным пользователям. Поэтому сначала зарегистрируйтесь на сайте.
Для этого зайдите главную страницу - <a href="http://localhost:20080"> http://localhost:20080 </a> и в верхнем меню 
выберите Signup. Учетная запись активирована сразу, система не будет требовать подтверждения по email. 

Главная страница с заданием <a href="http://localhost:21080/index.php?r=tree">Главная</a>

<h2>Настройки CRON</h2>

Для перевода яблок в статус "Испорчено" можно использовать фоновую консольную задачу.

Запуск фонового процесса реализован с помощью Yii расширения - yii2-scheduling

Чтобы запустить автоматический фоновой процесс необходимо в контейнер добавить запись cron:

`* * * * * docker exec -t --user www-data apple_backend /bin/bash -c "/usr/local/bin/php /var/www/app/yii schedule/run --scheduleFile=/app/console/config/sheduleConfig.php 2>&1"`

В текущей реализации команда cron в контейнер не подключена. Для запуска проверки испорченных яблок необходимо запустить
обработчик scheduler вручную с помощью консольной команды:

`docker exec -it apple_backend php yii schedule/run --scheduleFile=/app/console/config/sheduleConfig.php`

Или непосредственно запустить саму консольную команду:

`docker exec -it apple_backend php yii apple/mark-rotten-apples`

<h2>Задание</h2>

Установить advanced шаблон Yii2 фреймворка, в backend-приложении реализовать следующий закрытый функционал (доступ в backend-приложение должен производиться только по паролю, сложного разделения прав не требуется):

Написать класс/объект Apple с хранением яблок в БД MySql следуя ООП парадигме.

Функции
- упасть
- съесть ($percent - процент откушенной части)
- удалить (когда полностью съедено)

Переменные
- цвет (устанавливается при создании объекта случайным)
- дата появления (устанавливается при создании объекта случайным unixTmeStamp)
- дата падения (устанавливается при падении объекта с дерева)
- статус (на дереве / упало)
- сколько съели (%)
- другие необходимые переменные, для определения состояния.

Состояния
- висит на дереве
- упало/лежит на земле
- гнилое яблоко

Условия
Пока висит на дереве - испортиться не может.
Когда висит на дереве - съесть не получится.
После лежания 5 часов - портится.
Когда испорчено - съесть не получится.
Когда съедено - удаляется из массива яблок.

Пример результирующего скрипта:
$apple = new Apple('green');

echo $apple->color; // green

$apple->eat(50); // Бросить исключение - Съесть нельзя, яблоко на дереве
echo $apple->size; // 1 - decimal

$apple->fallToGround(); // упасть на землю
$apple->eat(25); // откусить четверть яблока
echo $apple->size; // 0,75

На странице в приложении должны быть отображены все яблоки, которые на этой же странице можно сгенерировать в случайном кол-ве соответствующей кнопкой.
Рядом с каждым яблоком должны быть реализованы кнопки или формы соответствующие функциям (упасть, съесть  процент…) в задании.
Задача не имеет каких-либо ограничений и требований. Все подходы к ее решению определяют способность выбора правильного алгоритма при проектировании системы и умение предусмотреть любые возможности развития алгоритма. Задание должно быть выложено в репозиторий на gitHub, с сохранением истории коммитов. Креативность только приветствуется.
