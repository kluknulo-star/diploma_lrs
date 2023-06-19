# LRS
LRS - система хранения записей обучения. Пользователь "Админ LMS" имеет учетную запись, которая позволяет создавать токены для взаимодействия между LMS и LRS. Так же добавлена возможность просмотра единиц статистики 

## Установка и настройка

```composer install```

```cp .env.example .env```

```php artisan key:generate```

```php artisan migrate --seed```

## Станица для поиска и фильтрации предложения
![image](https://github.com/kluknulo-star/diploma_lrs/assets/81085234/9ef49798-06fd-420c-a31f-03ddb2a13a3d)
