# URL Shortener

Сервис сокращения URL-адресов, с кешированием redis и использующий [hashids](http://hashids.org/).

Запуск окружения:
```bash
./build/run-build
```

Схема:
http://localhost:8080/schema/

gate для редиректа:
    
     GET  http://localhost:8080/{shortUrl}
