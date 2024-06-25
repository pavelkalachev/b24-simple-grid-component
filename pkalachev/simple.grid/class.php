<?php

class SimpleGridComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        $gridId = 'SIMPLE_GRID';

        $gridFilter = $this->getFilterFields();

        $this->includeComponentTemplate();
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
}
