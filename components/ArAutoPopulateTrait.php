<?php

namespace app\components;

trait ArAutoPopulateTrait
{
    public function __construct($config = []) {
        parent::__construct($config);

        $populateData = [];
        foreach($this->autoPopulateFields as $fieldName) {
            $populateData[$fieldName] = isset($config[$fieldName]) ? $config[$fieldName] : null;
        }
        $this->populate($populateData);
    }

    public function load($data, $formName = null) {
        $populateData = [];
        $scope = $formName === null ? $this->formName() : $formName;
        foreach($this->autoPopulateFields as $fieldName) {
            $populateData[$fieldName] = isset($data[$scope][$fieldName]) ? $data[$scope][$fieldName] : null;
        }
        $this->populate($populateData);

        return parent::load($data, $formName);
    }

    private function populate($data) {
        if($this->isNeedToPopulate($data)
        && $fieldForPopulate = $this->getFieldForPopulate($data))
        if ($record = self::findOne($fieldForPopulate)) {
            $recordData = $record->toArray();
            if(property_exists($this, 'skipFieldsForPopulate')) {
                foreach($recordData as $k => $v) {
                    if(in_array($k, $this->skipFieldsForPopulate)) {
                        $recordData[$k] = null;
                    }
                }
            }

            $this->populateRecord($this, $recordData);
        }
    }

    private function isNeedToPopulate($data) {
        foreach($data as $fieldName => $value) {
            if(!$value) {
                return true;
            }
        }

        return false;
    }

    private function getFieldForPopulate($data) {
        foreach($data as $fieldName => $value) {
            if($value) {
                return [$fieldName => $value];
            }
        }

        return [];
    }
}