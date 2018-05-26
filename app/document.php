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
    
    
    
    class documentPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document`');
            $field = new StringField('Document_ID');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Document_Category');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new DateField('Received_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('To_Department');
            $this->dataset->AddField($field, false);
            $field = new StringField('Document_No');
            $this->dataset->AddField($field, false);
            $field = new DateField('Document_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Sender');
            $this->dataset->AddField($field, false);
            $field = new StringField('Recipient');
            $this->dataset->AddField($field, false);
            $field = new StringField('CC');
            $this->dataset->AddField($field, false);
            $field = new StringField('Subject');
            $this->dataset->AddField($field, false);
            $field = new StringField('Used_For');
            $this->dataset->AddField($field, false);
            $field = new StringField('Summary');
            $this->dataset->AddField($field, false);
            $field = new BlobField('Image');
            $this->dataset->AddField($field, false);
            $field = new StringField('Remark');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Created_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Created_By');
            $this->dataset->AddField($field, false);
            $field = new DateTimeField('Modified_Date');
            $this->dataset->AddField($field, false);
            $field = new StringField('Modified_By');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Document_Category', 'document_category', new StringField('Name'), new StringField('Name', 'Document_Category_Name', 'Document_Category_Name_document_category'), 'Document_Category_Name_document_category');
            $this->dataset->AddLookupField('To_Department', '(select distinct d.Department_ID,  
            concat(o.Awesome_Name,\' (\',d.Job_Division,\')\') as displayName
            from department as d 
            inner join office as o 
            on o.Office_ID = d.Office 
            order by d.Job_Division asc)', new StringField('Department_ID'), new StringField('displayName', 'To_Department_displayName', 'To_Department_displayName_department_display_lookup'), 'To_Department_displayName_department_display_lookup');
        }
    
        protected function DoPrepare() {
            $sql = "SELECT IFNULL(CONCAT('DOC',LPAD(REPLACE(Max(Document_ID),'DOC','')+1, 12,  '0')),'DOC000000000001') as p FROM Document";
            $qR = $this->GetConnection()->fetchAll($sql);
            $column = $this->GetGrid()->getInsertColumn('Document_ID');
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
                new FilterColumn($this->dataset, 'Document_ID', 'Document_ID', 'Document ID'),
                new FilterColumn($this->dataset, 'Document_Category', 'Document_Category_Name', 'Document Category'),
                new FilterColumn($this->dataset, 'Received_Date', 'Received_Date', 'Received Date'),
                new FilterColumn($this->dataset, 'To_Department', 'To_Department_displayName', 'To Department'),
                new FilterColumn($this->dataset, 'Document_No', 'Document_No', 'Document No'),
                new FilterColumn($this->dataset, 'Document_Date', 'Document_Date', 'Document Date'),
                new FilterColumn($this->dataset, 'Sender', 'Sender', 'Sender'),
                new FilterColumn($this->dataset, 'Recipient', 'Recipient', 'Recipient'),
                new FilterColumn($this->dataset, 'CC', 'CC', 'CC'),
                new FilterColumn($this->dataset, 'Subject', 'Subject', 'Subject'),
                new FilterColumn($this->dataset, 'Used_For', 'Used_For', 'Used For'),
                new FilterColumn($this->dataset, 'Image', 'Image', 'Image'),
                new FilterColumn($this->dataset, 'Summary', 'Summary', 'Summary'),
                new FilterColumn($this->dataset, 'Remark', 'Remark', 'Remark'),
                new FilterColumn($this->dataset, 'Created_Date', 'Created_Date', 'Created Date'),
                new FilterColumn($this->dataset, 'Created_By', 'Created_By', 'Created By'),
                new FilterColumn($this->dataset, 'Modified_Date', 'Modified_Date', 'Modified Date'),
                new FilterColumn($this->dataset, 'Modified_By', 'Modified_By', 'Modified By')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Document_ID'])
                ->addColumn($columns['Document_Category'])
                ->addColumn($columns['Received_Date'])
                ->addColumn($columns['To_Department'])
                ->addColumn($columns['Document_No'])
                ->addColumn($columns['Document_Date'])
                ->addColumn($columns['Sender'])
                ->addColumn($columns['Recipient'])
                ->addColumn($columns['CC'])
                ->addColumn($columns['Subject'])
                ->addColumn($columns['Used_For'])
                ->addColumn($columns['Image'])
                ->addColumn($columns['Summary'])
                ->addColumn($columns['Remark'])
                ->addColumn($columns['Created_Date'])
                ->addColumn($columns['Created_By'])
                ->addColumn($columns['Modified_Date'])
                ->addColumn($columns['Modified_By']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Document_Category')
                ->setOptionsFor('Received_Date')
                ->setOptionsFor('To_Department')
                ->setOptionsFor('Document_Date')
                ->setOptionsFor('Used_For')
                ->setOptionsFor('Image');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('document_id_edit');
            $main_editor->SetMaxLength(40);
            
            $filterBuilder->addColumn(
                $columns['Document_ID'],
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
            
            $main_editor = new AutocompleteComboBox('document_category_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Document_Category_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Document_Category', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Document_Category_Name_search');
            
            $text_editor = new TextEdit('Document_Category');
            
            $filterBuilder->addColumn(
                $columns['Document_Category'],
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
            
            $main_editor = new DateTimeEdit('received_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Received_Date'],
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
            
            $main_editor = new AutocompleteComboBox('to_department_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_To_Department_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('To_Department', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_To_Department_displayName_search');
            
            $text_editor = new TextEdit('To_Department');
            
            $filterBuilder->addColumn(
                $columns['To_Department'],
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
            
            $main_editor = new TextEdit('document_no_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Document_No'],
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
            
            $main_editor = new DateTimeEdit('document_date_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Document_Date'],
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
            
            $main_editor = new TextEdit('sender_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Sender'],
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
            
            $main_editor = new TextEdit('recipient_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Recipient'],
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
            
            $main_editor = new TextEdit('cc_edit');
            
            $filterBuilder->addColumn(
                $columns['CC'],
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
            
            $main_editor = new TextEdit('subject_edit');
            
            $filterBuilder->addColumn(
                $columns['Subject'],
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
            
            $main_editor = new RemoteMultiValueSelect('used_for_edit', $this->CreateLinkBuilder());
            $main_editor->SetHandlerName('filter_builder_Used_For_KTP/ID_displayName_search');
            $main_editor->setMaxSelectionSize(0);
            
            $text_editor = new TextEdit('Used_For');
            
            $filterBuilder->addColumn(
                $columns['Used_For'],
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Image');
            
            $filterBuilder->addColumn(
                $columns['Image'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('summary_edit');
            
            $filterBuilder->addColumn(
                $columns['Summary'],
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
            
            $main_editor = new DateTimeEdit('created_date_edit', false, 'd-m-Y');
            
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
            
            $main_editor = new DateTimeEdit('modified_date_edit', false, 'd-m-Y');
            
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
            // View column for Document_ID field
            //
            $column = new TextViewColumn('Document_ID', 'Document_ID', 'Document ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_Category_Name_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Received_Date field
            //
            $column = new DateTimeViewColumn('Received_Date', 'Received_Date', 'Received Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('To_Department', 'To_Department_displayName', 'To Department', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_No_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Document_Date field
            //
            $column = new DateTimeViewColumn('Document_Date', 'Document_Date', 'Document Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Sender_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Recipient_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_CC_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Subject_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Used_For_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Image field
            //
            $column = new BlobImageViewColumn('Image', 'Image', 'Image', $this->dataset, true, 'documentGrid_Image_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Summary_handler_list');
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
            $column->SetFullTextWindowHandlerName('documentGrid_Remark_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Document_ID field
            //
            $column = new TextViewColumn('Document_ID', 'Document_ID', 'Document ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_Category_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Received_Date field
            //
            $column = new DateTimeViewColumn('Received_Date', 'Received_Date', 'Received Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('To_Department', 'To_Department_displayName', 'To Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_No_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Document_Date field
            //
            $column = new DateTimeViewColumn('Document_Date', 'Document_Date', 'Document Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Sender_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Recipient_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_CC_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Subject_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Used_For_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Image field
            //
            $column = new BlobImageViewColumn('Image', 'Image', 'Image', $this->dataset, true, 'documentGrid_Image_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Summary_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Remark_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Document_ID field
            //
            $editor = new TextEdit('document_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Document ID', 'Document_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Document_Category field
            //
            $editor = new AutocompleteComboBox('document_category_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document_category`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Example');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Document Category', 'Document_Category', 'Document_Category_Name', 'edit_Document_Category_Name_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Name', '%Name%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Received_Date field
            //
            $editor = new DateTimeEdit('received_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Received Date', 'Received_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for To_Department field
            //
            $editor = new AutocompleteComboBox('to_department_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('To Department', 'To_Department', 'To_Department_displayName', 'edit_To_Department_displayName_search', $editor, $this->dataset, $lookupDataset, 'Department_ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Document_No field
            //
            $editor = new TextEdit('document_no_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Document No', 'Document_No', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Document_Date field
            //
            $editor = new DateTimeEdit('document_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Document Date', 'Document_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Sender field
            //
            $editor = new TextEdit('sender_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Sender', 'Sender', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Recipient field
            //
            $editor = new TextEdit('recipient_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Recipient', 'Recipient', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CC field
            //
            $editor = new TextEdit('cc_edit');
            $editColumn = new CustomEditColumn('CC', 'CC', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Subject field
            //
            $editor = new TextEdit('subject_edit');
            $editColumn = new CustomEditColumn('Subject', 'Subject', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Used_For field
            //
            $editor = new RemoteMultiValueSelect('used_for_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('edit_Used_For_KTP/ID_displayName_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Used For', 'Used_For', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Image field
            //
            $editor = new ImageUploader('image_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Image', 'Image', $editor, $this->dataset, false, false, 'documentGrid_Image_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Summary field
            //
            $editor = new TextEdit('summary_edit');
            $editColumn = new CustomEditColumn('Summary', 'Summary', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // Edit column for Document_ID field
            //
            $editor = new TextEdit('document_id_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Document ID', 'Document_ID', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Document_Category field
            //
            $editor = new AutocompleteComboBox('document_category_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document_category`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Example');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Document Category', 'Document_Category', 'Document_Category_Name', 'insert_Document_Category_Name_search', $editor, $this->dataset, $lookupDataset, 'Name', 'Name', '%Name%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Received_Date field
            //
            $editor = new DateTimeEdit('received_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Received Date', 'Received_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for To_Department field
            //
            $editor = new AutocompleteComboBox('to_department_edit', $this->CreateLinkBuilder());
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
            $editColumn = new DynamicLookupEditColumn('To Department', 'To_Department', 'To_Department_displayName', 'insert_To_Department_displayName_search', $editor, $this->dataset, $lookupDataset, 'Department_ID', 'displayName', '%displayName%');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Document_No field
            //
            $editor = new TextEdit('document_no_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Document No', 'Document_No', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Document_Date field
            //
            $editor = new DateTimeEdit('document_date_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Document Date', 'Document_Date', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Sender field
            //
            $editor = new TextEdit('sender_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Sender', 'Sender', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Recipient field
            //
            $editor = new TextEdit('recipient_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Recipient', 'Recipient', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CC field
            //
            $editor = new TextEdit('cc_edit');
            $editColumn = new CustomEditColumn('CC', 'CC', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Subject field
            //
            $editor = new TextEdit('subject_edit');
            $editColumn = new CustomEditColumn('Subject', 'Subject', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Used_For field
            //
            $editor = new RemoteMultiValueSelect('used_for_edit', $this->CreateLinkBuilder());
            $editor->SetHandlerName('insert_Used_For_KTP/ID_displayName_search');
            $editor->setMaxSelectionSize(0);
            $editColumn = new CustomEditColumn('Used For', 'Used_For', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Image field
            //
            $editor = new ImageUploader('image_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Image', 'Image', $editor, $this->dataset, false, false, 'documentGrid_Image_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileSizeCheckMode(true, 4125696);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Summary field
            //
            $editor = new TextEdit('summary_edit');
            $editColumn = new CustomEditColumn('Summary', 'Summary', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // View column for Document_ID field
            //
            $column = new TextViewColumn('Document_ID', 'Document_ID', 'Document ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_Category_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Received_Date field
            //
            $column = new DateTimeViewColumn('Received_Date', 'Received_Date', 'Received Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('To_Department', 'To_Department_displayName', 'To Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_No_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Document_Date field
            //
            $column = new DateTimeViewColumn('Document_Date', 'Document_Date', 'Document Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Sender_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Recipient_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_CC_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Subject_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Used_For_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Image field
            //
            $column = new BlobImageViewColumn('Image', 'Image', 'Image', $this->dataset, true, 'documentGrid_Image_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Summary_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Remark_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Document_ID field
            //
            $column = new TextViewColumn('Document_ID', 'Document_ID', 'Document ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_Category_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Received_Date field
            //
            $column = new DateTimeViewColumn('Received_Date', 'Received_Date', 'Received Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('To_Department', 'To_Department_displayName', 'To Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_No_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Document_Date field
            //
            $column = new DateTimeViewColumn('Document_Date', 'Document_Date', 'Document Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Sender_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Recipient_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_CC_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Subject_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Used_For_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Image field
            //
            $column = new BlobImageViewColumn('Image', 'Image', 'Image', $this->dataset, true, 'documentGrid_Image_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Summary_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Remark_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Document_ID field
            //
            $column = new TextViewColumn('Document_ID', 'Document_ID', 'Document ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_Category_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Received_Date field
            //
            $column = new DateTimeViewColumn('Received_Date', 'Received_Date', 'Received Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('To_Department', 'To_Department_displayName', 'To Department', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Document_No_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Document_Date field
            //
            $column = new DateTimeViewColumn('Document_Date', 'Document_Date', 'Document Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Sender_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Recipient_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_CC_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Subject_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Used_For_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Image field
            //
            $column = new BlobImageViewColumn('Image', 'Image', 'Image', $this->dataset, true, 'documentGrid_Image_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Summary_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('documentGrid_Remark_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Created_Date field
            //
            $column = new DateTimeViewColumn('Created_Date', 'Created_Date', 'Created Date', $this->dataset);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetDateTimeFormat('d-m-Y');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Modified_By field
            //
            $column = new TextViewColumn('Modified_By', 'Modified_By', 'Modified By', $this->dataset);
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
            return 'var off=-(new Date()).getTimezoneOffset()*60;'. "\n" .
            'document.cookie="TZ="+off;';
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
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_Category_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_No_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Sender_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Recipient_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_CC_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Subject_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Used_For_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_list', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Summary_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Remark_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_Category_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_No_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Sender_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Recipient_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_CC_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Subject_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Used_For_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Summary_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_Category_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_No_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Sender_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Recipient_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_CC_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Subject_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Used_For_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Summary_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document_category`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Example');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Document_Category_Name_search', 'Name', 'Name', $this->RenderText('%Name%'), 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_To_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $valuesDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $valuesDataset->AddField($field, true);
            $field = new StringField('displayName');
            $valuesDataset->AddField($field, false);
            $valuesDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $handler = new DynamicMultipleSelectSearchHandler($valuesDataset, $this, 'insert_Used_For_KTP/ID_displayName_search', 'KTP/ID', 'displayName');
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document_category`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Example');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Document_Category_Name_search', 'Name', 'Name', $this->RenderText('%Name%'), 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_To_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $valuesDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $valuesDataset->AddField($field, true);
            $field = new StringField('displayName');
            $valuesDataset->AddField($field, false);
            $valuesDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $handler = new DynamicMultipleSelectSearchHandler($valuesDataset, $this, 'filter_builder_Used_For_KTP/ID_displayName_search', 'KTP/ID', 'displayName');
            GetApplication()->RegisterHTTPHandler($handler);
            
            $selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $valuesDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $valuesDataset->AddField($field, true);
            $field = new StringField('displayName');
            $valuesDataset->AddField($field, false);
            $valuesDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $handler = new DynamicMultipleSelectSearchHandler($valuesDataset, $this, 'filter_builder_Used_For_KTP/ID_displayName_search', 'KTP/ID', 'displayName');
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Document_Category', 'Document_Category_Name', 'Document Category', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_Category_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Document_No field
            //
            $column = new TextViewColumn('Document_No', 'Document_No', 'Document No', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Document_No_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Sender field
            //
            $column = new TextViewColumn('Sender', 'Sender', 'Sender', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Sender_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Recipient field
            //
            $column = new TextViewColumn('Recipient', 'Recipient', 'Recipient', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Recipient_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for CC field
            //
            $column = new TextViewColumn('CC', 'CC', 'CC', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_CC_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Subject field
            //
            $column = new TextViewColumn('Subject', 'Subject', 'Subject', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Subject_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Used_For field
            //
            $column = new TextViewColumn('Used_For', 'Used_For', 'Used For', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Used_For_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Summary field
            //
            $column = new TextViewColumn('Summary', 'Summary', 'Summary', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Summary_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'documentGrid_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`document_category`');
            $field = new StringField('Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Example');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Description');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Document_Category_Name_search', 'Name', 'Name', $this->RenderText('%Name%'), 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_To_Department_displayName_search', 'Department_ID', 'displayName', $this->RenderText('%displayName%'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select w.`KTP/ID`, concat (w.Staff_Name,\' (\',w.`KTP/ID`,\')\') as displayName from worker as w';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $valuesDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'worker_display_lookup');
            $field = new StringField('KTP/ID');
            $valuesDataset->AddField($field, true);
            $field = new StringField('displayName');
            $valuesDataset->AddField($field, false);
            $valuesDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $handler = new DynamicMultipleSelectSearchHandler($valuesDataset, $this, 'edit_Used_For_KTP/ID_displayName_search', 'KTP/ID', 'displayName');
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Image', 'documentGrid_Image_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
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

    SetUpUserAuthorization();

    try
    {
        $Page = new documentPage("document", "document.php", GetCurrentUserPermissionSetForDataSource("document"), 'UTF-8');
        $Page->SetTitle('Document');
        $Page->SetMenuLabel('Document');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("document"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
