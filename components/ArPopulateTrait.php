<?php

namespace app\components;

trait ArPopulateTrait
{
    /**
     * @param array|string $findData
     * @param array|string $skipFields
     * @param bool|true $useSelfData
     */
    public function populateBy($findData, $skipFields = [], $useSelfData = true) {
        if($useSelfData) {
            $findData = is_array($findData) ? $findData : [$findData];
            foreach ($findData as $k => $fieldName) {
                $findData[$fieldName] = $this->{$fieldName};
                unset($findData[$fieldName]);
            }
        }

        if($record = self::findOne($findData)) {
            $recordData = $record->toArray();

            $skipFields = is_array($skipFields) ? $skipFields : [$skipFields];
            foreach($skipFields as $fieldName) {
                unset($recordData[$fieldName]);
            }

            $this->populateRecord($this, $recordData);
        }
    }
}