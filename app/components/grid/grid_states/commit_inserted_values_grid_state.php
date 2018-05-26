<?php

class CommitInsertedValuesGridState extends AbstractCommitValuesGridState
{
    protected function getOperation()
    {
        return 'Insert';
    }

    protected function handleError($message, $displayTime = 0)
    {
        $this->ChangeState(OPERATION_INSERT);
        parent::handleError($message, $displayTime);
    }

    protected function getNewRowValues($rowValues)
    {
        $auxArray = array();
        foreach ($this->getDataset()->GetFields() as $field) {
            $auxArray[$field->GetNameInDataset()] = null;
        }

        return array_merge(
            $auxArray,
            $this->GetDataset()->GetCurrentFieldValues(false)
        );
    }

    protected function refreshRowValues($rowValues)
    {
        return array_merge(
            $rowValues,
            $this->getDataset()->getInsertFieldValues()
        );
    }

    public function ProcessMessages()
    {
        $this->getDataset()->Insert();
        $this->doProcessMessages(array());
    }

    protected function prepareNewRowValuesToCommit($rowValues) {
        $result = array();
        $insertFieldValues = $this->getDataset()->getInsertFieldValues();
        foreach ($this->getDataset()->GetFields() as $field) {
            $fieldName = $field->GetNameInDataset();
            if (array_key_exists($fieldName, $insertFieldValues) || ($rowValues[$fieldName] !== null)) {
                $result[$fieldName] = $rowValues[$fieldName];
            }
        }
        return $result;
    }

    protected function getRealEditColumns()
    {
        return $this->grid->GetInsertColumns();
    }

    public function SetInternalStateSwitch($primaryKeys)
    {
        $this->grid->SetInternalStateSwitch($primaryKeys);
    }
}
