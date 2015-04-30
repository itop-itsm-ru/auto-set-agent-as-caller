auto-set-agent-as-caller
==============================
Этот маленький модуль для [Combodo iTop 2.1](http://combodo.com/itop) автоматически заполняет поля **Организация** и **Инициатор** данными агента, создающего тикет через внутренний интерфейс (не через клиентский портал).


### Установка
Устанавливаем, как и любой другой модуль в iTop:
 1. Перекладываем папку *auto-set-agent-as-caller* в *itop/extensions/*.
 2. Разрешаем редактирование config-файла iTop *itop/conf/production/config-itop.php*.
 3. Переходим в браузере http://my-itop/setup и выбираем "Upgrade an existing iTop instance".
 4. На предпоследнем шаге ставим галочку напротив названия модуля и устанавливаем.
 5. Готово.

### Настройка
После установки модуля в config-файле добавится один параметр, отвечающий за включение и выключение модуля.
```
'auto-set-agent-as-caller' => array (
    'enabled' => true,
),
```

### Ссылки
- [iTop ITSM & CMDB по-русски](http://community.itop-itsm.ru)
- [Сайт Combodo iTop](http://www.combodo.com/itop)
