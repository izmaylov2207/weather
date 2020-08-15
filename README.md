## Deploy 

1. Установить Docker и Docker-compose, если у вас они не установлены.

2. Запустить команду для клонирования репозитория:

    `git clone https://github.com/izmaylov2207/weather.git`
    
3. Настроить .env используя .env.example (скопировать). По-умолчанию должно все работать, возможно придется прописать другой порт для Nginx, если вдруг у вас занят.
    
4. Запустить команду для установки Docker окружения:

    `docker-compose up --build -d`
    
5. Выполнить команду для установки зависимостей:

    `docker-compose exec php composer install`

6. Проверить работоспособность перейдя в браузере http://localhost:8005/xml или http://localhost:8005/json (порты указаны по-умолчанию)