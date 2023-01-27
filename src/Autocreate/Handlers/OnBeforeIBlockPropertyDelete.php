<?php

namespace Arrilot\BitrixMigrations\Autocreate\Handlers;

use CIBlockProperty;
use CIBlock;

class OnBeforeIBlockPropertyDelete extends BaseHandler implements HandlerInterface
{
    /**
     * Constructor.
     *
     * @param array $params
     */
    public function __construct($params)
    {
        $this->fields = CIBlockProperty::getByID($params[0])->fetch();
        $this->fields['IBLOCK_CODE'] = CIBlock::GetByID($this->fields['IBLOCK_ID'])->fetch()['CODE'];
    }

    /**
     * Get migration name.
     *
     * @return string
     */
    public function getName()
    {
        return "auto_delete_iblock_element_property_{$this->fields['CODE']}_in_ib_{$this->fields['IBLOCK_ID']}";
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'auto_delete_iblock_element_property';
    }

    /**
     * Get array of placeholders to replace.
     *
     * @return array
     */
    public function getReplace()
    {
        return [
            'iblockId' => $this->fields['IBLOCK_ID'],
            'iblockCode' => "'".$this->fields['IBLOCK_CODE']."'",
            'code'     => "'".$this->fields['CODE']."'",
        ];
    }
}
