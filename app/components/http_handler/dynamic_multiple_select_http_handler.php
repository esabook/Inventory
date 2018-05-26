<?php

include_once dirname(__FILE__) . '/abstract_http_handler.php';

class DynamicMultipleSelectSearchHandler extends AbstractHTTPHandler
{
    /** @var Dataset */
    private $dataset;
    /** @var string */
    private $storedField;
    /** @var string */
    private $displayedField;
    /** @var int */
    private $numberOfValuesToDisplay = 20;

    /**
     * @param Dataset $dataset
     * @param Page|null $parentPage
     * @param string $name
     * @param string $storedField
     * @param string $displayedField
     */
    public function __construct($dataset, $parentPage, $name, $storedField, $displayedField)
    {
        parent::__construct($name);
        $this->dataset = $dataset;
        $this->storedField = $storedField;
        $this->displayedField = $displayedField;
    }

    /**
     * @param Renderer $renderer
     * @return void
     */
    public function Render(Renderer $renderer)
    {
        $getWrapper = ArrayWrapper::createGetWrapper();

        /** @var string $term */
        $term = trim($getWrapper->getValue('term', ''));
        if (!empty($term)) {
            $this->dataset->AddFieldFilter(
                $this->storedField,
                new FieldFilter('%'.$term.'%', 'ILIKE', true)
            );
        }

        $excludedValues = $getWrapper->getValue('excludedValues', array());
        foreach ($excludedValues as $value) {
            $this->dataset->AddFieldFilter($this->storedField, FieldFilter::DoesNotEqual($value));
        }

        $this->dataset->getSelectCommand()->addDistinct($this->storedField);

        header('Content-Type: application/json; charset=utf-8');

        $this->dataset->Open();

        $result = array();
        $valueCount = 0;

        while ($this->dataset->Next()) {
            $result[] = array(
                'id' => $this->dataset->GetFieldValueByName($this->storedField),
                'value' => $this->dataset->GetFieldValueByName($this->displayedField)
            );

            if (++$valueCount >= $this->numberOfValuesToDisplay) {
                break;
            }
        }

        echo SystemUtils::ToJSON($result);

        $this->dataset->Close();
    }
}
