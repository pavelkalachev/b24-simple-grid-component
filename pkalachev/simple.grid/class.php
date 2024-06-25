<?php

class SimpleGridComponent extends CBitrixComponent
{
    const GRID_ID = 'SIMPLE_GRID';

    public function executeComponent()
    {
        $gridId = self::GRID_ID;
        $gridRows = [];

        $gridFilter = $this->getFilterFields();
        $entityRepository = $this->getEntityRepository();

        $items = $entityRepository::getList([
            'select' => ['*'],
            'filter' => $this->getEntityFilter($gridFilter),
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
                'type' => 'string',
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

    protected function getEntityFilter($fields)
    {
        $filterOption = new \Bitrix\Main\UI\Filter\Options(self::GRID_ID);
        $filterFields = $filterOption->getFilter($fields);

        $logicFilter = \Bitrix\Main\UI\Filter\Type::getLogicFilter($filterFields, $fields);

        if (!empty($filterFields['FIND'])) {
            $findFilter = [
                'LOGIC' => 'OR', [
                    '%TITLE' => $filterFields['FIND']
                ]
            ];

            if (!empty($logicFilter)) {
                $logicFilter[] = $findFilter;
            } else {
                $logicFilter = $findFilter;
            }
        }

        return $logicFilter;
    }
}
