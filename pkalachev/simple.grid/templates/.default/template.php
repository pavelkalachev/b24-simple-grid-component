<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => $arResult['GRID_ID'],
    'COLUMNS' => $arResult['GRID_COLUMNS'],
    'ROWS' => $arResult['GRID_ROWS'],
    'AJAX_MODE' => 'Y',
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'AJAX_OPTION_JUMP' => 'N',
    'SHOW_ROW_CHECKBOXES' => true,
    'SHOW_CHECK_ALL_CHECKBOXES' => true,
    'SHOW_ROW_ACTIONS_MENU' => true,
    'SHOW_GRID_SETTINGS_MENU' => true,
    'SHOW_NAVIGATION_PANEL' => true,
    'SHOW_PAGINATION' => true,
    'SHOW_SELECTED_COUNTER' => false,
    'SHOW_TOTAL_COUNTER' => false,
    'SHOW_PAGESIZE' => true,
    'SHOW_ACTION_PANEL' => true,
    'ALLOW_COLUMNS_SORT' => true,
    'ALLOW_COLUMNS_RESIZE' => true,
    'ALLOW_HORIZONTAL_SCROLL' => true,
    'ALLOW_SORT' => true,
    'ALLOW_PIN_HEADER' => true,
    'AJAX_OPTION_HISTORY' => 'N',
    "ENABLE_COLLAPSIBLE_ROWS" => true
]); ?>