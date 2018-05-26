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
    
    
    
    class borrowed_inventory_returned_inventoryPage extends DetailPage
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
            $this->dataset->AddLookupField('Borrowed_ID', '(select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc)', new StringField('Borrowed_ID'), new StringField('displayName', 'Borrowed_ID_displayName', 'Borrowed_ID_displayName_borrowed_inventory_display_lookup'), 'Borrowed_ID_displayName_borrowed_inventory_display_lookup');
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
                new FilterColumn($this->dataset, 'Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID'),
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
                ->addColumn($columns['Returned_Photo'])
                ->addColumn($columns['Remark'])
                ->addColumn($columns['Item_Condition']);
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
            $main_editor->SetHandlerName('filter_builder_Borrowed_ID_displayName_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Borrowed_ID', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Borrowed_ID_displayName_search');
            
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
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID', $this->dataset);
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_list');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_list');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Remark_handler_list');
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
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_view');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_view');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Remark_handler_view');
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
            $selectQuery = 'select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'borrowed_inventory_display_lookup');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrowed ID', 'Borrowed_ID', 'Borrowed_ID_displayName', 'edit_Borrowed_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'Borrowed_ID', 'displayName', '%displayName%');
            $editColumn->SetReadOnly(true);
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
            $editColumn = new FileUploadingColumn('Returned Photo', 'Returned_Photo', $editor, $this->dataset, false, false, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_edit');
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
            $selectQuery = 'select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'borrowed_inventory_display_lookup');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Borrowed ID', 'Borrowed_ID', 'Borrowed_ID_displayName', 'insert_Borrowed_ID_displayName_search', $editor, $this->dataset, $lookupDataset, 'Borrowed_ID', 'displayName', '%displayName%');
            $editColumn->SetReadOnly(true);
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
            $editColumn = new FileUploadingColumn('Returned Photo', 'Returned_Photo', $editor, $this->dataset, false, false, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_insert');
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
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_print');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_print');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Remark_handler_print');
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
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_export');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_export');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Remark_handler_export');
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
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrowed_ID', 'Borrowed_ID_displayName', 'Borrowed ID', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_compare');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Returned_Photo field
            //
            $column = new BlobImageViewColumn('Returned_Photo', 'Returned_Photo', 'Returned Photo', $this->dataset, true, 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_compare');
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
            $column->SetFullTextWindowHandlerName('DetailGridborrowed_inventory.returned_inventory_Remark_handler_compare');
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Remark_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Reported_Staff_ID', 'Reported_Staff_ID_displayName', 'Reported Staff ID', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Remark_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'borrowed_inventory_display_lookup');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Borrowed_ID_displayName_search', 'Borrowed_ID', 'displayName', $this->RenderText('%displayName%'), 20);
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
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $selectQuery = 'select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'borrowed_inventory_display_lookup');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Borrowed_ID_displayName_search', 'Borrowed_ID', 'displayName', $this->RenderText('%displayName%'), 20);
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Reported_Staff_ID_displayName_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Name field
            //
            $column = new TextViewColumn('Item_Condition', 'Item_Condition_Name', 'Item Condition', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Item_Condition_Name_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridborrowed_inventory.returned_inventory_Remark_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$selectQuery = 'select distinct b.Borrowed_ID,  
            concat(b.Borrowed_ID,\' (\',b.Inventory_ID,\' - \',w.`KTP/ID` ,\', \',w.Staff_Name,\')\') as displayName
            from Borrowed_inventory as b 
            inner join worker as w on w.`KTP/ID`=b.Borrower_ID
            order by b.Borrowed_ID asc';
            $insertQuery = array();
            $updateQuery = array();
            $deleteQuery = array();
            $lookupDataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'borrowed_inventory_display_lookup');
            $field = new StringField('Borrowed_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('displayName');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('displayName', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Borrowed_ID_displayName_search', 'Borrowed_ID', 'displayName', $this->RenderText('%displayName%'), 20);
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
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Returned_Photo', 'DetailGridborrowed_inventory.returned_inventory_Returned_Photo_handler_edit', new NullFilter());
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
    
    
    
    class borrowed_inventoryPage extends Page
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
            if (GetCurrentUserPermissionSetForDataSource('borrowed_inventory.returned_inventory')->HasViewGrant() && $withDetails)
            {
            //
            // View column for borrowed_inventory_returned_inventory detail
            //
            $column = new DetailColumn(array('Borrowed_ID'), 'borrowed_inventory.returned_inventory', 'borrowed_inventory_returned_inventory_handler', $this->dataset, 'Returned Inventory');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Borrower_ID_displayName_handler_list');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Purposed_handler_list');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Location_handler_list');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Completeness_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'borrowed_inventoryGrid_Borrowed_Photo_handler_list');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Remark_handler_list');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Borrower_ID_displayName_handler_view');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Purposed_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Location_handler_view');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Completeness_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'borrowed_inventoryGrid_Borrowed_Photo_handler_view');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'borrowed_inventoryGrid_Agreement_Letter_handler_view');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Remark_handler_view');
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
            $editColumn->SetReadOnly(true);
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
            $editColumn = new FileUploadingColumn('Borrowed Photo', 'Borrowed_Photo', $editor, $this->dataset, false, false, 'borrowed_inventoryGrid_Borrowed_Photo_handler_edit');
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
            $editColumn = new FileUploadingColumn('Agreement Letter', 'Agreement_Letter', $editor, $this->dataset, false, false, 'borrowed_inventoryGrid_Agreement_Letter_handler_edit');
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
            $editColumn->SetReadOnly(true);
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
            $editColumn = new FileUploadingColumn('Borrowed Photo', 'Borrowed_Photo', $editor, $this->dataset, false, false, 'borrowed_inventoryGrid_Borrowed_Photo_handler_insert');
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
            $editColumn = new FileUploadingColumn('Agreement Letter', 'Agreement_Letter', $editor, $this->dataset, false, false, 'borrowed_inventoryGrid_Agreement_Letter_handler_insert');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Borrower_ID_displayName_handler_print');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Purposed_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Location_handler_print');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Completeness_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'borrowed_inventoryGrid_Borrowed_Photo_handler_print');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'borrowed_inventoryGrid_Agreement_Letter_handler_print');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Remark_handler_print');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Borrower_ID_displayName_handler_export');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Purposed_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Location_handler_export');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Completeness_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'borrowed_inventoryGrid_Borrowed_Photo_handler_export');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'borrowed_inventoryGrid_Agreement_Letter_handler_export');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Remark_handler_export');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Borrower_ID_displayName_handler_compare');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Purposed_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Location_handler_compare');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Completeness_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Borrowed_Photo field
            //
            $column = new BlobImageViewColumn('Borrowed_Photo', 'Borrowed_Photo', 'Borrowed Photo', $this->dataset, true, 'borrowed_inventoryGrid_Borrowed_Photo_handler_compare');
            $column->SetEnablePictureZoom(false);
            $column->setHrefTemplate('borrowed_inventory.php?hname=borrowed_inventoryGrid_Borrowed_Photo_handler_list&large=1&pk0=%Borrowed_ID%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Agreement_Letter field
            //
            $column = new BlobImageViewColumn('Agreement_Letter', 'Agreement_Letter', 'Agreement Letter', $this->dataset, true, 'borrowed_inventoryGrid_Agreement_Letter_handler_compare');
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
            $column->SetFullTextWindowHandlerName('borrowed_inventoryGrid_Remark_handler_compare');
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
            $detailPage = new borrowed_inventory_returned_inventoryPage('borrowed_inventory_returned_inventory', $this, array('Borrowed_ID'), array('Borrowed_ID'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('borrowed_inventory.returned_inventory'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('borrowed_inventory.returned_inventory'));
            $detailPage->SetTitle('Returned Inventory');
            $detailPage->SetMenuLabel('Returned Inventory');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('borrowed_inventory_returned_inventory_handler');
            $handler = new PageHTTPHandler('borrowed_inventory_returned_inventory_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Borrower_ID_displayName_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Purposed_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Location_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Completeness_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_list', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Remark_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Borrower_ID_displayName_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Purposed_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Location_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Completeness_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'borrowed_inventoryGrid_Agreement_Letter_handler_print', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Remark_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for displayName field
            //
            $column = new TextViewColumn('Borrower_ID', 'Borrower_ID_displayName', 'Borrower ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('worker.php?operation=view&pk0=%Borrower_ID%');
            $column->setTarget('_blank');
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Borrower_ID_displayName_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Purposed_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Location_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Completeness_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'borrowed_inventoryGrid_Agreement_Letter_handler_compare', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Remark_handler_compare', $column);
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
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'borrowed_inventoryGrid_Agreement_Letter_handler_insert', new NullFilter());
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
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Borrower_ID_displayName_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Purposed field
            //
            $column = new TextViewColumn('Purposed', 'Purposed', 'Purposed', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Purposed_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Location field
            //
            $column = new TextViewColumn('Location', 'Location', 'Location', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Location_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Completeness field
            //
            $column = new TextViewColumn('Completeness', 'Completeness', 'Completeness', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Completeness_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'borrowed_inventoryGrid_Agreement_Letter_handler_view', new ImageFitByHeightResizeFilter(100));
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Remark field
            //
            $column = new TextViewColumn('Remark', 'Remark', 'Remark', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'borrowed_inventoryGrid_Remark_handler_view', $column);
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
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Borrowed_Photo', 'borrowed_inventoryGrid_Borrowed_Photo_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);$handler = new ImageHTTPHandler($this->dataset, 'Agreement_Letter', 'borrowed_inventoryGrid_Agreement_Letter_handler_edit', new NullFilter());
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

    SetUpUserAuthorization();

    try
    {
        $Page = new borrowed_inventoryPage("borrowed_inventory", "borrowed_inventory.php", GetCurrentUserPermissionSetForDataSource("borrowed_inventory"), 'UTF-8');
        $Page->SetTitle('Borrowed Inventory');
        $Page->SetMenuLabel('Borrowed Inventory');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("borrowed_inventory"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
