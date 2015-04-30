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
    // 'true', 'false' or 'Incident, Problem, Contact, etc' and any other CI which contains 'org_id' attribute
    'enabled' => 'Incident, UserRequest',
),
```
#### Возможные варианты *enabled*

 - `'enabled' => 'Incident, UserRequest, Person'` - поля `org_id` и `caller_id` (если имеется) заполняются в перечисленных классах.
 - `'enabled' => true` - модуль включён для всех классов.
 - `'enabled' => false` - модуль выключен.

### Ссылки
- [iTop ITSM & CMDB по-русски](http://community.itop-itsm.ru)
- [Сайт Combodo iTop](http://www.combodo.com/itop)
