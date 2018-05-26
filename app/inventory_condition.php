<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/detail_page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/nested_form_page.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class inventory_condition_inventory_borrowed_inventory_inventory_loans_conditionPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_loans_condition`');
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Serial/ID_Number');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Item_Description');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Make/model');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Department');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Storage_Location');
            $this->dataset->AddField($field, false);
            $field = new StringField('Storage_Room');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateField('Date_Purchased');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Where_Purchased');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Purchase_Price');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Item_Condition');
            $this->dataset->AddField($field, false);
            $field = new StringField('All_Complete');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Completeness_Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Created_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Created_By');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Modified_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Modified_By');
            $this->dataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Validation_Status');
            $this->dataset->AddField($field, false);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Loan_Condition');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Condition_ID');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Validation_Status', 'inventory_validation_status', new IntegerField('ID', null, null, true), new StringField('Name', 'Validation_Status_Name', 'Validation_Status_Name_inventory_validation_status'), 'Validation_Status_Name_inventory_validation_status');
            $this->dataset->AddLookupField('Borrower_ID', '(select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w)', new StringField('KTP/ID'), new StringField('displayName', 'Borrower_ID_displayName', 'Borrower_ID_displayName_worker_display_lookup'), 'Borrower_ID_displayName_worker_display_lookup');
        }
    
        protected function DoPrepare() {
            foreach ( $this->GetGrid()->GetViewColumns(true) as $s)
            {
            $s->setNullLabel('');
            }
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Inventory_ID', 'Inventory_ID', 'Inventory ID'),
                new FilterColumn($this->dataset, 'Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number'),
                new FilterColumn($this->dataset, 'Item_Description', 'Item_Description', 'Item Description'),
                new FilterColumn($this->dataset, 'Make/model', 'Make/model', 'Make/model'),
                new FilterColumn($this->dataset, 'Department', 'Department', 'Department'),
                new FilterColumn($this->dataset, 'Storage_Location', 'Storage_Location', 'Storage Location'),
                new FilterColumn($this->dataset, 'Storage_Room', 'Storage_Room', 'Storage Room'),
                new FilterColumn($this->dataset, 'Date_Purchased', 'Date_Purchased', 'Date Purchased'),
                new FilterColumn($this->dataset, 'Where_Purchased', 'Where_Purchased', 'Where Purchased'),
                new FilterColumn($this->dataset, 'Purchase_Price', 'Purchase_Price', 'Purchase Price'),
                new FilterColumn($this->dataset, 'Item_Condition', 'Item_Condition', 'Item Condition'),
                new FilterColumn($this->dataset, 'All_Complete', 'All_Complete', 'All Complete'),
                new FilterColumn($this->dataset, 'Photo', 'Photo', 'Photo'),
                new FilterColumn($this->dataset, 'Completeness', 'Completeness', 'Completeness'),
                new FilterColumn($this->dataset, 'Completeness_Photo', 'Completeness_Photo', 'Completeness Photo'),
                new FilterColumn($this->dataset, 'Created_Date', 'Created_Date', 'Created Date'),
                new FilterColumn($this->dataset, 'Created_By', 'Created_By', 'Created By'),
                new FilterColumn($this->dataset, 'Modified_Date', 'Modified_Date', 'Modified Date'),
                new FilterColumn($this->dataset, 'Modified_By', 'Modified_By', 'Modified By'),
                new FilterColumn($this->dataset, 'Remark', 'Remark', 'Remark'),
                new FilterColumn($this->dataset, 'Validation_Status', 'Validation_Status_Name', 'Validation Status'),
                new FilterColumn($this->dataset, 'Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID'),
                new FilterColumn($this->dataset, 'Loan_Condition', 'Loan_Condition', 'Loan Condition'),
                new FilterColumn($this->dataset, 'Condition_ID', 'Condition_ID', 'Condition ID')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Inventory_ID'])
                ->addColumn($columns['Serial/ID_Number'])
                ->addColumn($columns['Item_Description'])
                ->addColumn($columns['Make/model'])
                ->addColumn($columns['Department'])
                ->addColumn($columns['Storage_Location'])
                ->addColumn($columns['Storage_Room'])
                ->addColumn($columns['Date_Purchased'])
                ->addColumn($columns['Where_Purchased'])
                ->addColumn($columns['Purchase_Price'])
                ->addColumn($columns['Item_Condition'])
                ->addColumn($columns['All_Complete'])
                ->addColumn($columns['Photo'])
                ->addColumn($columns['Completeness'])
                ->addColumn($columns['Completeness_Photo'])
                ->addColumn($columns['Created_Date'])
                ->addColumn($columns['Created_By'])
                ->addColumn($columns['Modified_Date'])
                ->addColumn($columns['Modified_By'])
                ->addColumn($columns['Remark'])
                ->addColumn($columns['Validation_Status'])
                ->addColumn($columns['Borrower_ID'])
                ->addColumn($columns['Loan_Condition'])
                ->addColumn($columns['Condition_ID']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Validation_Status')
                ->setOptionsFor('Borrower_ID');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('inventory_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Inventory_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('serial/id_number_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Serial/ID_Number'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Item_Description');
            
            $filterBuilder->addColumn(
                $columns['Item_Description'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('make/model_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Make/model'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('department_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Department'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('storage_location_edit');
            
            $filterBuilder->addColumn(
                $columns['Storage_Location'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('storage_room_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Storage_Room'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('date_purchased_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date_Purchased'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('where_purchased_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['Where_Purchased'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('purchase_price_edit');
            
            $filterBuilder->addColumn(
                $columns['Purchase_Price'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('item_condition_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Item_Condition'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('all_complete_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $main_editor->addChoice('Yes', 'Yes');
            $main_editor->addChoice('No', 'No');
            $main_editor->SetAllowNullValue(false);
            
            $multi_value_select_editor = new MultiValueSelect('All_Complete');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('All_Complete');
            
            $filterBuilder->addColumn(
                $columns['All_Complete'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Photo');
            
            $filterBuilder->addColumn(
                $columns['Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Completeness');
            
            $filterBuilder->addColumn(
                $columns['Completeness'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Completeness_Photo');
            
            $filterBuilder->addColumn(
                $columns['Completeness_Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Created_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('created_by_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Created_By'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Modified_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('modified_by_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Modified_By'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Remark');
            
            $filterBuilder->addColumn(
                $columns['Remark'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('validation_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Validation_Status_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Validation_Status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Validation_Status_Name_search');
            
            $filterBuilder->addColumn(
                $columns['Validation_Status'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('borrower_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Borrower_ID_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Borrower_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Borrower_ID_displayName_search');
            
            $text_editor = new TextEdit('Borrower_ID');
            
            $filterBuilder->addColumn(
                $columns['Borrower_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('loan_condition_edit');
            $main_editor->SetMaxLength(8);
            
            $filterBuilder->addColumn(
                $columns['Loan_Condition'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('condition_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Condition_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Loan_Condition field
            //
            $column = new TextViewColumn('Loan_Condition', 'Loan_Condition', 'Loan Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Condition_ID field
            //
            $column = new TextViewColumn('Condition_ID', 'Condition_ID', 'Condition ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Department field
            //
            $column = new TextViewColumn('Department', 'Department', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Storage_Location field
            //
            $column = new NumberViewColumn('Storage_Location', 'Storage_Location', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new NumberViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Item_Condition field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_By field
            //
            $column = new TextViewColumn('Created_By', 'Created_By', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Modified_Date field
            //
            $column = new DateTimeViewColumn('Modified_Date', 'Modified_Date', 'Modified Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Loan_Condition field
            //
            $column = new TextViewColumn('Loan_Condition', 'Loan_Condition', 'Loan Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Condition_ID field
            //
            $column = new TextViewColumn('Condition_ID', 'Condition_ID', 'Condition ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Inventory_ID field
            //
            $editor = new TextEdit('inventory_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Inventory ID', 'Inventory_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Inventory_ID field
            //
            $editor = new TextEdit('inventory_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Inventory ID', 'Inventory_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Department field
            //
            $column = new TextViewColumn('Department', 'Department', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Storage_Location field
            //
            $column = new NumberViewColumn('Storage_Location', 'Storage_Location', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new NumberViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Item_Condition field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Created_By field
            //
            $column = new TextViewColumn('Created_By', 'Created_By', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Modified_Date field
            //
            $column = new DateTimeViewColumn('Modified_Date', 'Modified_Date', 'Modified Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Loan_Condition field
            //
            $column = new TextViewColumn('Loan_Condition', 'Loan_Condition', 'Loan Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Condition_ID field
            //
            $column = new TextViewColumn('Condition_ID', 'Condition_ID', 'Condition ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Department field
            //
            $column = new TextViewColumn('Department', 'Department', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Storage_Location field
            //
            $column = new NumberViewColumn('Storage_Location', 'Storage_Location', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new NumberViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for Item_Condition field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Created_By field
            //
            $column = new TextViewColumn('Created_By', 'Created_By', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Modified_Date field
            //
            $column = new DateTimeViewColumn('Modified_Date', 'Modified_Date', 'Modified Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Loan_Condition field
            //
            $column = new TextViewColumn('Loan_Condition', 'Loan_Condition', 'Loan Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Condition_ID field
            //
            $column = new TextViewColumn('Condition_ID', 'Condition_ID', 'Condition ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Department field
            //
            $column = new TextViewColumn('Department', 'Department', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Storage_Location field
            //
            $column = new NumberViewColumn('Storage_Location', 'Storage_Location', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new NumberViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Item_Condition field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Created_By field
            //
            $column = new TextViewColumn('Created_By', 'Created_By', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Modified_Date field
            //
            $column = new DateTimeViewColumn('Modified_Date', 'Modified_Date', 'Modified Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Loan_Condition field
            //
            $column = new TextViewColumn('Loan_Condition', 'Loan_Condition', 'Loan Condition', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Condition_ID field
            //
            $column = new TextViewColumn('Condition_ID', 'Condition_ID', 'Condition ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setExportListAvailable(array('excel','word','xml','csv','pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('excel','word','xml','csv','pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_print', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_print', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_compare', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_compare', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_validation_status`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Validation_Status_Name_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Borrower_ID_displayName_search', 'KTP/ID', 'displayName', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Item_Description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Photo_handler_view', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Completeness_Photo_handler_view', new ImageFitByWidthResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.inventory_loans_condition_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            $s='Loan_Condition';
            if ( $fieldName==$s)
            {
                $v=strpos($rowData[$s],'B')?'Green':'Red';
                $customText="<div style=\"font-weight: bold;color: ".$v.";\">".$rowData[$s]."</div>";
                $handled=true;
            }
             $w='Condition_ID';
             if ($fieldName ==$w)
             {
             $y=urlencode($rowData[$w]);
             $v=strpos($y,'B')?'Returned':'Borrowed';
             $customText="<a href=\"".$v."_Inventory.php?operation=view&amp;pk0=".$y."\" target=\"_blank\">".$y."</a>";
             $handled=true;
             }
             $w = 'Inventory_ID';
                        $y = urlencode($rowData[$w]);
                        $z = array("Photo", "Completeness_Photo");
                        if ($fieldName ==$z[1]) {
                            $customText =$this->imp($z[1], $y);
                            $handled = true;
                        }
                        if ($fieldName ==$z[0]) {
                            $customText =$this->imp($z[0], $y);
                            $handled = true;
                        }
            
                    }
             protected function imp($fieldName, $pk )
                    {
                        $v = 'inventory.php?hname=inventoryGrid_' . $fieldName . '_handler_view&large=1&pk0=';
                        $ele = "<img data-image-column=\"true\" src=\"inventory.php?hname=inventoryGrid_" .$fieldName. "_handler_view&amp;pk0=" . $pk . "\">";
                        return "<a href=\"" . $v . $pk . "\" target=\"_blank\">" . $ele . "</a>";
             Global_CustomClientDate($fieldName,$rowData,$customText,$handled);
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doGetCustomUploadFileName($fieldName, $rowData, &$result, &$handled, $originalFileName, $originalFileExtension, $fileSize)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class inventory_condition_inventory_borrowed_inventory_returned_inventoryPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`returned_inventory`');
            $field = new StringField('Returned_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Reported_Staff_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateField('Returned_Date');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Item_Condition');
            $this->dataset->AddField($field, false);
            $field = new BlobField('Returned_Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Borrowed_ID', 'borrowed_inventory', new StringField('Borrowed_ID'), new StringField('Borrower_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed_ID_Borrower_ID_borrowed_inventory'), 'Borrowed_ID_Borrower_ID_borrowed_inventory');
            $this->dataset->AddLookupField('Reported_Staff_ID', '(select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w)', new StringField('KTP/ID'), new StringField('displayName', 'Reported_Staff_ID_displayName', 'Reported_Staff_ID_displayName_worker_display_lookup'), 'Reported_Staff_ID_displayName_worker_display_lookup');
            $this->dataset->AddLookupField('Item_Condition', 'inventory_condition', new StringField('Name'), new StringField('Name', 'Item_Condition_Name', 'Item_Condition_Name_inventory_condition'), 'Item_Condition_Name_inventory_condition');
        }
    
        protected function DoPrepare() {
            $sql = "SELECT IFNULL(CONCAT('RTN',LPAD(REPLACE(Max(Returned_ID),'RTN','')+1, 12,  '0')),'RTN000000000001') FROM returned_inventory";
            $qR = $this->GetConnection()->fetchAll($sql);
            $column = $this->GetGrid()->getInsertColumn('Returned_ID');
            $column->SetInsertDefaultValue($qR[0][0]);
            
            Global_SetColumnDefaultNull($this);
            $r = $this->GetConnection()->fetchAll('select value from setting where key_name=\'' . str_replace('.php', '', $this->GetPageFileName()) . '->description\'');
            if ($r != null)
            {
            $this->setDescription($r[0][0]);
            }
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Returned_ID', 'Returned_ID', 'Returned ID'),
                new FilterColumn($this->dataset, 'Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID'),
                new FilterColumn($this->dataset, 'Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID'),
                new FilterColumn($this->dataset, 'Returned_Date', 'Returned_Date', 'Returned Date'),
                new FilterColumn($this->dataset, 'Item_Condition', 'Item_Condition_Name', 'Item Condition'),
                new FilterColumn($this->dataset, 'Returned_Photo', 'Returned_Photo', 'Returned Photo'),
                new FilterColumn($this->dataset, 'Remark', 'Remark', 'Remark')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Returned_ID'])
                ->addColumn($columns['Borrowed_ID'])
                ->addColumn($columns['Reported_Staff_ID'])
                ->addColumn($columns['Returned_Date'])
                ->addColumn($columns['Item_Condition'])
                ->addColumn($columns['Returned_Photo'])
                ->addColumn($columns['Remark']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Borrowed_ID')
                ->setOptionsFor('Reported_Staff_ID')
                ->setOptionsFor('Returned_Date')
                ->setOptionsFor('Item_Condition');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('returned_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Returned_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('borrowed_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Borrowed_ID_Borrower_ID_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Borrowed_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Borrowed_ID_Borrower_ID_search');
            
            $text_editor = new TextEdit('Borrowed_ID');
            
            $filterBuilder->addColumn(
                $columns['Borrowed_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('reported_staff_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Reported_Staff_ID_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Reported_Staff_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Reported_Staff_ID_displayName_search');
            
            $text_editor = new TextEdit('Reported_Staff_ID');
            
            $filterBuilder->addColumn(
                $columns['Reported_Staff_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('returned_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Returned_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('item_condition_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Item_Condition_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Item_Condition', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Item_Condition_Name_search');
            
            $text_editor = new TextEdit('Item_Condition');
            
            $filterBuilder->addColumn(
                $columns['Item_Condition'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Returned_Photo');
            
            $filterBuilder->addColumn(
                $columns['Returned_Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('remark_edit');
            
            $filterBuilder->addColumn(
                $columns['Remark'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for Returned_ID field
            //
            $column = new TextViewColumn('Returned_ID', 'Returned_ID', 'Returned ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Borrower_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Returned_Date field
            //
            $column = new DateTimeViewColumn('Returned_Date', 'Returned_Date', 'Returned Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Returned_ID field
            //
            $column = new TextViewColumn('Returned_ID', 'Returned_ID', 'Returned ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Borrower_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Returned_Date field
            //
            $column = new DateTimeViewColumn('Returned_Date', 'Returned_Date', 'Returned Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_view');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('returned_inventory.php?hname=returned_inventoryGrid_Returned_Photo_handler_view&large=1&pk0=%Returned_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Returned_ID field
            //
            $editor = new TextEdit('returned_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Returned ID', 'Returned_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Borrowed_ID field
            //
            $editor = new AutocompleteComboBox('borrowed_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Borrower_ID', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrowed ID', 'Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'edit_Borrowed_ID_Borrower_ID_search', $editor, $this->dataset, $lookupDataset, 'Borrowed_ID', 'Borrower_ID', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Reported_Staff_ID field
            //
            $editor = new AutocompleteComboBox('reported_staff_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Reported Staff ID', 'Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'edit_Reported_Staff_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'KTP/ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Returned_Date field
            //
            $editor = new DateTimeEdit('returned_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Returned Date', 'Returned_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Item_Condition field
            //
            $editor = new RadioEdit('item_condition_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Item Condition', 
                'Item_Condition', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Returned_Photo field
            //
            $editor = new ImageUploader('returned_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Returned Photo', 'Returned_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_edit');
            $editColumn->SetFileSizeCheckMode(true, 4190208);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Returned_ID field
            //
            $editor = new TextEdit('returned_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Returned ID', 'Returned_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Borrowed_ID field
            //
            $editor = new AutocompleteComboBox('borrowed_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Borrower_ID', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrowed ID', 'Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'insert_Borrowed_ID_Borrower_ID_search', $editor, $this->dataset, $lookupDataset, 'Borrowed_ID', 'Borrower_ID', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Reported_Staff_ID field
            //
            $editor = new AutocompleteComboBox('reported_staff_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Reported Staff ID', 'Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'insert_Reported_Staff_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'KTP/ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Returned_Date field
            //
            $editor = new DateTimeEdit('returned_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Returned Date', 'Returned_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Item_Condition field
            //
            $editor = new RadioEdit('item_condition_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Item Condition', 
                'Item_Condition', 
                $editor, 
                $this->dataset, 'Name', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Returned_Photo field
            //
            $editor = new ImageUploader('returned_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Returned Photo', 'Returned_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_insert');
            $editColumn->SetFileSizeCheckMode(true, 4190208);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Returned_ID field
            //
            $column = new TextViewColumn('Returned_ID', 'Returned_ID', 'Returned ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Borrower_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Returned_Date field
            //
            $column = new DateTimeViewColumn('Returned_Date', 'Returned_Date', 'Returned Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_print');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('returned_inventory.php?hname=returned_inventoryGrid_Returned_Photo_handler_view&large=1&pk0=%Returned_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Returned_ID field
            //
            $column = new TextViewColumn('Returned_ID', 'Returned_ID', 'Returned ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Borrower_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Returned_Date field
            //
            $column = new DateTimeViewColumn('Returned_Date', 'Returned_Date', 'Returned Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_export');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('returned_inventory.php?hname=returned_inventoryGrid_Returned_Photo_handler_view&large=1&pk0=%Returned_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Returned_ID field
            //
            $column = new TextViewColumn('Returned_ID', 'Returned_ID', 'Returned ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Borrower_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_Borrower_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Returned_Date field
            //
            $column = new DateTimeViewColumn('Returned_Date', 'Returned_Date', 'Returned Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_compare');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('returned_inventory.php?hname=returned_inventoryGrid_Returned_Photo_handler_view&large=1&pk0=%Returned_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setExportListAvailable(array('excel','word','xml','csv','pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('excel','word','xml','csv','pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Borrower_ID', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Borrowed_ID_Borrower_ID_search', 'Borrowed_ID', 'Borrower_ID', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Reported_Staff_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Borrower_ID', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Borrowed_ID_Borrower_ID_search', 'Borrowed_ID', 'Borrower_ID', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Reported_Staff_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Item_Condition_Name_search', 'Name', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Item_Condition_Name_search', 'Name', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Item_Condition_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Borrower_ID', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Borrowed_ID_Borrower_ID_search', 'Borrowed_ID', 'Borrower_ID', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Reported_Staff_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory.returned_inventory_Returned_Photo_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doGetCustomUploadFileName($fieldName, $rowData, &$result, &$handled, $originalFileName, $originalFileExtension, $fileSize)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class inventory_condition_inventory_borrowed_inventoryPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`borrowed_inventory`');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Borrower_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Purposed');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Location');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateField('Borrowed_Date');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Borrowed_Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Agreement_Letter');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Borrower_ID', '(select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w)', new StringField('KTP/ID'), new StringField('displayName', 'Borrower_ID_displayName', 'Borrower_ID_displayName_worker_display_lookup'), 'Borrower_ID_displayName_worker_display_lookup');
            $this->dataset->AddLookupField('Inventory_ID', '(select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i)', new StringField('Inventory_ID'), new StringField('displayName', 'Inventory_ID_displayName', 'Inventory_ID_displayName_inventory_display_lookup'), 'Inventory_ID_displayName_inventory_display_lookup');
        }
    
        protected function DoPrepare() {
            $sql = "SELECT IFNULL(CONCAT('BRW',LPAD(REPLACE(Max(Borrowed_ID),'BRW','')+1, 12,  '0')),'BRW000000000001') FROM borrowed_inventory";
            $qR = $this->GetConnection()->fetchAll($sql);
            $column = $this->GetGrid()->getInsertColumn('Borrowed_ID');
            $column->SetInsertDefaultValue($qR[0][0]);
            
            Global_SetColumnDefaultNull($this);
            $r = $this->GetConnection()->fetchAll('select value from setting where key_name=\'' . str_replace('.php', '', $this->GetPageFileName()) . '->description\'');
            if ($r != null)
            {
            $this->setDescription($r[0][0]);
            }
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Borrowed_ID', 'Borrowed_ID', 'Borrowed ID'),
                new FilterColumn($this->dataset, 'Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID'),
                new FilterColumn($this->dataset, 'Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID'),
                new FilterColumn($this->dataset, 'Purposed', 'Purposed', 'Purposed'),
                new FilterColumn($this->dataset, 'Location', 'Location', 'Location'),
                new FilterColumn($this->dataset, 'Borrowed_Date', 'Borrowed_Date', 'Borrowed Date'),
                new FilterColumn($this->dataset, 'Quantities', 'Quantities', 'Quantities'),
                new FilterColumn($this->dataset, 'Completeness', 'Completeness', 'Completeness'),
                new FilterColumn($this->dataset, 'Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo'),
                new FilterColumn($this->dataset, 'Agreement_Letter', 'Agreement_Letter', 'Agreement Letter'),
                new FilterColumn($this->dataset, 'Remark', 'Remark', 'Remark')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Borrowed_ID'])
                ->addColumn($columns['Borrower_ID'])
                ->addColumn($columns['Inventory_ID'])
                ->addColumn($columns['Purposed'])
                ->addColumn($columns['Location'])
                ->addColumn($columns['Borrowed_Date'])
                ->addColumn($columns['Quantities'])
                ->addColumn($columns['Completeness'])
                ->addColumn($columns['Borrowed_Photo'])
                ->addColumn($columns['Agreement_Letter'])
                ->addColumn($columns['Remark']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Borrower_ID')
                ->setOptionsFor('Inventory_ID')
                ->setOptionsFor('Borrowed_Date')
                ->setOptionsFor('Completeness')
                ->setOptionsFor('Borrowed_Photo');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('borrowed_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Borrowed_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('borrower_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Borrower_ID_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Borrower_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Borrower_ID_displayName_search');
            
            $text_editor = new TextEdit('Borrower_ID');
            
            $filterBuilder->addColumn(
                $columns['Borrower_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('inventory_id_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Inventory_ID_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Inventory_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Inventory_ID_displayName_search');
            
            $text_editor = new TextEdit('Inventory_ID');
            
            $filterBuilder->addColumn(
                $columns['Inventory_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('purposed_edit');
            
            $filterBuilder->addColumn(
                $columns['Purposed'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('location_edit');
            
            $filterBuilder->addColumn(
                $columns['Location'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('borrowed_date_edit', false, 'd-M-Y');
            
            $filterBuilder->addColumn(
                $columns['Borrowed_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('quantities_edit');
            
            $filterBuilder->addColumn(
                $columns['Quantities'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('completeness_edit');
            
            $filterBuilder->addColumn(
                $columns['Completeness'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Borrowed_Photo');
            
            $filterBuilder->addColumn(
                $columns['Borrowed_Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Agreement_Letter');
            
            $filterBuilder->addColumn(
                $columns['Agreement_Letter'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('remark_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Remark'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory.inventory_loans_condition')->HasViewGrant() && $withDetails)
            {
            //
            // View column for inventory_condition_inventory_borrowed_inventory_inventory_loans_condition detail
            //
            $column = new DetailColumn(array('Inventory_ID'), 'inventory_condition.inventory.borrowed_inventory.inventory_loans_condition', 'inventory_condition_inventory_borrowed_inventory_inventory_loans_condition_handler', $this->dataset, 'Inventory Loans Condition');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory.returned_inventory')->HasViewGrant() && $withDetails)
            {
            //
            // View column for inventory_condition_inventory_borrowed_inventory_returned_inventory detail
            //
            $column = new DetailColumn(array('Borrowed_ID'), 'inventory_condition.inventory.borrowed_inventory.returned_inventory', 'inventory_condition_inventory_borrowed_inventory_returned_inventory_handler', $this->dataset, 'Returned Inventory');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for Borrowed_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_list');
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Borrowed_Date field
            //
            $column = new DateTimeViewColumn('Borrowed_Date', 'Borrowed_Date', 'Borrowed Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_list');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Borrowed_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_view');
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Borrowed_Date field
            //
            $column = new DateTimeViewColumn('Borrowed_Date', 'Borrowed_Date', 'Borrowed Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_view');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_view');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Agreement_Letter_handler_view&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Borrowed_ID field
            //
            $editor = new TextEdit('borrowed_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Borrowed ID', 'Borrowed_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Borrower_ID field
            //
            $editor = new AutocompleteComboBox('borrower_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrower ID', 'Borrower_ID', 'Borrower_ID_displayName', 'edit_Borrower_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'KTP/ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Inventory_ID field
            //
            $editor = new AutocompleteComboBox('inventory_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_display_lookup');
            $field = new StringField('Inventory_ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $field = new StringField('url');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Inventory ID', 'Inventory_ID', 'Inventory_ID_displayName', 'edit_Inventory_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'Inventory_ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Purposed field
            //
            $editor = new TextEdit('purposed_edit');
            $editColumn = new CustomEditColumn('Purposed', 'Purposed', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Location field
            //
            $editor = new TextEdit('location_edit');
            $editColumn = new CustomEditColumn('Location', 'Location', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Borrowed_Date field
            //
            $editor = new DateTimeEdit('borrowed_date_edit', false, 'd-M-Y');
            $editColumn = new CustomEditColumn('Borrowed Date', 'Borrowed_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Quantities field
            //
            $editor = new TextEdit('quantities_edit');
            $editColumn = new CustomEditColumn('Quantities', 'Quantities', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(1000000000, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Completeness field
            //
            $editor = new TextEdit('completeness_edit');
            $editColumn = new CustomEditColumn('Completeness', 'Completeness', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Borrowed_Photo field
            //
            $editor = new ImageUploader('borrowed_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Borrowed Photo', 'Borrowed_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_edit');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Agreement_Letter field
            //
            $editor = new ImageUploader('agreement_letter_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Agreement Letter', 'Agreement_Letter', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_edit');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Borrowed_ID field
            //
            $editor = new TextEdit('borrowed_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Borrowed ID', 'Borrowed_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Borrower_ID field
            //
            $editor = new AutocompleteComboBox('borrower_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrower ID', 'Borrower_ID', 'Borrower_ID_displayName', 'insert_Borrower_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'KTP/ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Inventory_ID field
            //
            $editor = new AutocompleteComboBox('inventory_id_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_display_lookup');
            $field = new StringField('Inventory_ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $field = new StringField('url');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Inventory ID', 'Inventory_ID', 'Inventory_ID_displayName', 'insert_Inventory_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'Inventory_ID', 'displayName', '%displayName%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Purposed field
            //
            $editor = new TextEdit('purposed_edit');
            $editColumn = new CustomEditColumn('Purposed', 'Purposed', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Location field
            //
            $editor = new TextEdit('location_edit');
            $editColumn = new CustomEditColumn('Location', 'Location', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Borrowed_Date field
            //
            $editor = new DateTimeEdit('borrowed_date_edit', false, 'd-M-Y');
            $editColumn = new CustomEditColumn('Borrowed Date', 'Borrowed_Date', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Quantities field
            //
            $editor = new TextEdit('quantities_edit');
            $editColumn = new CustomEditColumn('Quantities', 'Quantities', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(1000000000, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Completeness field
            //
            $editor = new TextEdit('completeness_edit');
            $editColumn = new CustomEditColumn('Completeness', 'Completeness', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Borrowed_Photo field
            //
            $editor = new ImageUploader('borrowed_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Borrowed Photo', 'Borrowed_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_insert');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Agreement_Letter field
            //
            $editor = new ImageUploader('agreement_letter_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Agreement Letter', 'Agreement_Letter', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_insert');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Borrowed_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_print');
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Borrowed_Date field
            //
            $column = new DateTimeViewColumn('Borrowed_Date', 'Borrowed_Date', 'Borrowed Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_print');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_print');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Agreement_Letter_handler_view&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Borrowed_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_export');
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Borrowed_Date field
            //
            $column = new DateTimeViewColumn('Borrowed_Date', 'Borrowed_Date', 'Borrowed Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_export');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_export');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Agreement_Letter_handler_view&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Borrowed_ID field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_compare');
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID_displayName', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Borrowed_Date field
            //
            $column = new DateTimeViewColumn('Borrowed_Date', 'Borrowed_Date', 'Borrowed Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_compare');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_compare');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Agreement_Letter_handler_view&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setExportListAvailable(array('excel','word','xml','csv','pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('excel','word','xml','csv','pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new inventory_condition_inventory_borrowed_inventory_inventory_loans_conditionPage('inventory_condition_inventory_borrowed_inventory_inventory_loans_condition', $this, array('Inventory_ID'), array('Inventory_ID'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory.inventory_loans_condition'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('inventory_condition.inventory.borrowed_inventory.inventory_loans_condition'));
            $detailPage->SetTitle('Inventory Loans Condition');
            $detailPage->SetMenuLabel('Inventory Loans Condition');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('inventory_condition_inventory_borrowed_inventory_inventory_loans_condition_handler');
            $handler = new PageHTTPHandler('inventory_condition_inventory_borrowed_inventory_inventory_loans_condition_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);$detailPage = new inventory_condition_inventory_borrowed_inventory_returned_inventoryPage('inventory_condition_inventory_borrowed_inventory_returned_inventory', $this, array('Borrowed_ID'), array('Borrowed_ID'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory.returned_inventory'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('inventory_condition.inventory.borrowed_inventory.returned_inventory'));
            $detailPage->SetTitle('Returned Inventory');
            $detailPage->SetMenuLabel('Returned Inventory');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('inventory_condition_inventory_borrowed_inventory_returned_inventory_handler');
            $handler = new PageHTTPHandler('inventory_condition_inventory_borrowed_inventory_returned_inventory_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_list', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Borrower_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_display_lookup');
            $field = new StringField('Inventory_ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $field = new StringField('url');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Inventory_ID_displayName_search', 'Inventory_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Borrower_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_display_lookup');
            $field = new StringField('Inventory_ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $field = new StringField('url');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Inventory_ID_displayName_search', 'Inventory_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrower_ID_displayName_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Purposed_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Location_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Completeness_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory.borrowed_inventory_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Borrower_ID_displayName_search', 'KTP/ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select i.Inventory_ID, 
            concat(i.Inventory_ID,
            \' (\',
            i.`Serial/ID_Number`,
            \', \',
            i.`Make/model`,\')\')
             as displayName , url_encode(i.Inventory_ID) as url
             from inventory as i';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_display_lookup');
            $field = new StringField('Inventory_ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $field = new StringField('url');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Inventory_ID_displayName_search', 'Inventory_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'DetailGridinventory_condition.inventory.borrowed_inventory_Borrowed_Photo_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'DetailGridinventory_condition.inventory.borrowed_inventory_Agreement_Letter_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            $v='inventory.php';
             $w='Inventory_ID';
             if ($fieldName ==$w)
             {
             $x=explode("(",$fieldData);
             $y=urlencode($rowData[$w]);
             $customText="<a href=\"".$v."?operation=view&amp;pk0=".$y."\" target=\"_blank\">".$x[0]."</a></br>(".$x[1];
             $handled=true;
             }
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doGetCustomUploadFileName($fieldName, $rowData, &$result, &$handled, $originalFileName, $originalFileExtension, $fileSize)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class inventory_condition_inventoryPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory`');
            $field = new StringField('Inventory_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Serial/ID_Number');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Item_Description');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Make/model');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Department');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Storage_Location');
            $this->dataset->AddField($field, false);
            $field = new StringField('Storage_Room');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateField('Date_Purchased');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Where_Purchased');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Purchase_Price');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Item_Condition');
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Quantities');
            $this->dataset->AddField($field, false);
            $field = new StringField('All_Complete');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Completeness');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new BlobField('Completeness_Photo');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Created_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Created_By');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Modified_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Modified_By');
            $this->dataset->AddField($field, false);
            $field = new StringField('Remark');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Validation_Status');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Department', '(select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc)', new StringField('Department_ID'), new StringField('displayName', 'Department_displayName', 'Department_displayName_department_display_lookup'), 'Department_displayName_department_display_lookup');
            $this->dataset->AddLookupField('Storage_Location', '(select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc)', new IntegerField('ID'), new StringField('displayName', 'Storage_Location_displayName', 'Storage_Location_displayName_inventory_location_display_lookup'), 'Storage_Location_displayName_inventory_location_display_lookup');
            $this->dataset->AddLookupField('Item_Condition', 'inventory_condition', new StringField('Name'), new StringField('Description', 'Item_Condition_Description', 'Item_Condition_Description_inventory_condition'), 'Item_Condition_Description_inventory_condition');
            $this->dataset->AddLookupField('Validation_Status', 'inventory_validation_status', new IntegerField('ID', null, null, true), new StringField('Name', 'Validation_Status_Name', 'Validation_Status_Name_inventory_validation_status'), 'Validation_Status_Name_inventory_validation_status');
            $this->dataset->AddLookupField('Created_By', '(SELECT
            	l.`ID`,
            	l.`Name`,
            	CONCAT(l.`Name`,\' (\',l.`CID`,\': \',l.`ID`,\')\') as \'displayName\'
            FROM
            	(
            SELECT
            IF
            	(ISNULL( u.`KTP/ID` ), u.User_ID, w.`KTP/ID` ) AS `ID`,
            IF
            	(ISNULL( u.`KTP/ID` ), \'User ID\', \'KTP/ID\' ) AS `CID`,
            IF
            	( ISNULL( u.`KTP/ID` ), u.user_name, w.Staff_Name ) AS `Name`,
            	u.User_ID,
            	w.`KTP/ID`,
            	u.user_name,
            	w.Staff_Name,
            	w.Contact_Number 
            FROM
            	USER AS u
            	LEFT JOIN worker AS w ON u.`KTP/ID` = w.`KTP/ID` 
            	) AS l)', new StringField('ID'), new StringField('displayName', 'Created_By_displayName', 'Created_By_displayName_user_worker_lookup'), 'Created_By_displayName_user_worker_lookup');
            $this->dataset->AddLookupField('Modified_By', '(SELECT
            	l.`ID`,
            	l.`Name`,
            	CONCAT(l.`Name`,\' (\',l.`CID`,\': \',l.`ID`,\')\') as \'displayName\'
            FROM
            	(
            SELECT
            IF
            	(ISNULL( u.`KTP/ID` ), u.User_ID, w.`KTP/ID` ) AS `ID`,
            IF
            	(ISNULL( u.`KTP/ID` ), \'User ID\', \'KTP/ID\' ) AS `CID`,
            IF
            	( ISNULL( u.`KTP/ID` ), u.user_name, w.Staff_Name ) AS `Name`,
            	u.User_ID,
            	w.`KTP/ID`,
            	u.user_name,
            	w.Staff_Name,
            	w.Contact_Number 
            FROM
            	USER AS u
            	LEFT JOIN worker AS w ON u.`KTP/ID` = w.`KTP/ID` 
            	) AS l)', new StringField('ID'), new StringField('displayName', 'Modified_By_displayName', 'Modified_By_displayName_user_worker_lookup'), 'Modified_By_displayName_user_worker_lookup');
        }
    
        protected function DoPrepare() {
            Global_SetColumnDefaultNull($this);
            $r = $this->GetConnection()->fetchAll('select value from setting where key_name=\'' . str_replace('.php', '', $this->GetPageFileName()) . '->description\'');
            if ($r != null)
            {
            $this->setDescription($r[0][0]);
            }
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(15);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Inventory_ID', 'Inventory_ID', 'Inventory ID'),
                new FilterColumn($this->dataset, 'Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number'),
                new FilterColumn($this->dataset, 'Make/model', 'Make/model', 'Make/model'),
                new FilterColumn($this->dataset, 'Department', 'Department_displayName', 'Department'),
                new FilterColumn($this->dataset, 'Storage_Location', 'Storage_Location_displayName', 'Storage Location'),
                new FilterColumn($this->dataset, 'Storage_Room', 'Storage_Room', 'Storage Room'),
                new FilterColumn($this->dataset, 'Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)'),
                new FilterColumn($this->dataset, 'Where_Purchased', 'Where_Purchased', 'Where Purchased'),
                new FilterColumn($this->dataset, 'Purchase_Price', 'Purchase_Price', 'Purchase Price'),
                new FilterColumn($this->dataset, 'Item_Condition', 'Item_Condition_Description', 'Item Condition'),
                new FilterColumn($this->dataset, 'Quantities', 'Quantities', 'Quantities'),
                new FilterColumn($this->dataset, 'All_Complete', 'All_Complete', 'All Complete'),
                new FilterColumn($this->dataset, 'Photo', 'Photo', 'Photo'),
                new FilterColumn($this->dataset, 'Completeness', 'Completeness', 'Completeness'),
                new FilterColumn($this->dataset, 'Completeness_Photo', 'Completeness_Photo', 'Completeness Photo'),
                new FilterColumn($this->dataset, 'Item_Description', 'Item_Description', 'Item Description'),
                new FilterColumn($this->dataset, 'Validation_Status', 'Validation_Status_Name', 'Validation Status'),
                new FilterColumn($this->dataset, 'Created_By', 'Created_By_displayName', 'Created By'),
                new FilterColumn($this->dataset, 'Created_Date', 'Created_Date', 'Created Date'),
                new FilterColumn($this->dataset, 'Modified_By', 'Modified_By_displayName', 'Modified By'),
                new FilterColumn($this->dataset, 'Modified_Date', 'Modified_Date', 'Modified Date'),
                new FilterColumn($this->dataset, 'Remark', 'Remark', 'Remark')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Inventory_ID'])
                ->addColumn($columns['Serial/ID_Number'])
                ->addColumn($columns['Item_Description'])
                ->addColumn($columns['Make/model'])
                ->addColumn($columns['Department'])
                ->addColumn($columns['Storage_Location'])
                ->addColumn($columns['Storage_Room'])
                ->addColumn($columns['Date_Purchased'])
                ->addColumn($columns['Where_Purchased'])
                ->addColumn($columns['Purchase_Price'])
                ->addColumn($columns['Item_Condition'])
                ->addColumn($columns['All_Complete'])
                ->addColumn($columns['Photo'])
                ->addColumn($columns['Completeness'])
                ->addColumn($columns['Completeness_Photo'])
                ->addColumn($columns['Created_Date'])
                ->addColumn($columns['Modified_Date'])
                ->addColumn($columns['Remark'])
                ->addColumn($columns['Validation_Status'])
                ->addColumn($columns['Created_By'])
                ->addColumn($columns['Modified_By'])
                ->addColumn($columns['Quantities']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Department')
                ->setOptionsFor('Storage_Location')
                ->setOptionsFor('Date_Purchased')
                ->setOptionsFor('Item_Condition')
                ->setOptionsFor('All_Complete')
                ->setOptionsFor('Photo')
                ->setOptionsFor('Validation_Status');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('inventory_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Inventory_ID'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('serial/id_number_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Serial/ID_Number'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('make/model_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Make/model'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('department_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Department_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Department', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Department_displayName_search');
            
            $text_editor = new TextEdit('Department');
            
            $filterBuilder->addColumn(
                $columns['Department'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('storage_location_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Storage_Location_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Storage_Location', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Storage_Location_displayName_search');
            
            $filterBuilder->addColumn(
                $columns['Storage_Location'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('storage_room_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Storage_Room'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('date_purchased_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date_Purchased'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('where_purchased_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['Where_Purchased'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('purchase_price_edit');
            
            $filterBuilder->addColumn(
                $columns['Purchase_Price'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('item_condition_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Item_Condition_Description_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Item_Condition', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Item_Condition_Description_search');
            
            $text_editor = new TextEdit('Item_Condition');
            
            $filterBuilder->addColumn(
                $columns['Item_Condition'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new SpinEdit('quantities_edit');
            $main_editor->SetUseConstraints(true);
            $main_editor->SetMaxValue(9999999);
            $main_editor->SetMinValue(0);
            $main_editor->SetStep(1);
            
            $filterBuilder->addColumn(
                $columns['Quantities'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('All_Complete');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('Yes', 'Yes');
            $main_editor->addChoice('No', 'No');
            
            $multi_value_select_editor = new MultiValueSelect('All_Complete');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('All_Complete');
            
            $filterBuilder->addColumn(
                $columns['All_Complete'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Photo');
            
            $filterBuilder->addColumn(
                $columns['Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('completeness_edit');
            
            $filterBuilder->addColumn(
                $columns['Completeness'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Completeness_Photo');
            
            $filterBuilder->addColumn(
                $columns['Completeness_Photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('item_description_edit');
            
            $filterBuilder->addColumn(
                $columns['Item_Description'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('validation_status_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Validation_Status_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Validation_Status', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Validation_Status_Name_search');
            
            $filterBuilder->addColumn(
                $columns['Validation_Status'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('created_by_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Created_By_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Created_By', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Created_By_displayName_search');
            
            $text_editor = new TextEdit('Created_By');
            
            $filterBuilder->addColumn(
                $columns['Created_By'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-M-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Created_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new AutocompleteComboBox('modified_by_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Modified_By_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Modified_By', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Modified_By_displayName_search');
            
            $text_editor = new TextEdit('Modified_By');
            
            $filterBuilder->addColumn(
                $columns['Modified_By'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-M-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['Modified_Date'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('remark_edit');
            
            $filterBuilder->addColumn(
                $columns['Remark'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory')->HasViewGrant() && $withDetails)
            {
            //
            // View column for inventory_condition_inventory_borrowed_inventory detail
            //
            $column = new DetailColumn(array('Inventory_ID'), 'inventory_condition.inventory.borrowed_inventory', 'inventory_condition_inventory_borrowed_inventory_handler', $this->dataset, 'Borrowed Inventory');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('This is Evi Identifier that gives by AEConsult');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::TABLET);
            $column->SetDescription('This is for IMEI and Serial number if it is have');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::TABLET);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Department', 'Department_displayName', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('department.php?operation=view&pk0=%Department%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Storage_Location', 'Storage_Location_displayName', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Storage_Location%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new CurrencyViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('Rp. ');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Condition_Description_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Photo_handler_list');
            $column->setNullLabel('No Photo');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Department', 'Department_displayName', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('department.php?operation=view&pk0=%Department%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Storage_Location', 'Storage_Location_displayName', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Storage_Location%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new CurrencyViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('Rp. ');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Condition_Description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Photo_handler_view');
            $column->setNullLabel('No Photo');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Completeness_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_view');
            $column->setNullLabel('No Photo');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Created_By', 'Created_By_displayName', 'Created By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By_displayName', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Modified_Date field
            //
            $column = new DateTimeViewColumn('Modified_Date', 'Modified_Date', 'Modified Date', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y H:i:s');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Remark_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Inventory_ID field
            //
            $editor = new TextEdit('inventory_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Inventory ID', 'Inventory_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Serial/ID_Number field
            //
            $editor = new TextEdit('serial/id_number_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Serial/ID Number', 'Serial/ID_Number', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Make/model field
            //
            $editor = new TextEdit('make/model_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Make/model', 'Make/model', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Department field
            //
            $editor = new AutocompleteComboBox('department_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'department_display_lookup');
            $field = new StringField('Department_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Department', 'Department', 'Department_displayName', 'edit_Department_displayName_search', $editor, $this->dataset, $lookupDataset, 'Department_ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Storage_Location field
            //
            $editor = new AutocompleteComboBox('storage_location_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_location_display_lookup');
            $field = new IntegerField('ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Storage Location', 'Storage_Location', 'Storage_Location_displayName', 'edit_Storage_Location_displayName_search', $editor, $this->dataset, $lookupDataset, 'ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Storage_Room field
            //
            $editor = new TextEdit('storage_room_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Storage Room', 'Storage_Room', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Purchased field
            //
            $editor = new DateTimeEdit('date_purchased_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date Purchased (Day-Month-Year)', 'Date_Purchased', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Where_Purchased field
            //
            $editor = new TextEdit('where_purchased_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Where Purchased', 'Where_Purchased', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Purchase_Price field
            //
            $editor = new TextEdit('purchase_price_edit');
            $editColumn = new CustomEditColumn('Purchase Price', 'Purchase_Price', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(1000000000, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Item_Condition field
            //
            $editor = new AutocompleteComboBox('item_condition_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Description', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Item Condition', 'Item_Condition', 'Item_Condition_Description', 'edit_Item_Condition_Description_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Description', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Quantities field
            //
            $editor = new SpinEdit('quantities_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(9999999);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
            $editColumn = new CustomEditColumn('Quantities', 'Quantities', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for All_Complete field
            //
            $editor = new RadioEdit('all_complete_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Yes', 'Yes');
            $editor->addChoice('No', 'No');
            $editColumn = new CustomEditColumn('All Complete', 'All_Complete', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Photo field
            //
            $editor = new ImageUploader('photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Photo', 'Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory_Photo_handler_edit');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Completeness field
            //
            $editor = new TextEdit('completeness_edit');
            $editColumn = new CustomEditColumn('Completeness', 'Completeness', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Completeness_Photo field
            //
            $editor = new ImageUploader('completeness_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Completeness Photo', 'Completeness_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Item_Description field
            //
            $editor = new TextEdit('item_description_edit');
            $editColumn = new CustomEditColumn('Item Description', 'Item_Description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Validation_Status field
            //
            $editor = new RadioEdit('validation_status_edit');
            $editor->SetDisplayMode(RadioEdit::StackedMode);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_validation_status`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Validation Status', 
                'Validation_Status', 
                $editor, 
                $this->dataset, 'ID', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Inventory_ID field
            //
            $editor = new TextEdit('inventory_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Inventory ID', 'Inventory_ID', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Serial/ID_Number field
            //
            $editor = new TextEdit('serial/id_number_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Serial/ID Number', 'Serial/ID_Number', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Make/model field
            //
            $editor = new TextEdit('make/model_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Make/model', 'Make/model', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Department field
            //
            $editor = new AutocompleteComboBox('department_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'department_display_lookup');
            $field = new StringField('Department_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Department', 'Department', 'Department_displayName', 'insert_Department_displayName_search', $editor, $this->dataset, $lookupDataset, 'Department_ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Storage_Location field
            //
            $editor = new AutocompleteComboBox('storage_location_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $selectQuery = 'select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_location_display_lookup');
            $field = new IntegerField('ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Storage Location', 'Storage_Location', 'Storage_Location_displayName', 'insert_Storage_Location_displayName_search', $editor, $this->dataset, $lookupDataset, 'ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Storage_Room field
            //
            $editor = new TextEdit('storage_room_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Storage Room', 'Storage_Room', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Purchased field
            //
            $editor = new DateTimeEdit('date_purchased_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date Purchased (Day-Month-Year)', 'Date_Purchased', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Where_Purchased field
            //
            $editor = new TextEdit('where_purchased_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Where Purchased', 'Where_Purchased', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Purchase_Price field
            //
            $editor = new TextEdit('purchase_price_edit');
            $editColumn = new CustomEditColumn('Purchase Price', 'Purchase_Price', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MaxValueValidator(1000000000, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MaxValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new MinValueValidator(0, StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('MinValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Item_Condition field
            //
            $editor = new AutocompleteComboBox('item_condition_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Description', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Item Condition', 'Item_Condition', 'Item_Condition_Description', 'insert_Item_Condition_Description_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Description', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Quantities field
            //
            $editor = new SpinEdit('quantities_edit');
            $editor->SetUseConstraints(true);
            $editor->SetMaxValue(9999999);
            $editor->SetMinValue(0);
            $editor->SetStep(1);
            $editColumn = new CustomEditColumn('Quantities', 'Quantities', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('1');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for All_Complete field
            //
            $editor = new RadioEdit('all_complete_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Yes', 'Yes');
            $editor->addChoice('No', 'No');
            $editColumn = new CustomEditColumn('All Complete', 'All_Complete', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Photo field
            //
            $editor = new ImageUploader('photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Photo', 'Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory_Photo_handler_insert');
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Completeness field
            //
            $editor = new TextEdit('completeness_edit');
            $editColumn = new CustomEditColumn('Completeness', 'Completeness', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Completeness_Photo field
            //
            $editor = new ImageUploader('completeness_photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Completeness Photo', 'Completeness_Photo', $editor, $this->dataset, false, false, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Item_Description field
            //
            $editor = new TextEdit('item_description_edit');
            $editColumn = new CustomEditColumn('Item Description', 'Item_Description', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Validation_Status field
            //
            $editor = new RadioEdit('validation_status_edit');
            $editor->SetDisplayMode(RadioEdit::StackedMode);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_validation_status`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Validation Status', 
                'Validation_Status', 
                $editor, 
                $this->dataset, 'ID', 'Name', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('0');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Remark field
            //
            $editor = new TextEdit('remark_edit');
            $editColumn = new CustomEditColumn('Remark', 'Remark', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Department', 'Department_displayName', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('department.php?operation=view&pk0=%Department%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Storage_Location', 'Storage_Location_displayName', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Storage_Location%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new CurrencyViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('Rp. ');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Condition_Description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Photo_handler_print');
            $column->setNullLabel('No Photo');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Completeness_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_print');
            $column->setNullLabel('No Photo');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Description_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Remark_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Department', 'Department_displayName', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('department.php?operation=view&pk0=%Department%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Storage_Location', 'Storage_Location_displayName', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Storage_Location%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new CurrencyViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('Rp. ');
            $grid->AddExportColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Condition_Description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Photo_handler_export');
            $column->setNullLabel('No Photo');
            $grid->AddExportColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Completeness_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_export');
            $column->setNullLabel('No Photo');
            $grid->AddExportColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Description_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Remark_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Inventory_ID field
            //
            $column = new TextViewColumn('Inventory_ID', 'Inventory_ID', 'Inventory ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Serial/ID_Number field
            //
            $column = new TextViewColumn('Serial/ID_Number', 'Serial/ID_Number', 'Serial/ID Number', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Make/model field
            //
            $column = new TextViewColumn('Make/model', 'Make/model', 'Make/model', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Department', 'Department_displayName', 'Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('department.php?operation=view&pk0=%Department%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Storage_Location', 'Storage_Location_displayName', 'Storage Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Storage_Location%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Storage_Room field
            //
            $column = new TextViewColumn('Storage_Room', 'Storage_Room', 'Storage Room', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Purchased field
            //
            $column = new DateTimeViewColumn('Date_Purchased', 'Date_Purchased', 'Date Purchased (Day-Month-Year)', $this->dataset);
            $column->SetDateTimeFormat('d-M-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Where_Purchased field
            //
            $column = new TextViewColumn('Where_Purchased', 'Where_Purchased', 'Where Purchased', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Purchase_Price field
            //
            $column = new CurrencyViewColumn('Purchase_Price', 'Purchase_Price', 'Purchase Price', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setCurrencySign('Rp. ');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Condition_Description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Quantities field
            //
            $column = new NumberViewColumn('Quantities', 'Quantities', 'Quantities', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for All_Complete field
            //
            $column = new TextViewColumn('All_Complete', 'All_Complete', 'All Complete', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Photo field
            //
            $column = new BlobImageViewColumn('Photo', 'Photo', 'Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Photo_handler_compare');
            $column->setNullLabel('No Photo');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Completeness_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Completeness_Photo field
            //
            $column = new BlobImageViewColumn('Completeness_Photo', 'Completeness_Photo', 'Completeness Photo', $this->dataset, true, 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_compare');
            $column->setNullLabel('No Photo');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Item_Description_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Validation_Status', 'Validation_Status_Name', 'Validation Status', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridinventory_condition.inventory_Remark_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(true);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return 'var off=-(new Date()).getTimezoneOffset()*60;'. "\n" .
            'document.cookie="TZ="+off;';
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(true);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setTableBordered(false);
            $result->setTableCondensed(true);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setExportListAvailable(array('excel','word','xml','csv','pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('excel','word','xml','csv','pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new inventory_condition_inventory_borrowed_inventoryPage('inventory_condition_inventory_borrowed_inventory', $this, array('Borrowed_ID'), array('Inventory_ID'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory.borrowed_inventory'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('inventory_condition.inventory.borrowed_inventory'));
            $detailPage->SetTitle('Borrowed Inventory');
            $detailPage->SetMenuLabel('Borrowed Inventory');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('inventory_condition_inventory_borrowed_inventory_handler');
            $handler = new PageHTTPHandler('inventory_condition_inventory_borrowed_inventory_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Condition_Description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_list', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Condition_Description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Completeness_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Condition_Description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Completeness_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'department_display_lookup');
            $field = new StringField('Department_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_location_display_lookup');
            $field = new IntegerField('ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Storage_Location_displayName_search', 'ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Description', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Item_Condition_Description_search', 'Name', 'Description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $selectQuery = 'select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'department_display_lookup');
            $field = new StringField('Department_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_location_display_lookup');
            $field = new IntegerField('ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Storage_Location_displayName_search', 'ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Description', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Item_Condition_Description_search', 'Name', 'Description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_validation_status`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Validation_Status_Name_search', 'ID', 'Name', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT
            	l.`ID`,
            	l.`Name`,
            	CONCAT(l.`Name`,\' (\',l.`CID`,\': \',l.`ID`,\')\') as \'displayName\'
            FROM
            	(
            SELECT
            IF
            	(ISNULL( u.`KTP/ID` ), u.User_ID, w.`KTP/ID` ) AS `ID`,
            IF
            	(ISNULL( u.`KTP/ID` ), \'User ID\', \'KTP/ID\' ) AS `CID`,
            IF
            	( ISNULL( u.`KTP/ID` ), u.user_name, w.Staff_Name ) AS `Name`,
            	u.User_ID,
            	w.`KTP/ID`,
            	u.user_name,
            	w.Staff_Name,
            	w.Contact_Number 
            FROM
            	USER AS u
            	LEFT JOIN worker AS w ON u.`KTP/ID` = w.`KTP/ID` 
            	) AS l';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'user_worker_lookup');
            $field = new StringField('ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Created_By_displayName_search', 'ID', 'displayName', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'SELECT
            	l.`ID`,
            	l.`Name`,
            	CONCAT(l.`Name`,\' (\',l.`CID`,\': \',l.`ID`,\')\') as \'displayName\'
            FROM
            	(
            SELECT
            IF
            	(ISNULL( u.`KTP/ID` ), u.User_ID, w.`KTP/ID` ) AS `ID`,
            IF
            	(ISNULL( u.`KTP/ID` ), \'User ID\', \'KTP/ID\' ) AS `CID`,
            IF
            	( ISNULL( u.`KTP/ID` ), u.user_name, w.Staff_Name ) AS `Name`,
            	u.User_ID,
            	w.`KTP/ID`,
            	u.user_name,
            	w.Staff_Name,
            	w.Contact_Number 
            FROM
            	USER AS u
            	LEFT JOIN worker AS w ON u.`KTP/ID` = w.`KTP/ID` 
            	) AS l';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'user_worker_lookup');
            $field = new StringField('ID');
            $lookupDataset->AddField($field, true);
            $field = new StringField('Name');
            $lookupDataset->AddField($field, false);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Modified_By_displayName_search', 'ID', 'displayName', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Description', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Condition_Description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Completeness_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Item_Description field
            //
            $column = new TextViewColumn('Item_Description', 'Item_Description', 'Item Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Item_Description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridinventory_condition.inventory_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'department_display_lookup');
            $field = new StringField('Department_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct il.ID,  
            concat(il.Location_Name,\' (\',il.ZIP,\' - \', il.MapCoordinate,\')\') as displayName
            from inventory_location as il 
            order by il.Location_Name asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'inventory_location_display_lookup');
            $field = new IntegerField('ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Storage_Location_displayName_search', 'ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Description', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Item_Condition_Description_search', 'Name', 'Description', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Photo', 'DetailGridinventory_condition.inventory_Photo_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Completeness_Photo', 'DetailGridinventory_condition.inventory_Completeness_Photo_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            Global_CustomClientDate($fieldName,$rowData,$customText,$handled);
            
            $w = 'Inventory_ID';
                        $y = urlencode($rowData[$w]);
                        $z = array("Photo", "Completeness_Photo");
                        if ($fieldName ==$z[1]) {
                            $customText =$this->imp($z[1], $y);
                            $handled = true;
                        }
                        if ($fieldName ==$z[0]) {
                            $customText =$this->imp($z[0], $y);
                            $handled = true;
                        }
            
                    }
                    protected function imp($fieldName, $pk )
                    {
                        $v = 'inventory.php?hname=inventoryGrid_' . $fieldName . '_handler_view&large=1&pk0=';
                        $ele = "<img data-image-column=\"true\" src=\"inventory.php?hname=inventoryGrid_" .$fieldName. "_handler_view&amp;pk0=" . $pk . "\">";
                        return "<a href=\"" . $v . $pk . "\" target=\"_blank\">" . $ele . "</a>";
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doGetCustomUploadFileName($fieldName, $rowData, &$result, &$handled, $originalFileName, $originalFileExtension, $fileSize)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
            if (!GetApplication()->IsLoggedInAsAdmin())
                        {
                        $col=$this->GetGrid()->getEditColumn('Validation_Status');
                        if ($col)
                        {
                        $col->setAllowSingleViewCellEdit(false);
                        $col->setAllowListCellEdit(false);
                        }
                        }
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class inventory_conditionPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_condition`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Description');
            $this->dataset->AddField($field, false);
        }
    
        protected function DoPrepare() {
            Global_SetColumnDefaultNull($this);
            $r = $this->GetConnection()->fetchAll('select value from setting where key_name=\'' . str_replace('.php', '', $this->GetPageFileName()) . '->description\'');
            if ($r != null)
            {
            $this->setDescription($r[0][0]);
            }
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Name', 'Name', 'Name'),
                new FilterColumn($this->dataset, 'Description', 'Description', 'Description')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Name'])
                ->addColumn($columns['Description']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('name_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Name'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('description_edit');
            
            $filterBuilder->addColumn(
                $columns['Description'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory')->HasViewGrant() && $withDetails)
            {
            //
            // View column for inventory_condition_inventory detail
            //
            $column = new DetailColumn(array('Name'), 'inventory_condition.inventory', 'inventory_condition_inventory_handler', $this->dataset, 'Inventory');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_conditionGrid_Description_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_conditionGrid_Description_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Name', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Description field
            //
            $editor = new TextEdit('description_edit');
            $editColumn = new CustomEditColumn('Description', 'Description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Name field
            //
            $editor = new TextEdit('name_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Name', 'Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Description field
            //
            $editor = new TextEdit('description_edit');
            $editColumn = new CustomEditColumn('Description', 'Description', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_conditionGrid_Description_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_conditionGrid_Description_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Name', 'Name', 'Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_conditionGrid_Description_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
    
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setExportListAvailable(array('excel','word','xml','csv','pdf'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('excel','word','xml','csv','pdf'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new inventory_condition_inventoryPage('inventory_condition_inventory', $this, array('Item_Condition'), array('Name'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('inventory_condition.inventory'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('inventory_condition.inventory'));
            $detailPage->SetTitle('Inventory');
            $detailPage->SetMenuLabel('Inventory');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('inventory_condition_inventory_handler');
            $handler = new PageHTTPHandler('inventory_condition_inventory_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_conditionGrid_Description_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_conditionGrid_Description_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_conditionGrid_Description_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for Description field
            //
            $column = new TextViewColumn('Description', 'Description', 'Description', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_conditionGrid_Description_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, &$cancel, &$message, &$messageDisplayTime, $tableName)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doGetCustomUploadFileName($fieldName, $rowData, &$result, &$handled, $originalFileName, $originalFileExtension, $fileSize)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new inventory_conditionPage("inventory_condition", "inventory_condition.php", GetCurrentUserPermissionSetForDataSource("inventory_condition"), 'UTF-8');
        $Page->SetTitle('Inventory Condition');
        $Page->SetMenuLabel('Inventory Condition');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("inventory_condition"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
