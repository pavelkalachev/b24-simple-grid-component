<?php

class SimpleGridComponent extends CBitrixComponent
{
    const GRID_ID = 'SIMPLE_GRID';

    protected $gridOptions;

    public function executeComponent()
    {
        $gridRows = [];

        $gridFilter = $this->getFilterFields();
        $entityRepository = $this->getEntityRepository();

        $items = $entityRepository::getList([
            'select' => ['*'],
            'order' => $this->getEntitySort(),
            'filter' => $this->getEntityFilter($gridFilter),
        ]);

        while ($item = $items->fetchObject()) {
            $gridRows[] = [
                'id' => $item->getId(),
                'columns' => [
                    'ID' => $item->getId(),
                    'TITLE' => $item->getTitle(),
                    'CREATED_DATE' => $item->getCreatedDate()
                ],
                'actions' => [
                    [
                        'text' => 'Открыть задачу',
                        'onclick' => "BX.SidePanel.Instance.open('/company/personal/user/1/tasks/task/view/{$item->getId()}/')",
                        'default' => true
                    ],
                    [
                        'text' => 'Удалить',
                        'onclick' => "confirm('Удалить задачу \"{$item->getTitle()}\"?')",
                    ]
                ]
            ];
        }

        $this->arResult['GRID_ID'] = self::GRID_ID;
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
                'sort' => 'ID',
                'default' => true
            ],
            [
                'id' => 'TITLE',
                'name' => 'Заголовок',
                'sort' => 'TITLE',
                'default' => true
            ],
            [
                'id' => 'CREATED_DATE',
                'name' => 'Дата создания',
                'sort' => 'CREATED_DATE',
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

    protected function getEntitySort()
    {
        $gridOptions = $this->getGridOptions(self::GRID_ID);

        $sort = $gridOptions->getSorting([
            'sort' => [
                'ID' => 'DESC'
            ],
            'vars' => [
                'by' => 'by',
                'order' => 'order'
            ]
        ]);

        return $sort['sort'];
    }

    protected function getGridOptions()
    {
        if (is_object($this->gridOptions)) {
            return $this->gridOptions;
        }

        $this->gridOptions = new Bitrix\Main\Grid\Options(self::GRID_ID);

        return $this->gridOptions;
    }
}
