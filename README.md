Компонент подготавливает данные и выводит в bitrix:main.ui.grid информацию о задачах.

Поддерживает:
- Фильтрацию
- Пагинацию
- Сортировку


Вызов компонента
```
<? $APPLICATION->includeComponent(
    "pkalachev:simple.grid",
    "",
    []
);
?>
```
