<?php

class SimpleGridComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        $gridId = 'SIMPLE_GRID';
        $gridRows = [];

        $gridFilter = $this->getFilterFields();
        $entityRepository = $this->getEntityRepository();

        $items = $entityRepository::getList([
            'select' => ['*']
        ]);

        while ($item = $items->fetchObject()) {
            $gridRows[] = [
                'id' => $item->getId(),
                'columns' => [
                    'ID' => $item->getId(),
                    'TITLE' => $item->getTitle(),
                    'CREATED_DATE' => $item->getCreatedDate()
                ]
            ];
        }

        $this->arResult['GRID_ID'] = $gridId;
        $this->arResult['GRID_FILTER'] = $gridFilter;
        $this->arResult['GRID_COLUMNS'] = $this->getGridColumns();
        $this->arResult['GRID_ROWS'] = $gridRows;

        $this->includeComponentTemplate();
    }

    protected function getEntityRepository()
    {
        return '\Bitrix\Tasks\Internals\TaskTable';
    }

    protected function getFilterFields(): array
    {
        return [
            [
                'id' => 'TITLE',
                'name' => 'Название',
                'type' => 'date',
                'default' => true
            ],
            [
                'id' => 'CREATED_DATE',
                'name' => 'Дата создания',
                'type' => 'date',
                'default' => true
            ]
        ];
    }

    protected function getGridColumns()
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID задачи',
                'default' => true
            ],
            [
                'id' => 'TITLE',
                'name' => 'Заголовок',
                'default' => true
            ],
            [
                'id' => 'CREATED_DATE',
                'name' => 'Дата создания',
                'default' => true
            ],
        ];
    }
}
