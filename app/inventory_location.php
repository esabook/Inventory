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
    
    
    
    class inventory_locationPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $this->dataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $this->dataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Province');
            $this->dataset->AddField($field, false);
            $field = new StringField('Region');
            $this->dataset->AddField($field, false);
            $field = new StringField('City');
            $this->dataset->AddField($field, false);
            $field = new StringField('Street');
            $this->dataset->AddField($field, false);
            $field = new StringField('Address');
            $this->dataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Parent_Location', 'inventory_location', new IntegerField('ID', null, null, true), new StringField('Location_Name', 'Parent_Location_Location_Name', 'Parent_Location_Location_Name_inventory_location'), 'Parent_Location_Location_Name_inventory_location');
            $this->dataset->AddLookupField('Nearest_Office', 'office', new StringField('Office_ID'), new StringField('Awesome_Name', 'Nearest_Office_Awesome_Name', 'Nearest_Office_Awesome_Name_office'), 'Nearest_Office_Awesome_Name_office');
        }
    
        protected function DoPrepare() {
            $f=$this->GetGrid()->getEditColumn('MapCoordinate');
            $validator = new CustomRegExpValidator('^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$', 'Wrong coordinate format. Ex. 130.898,120.000', $this->RenderText($f->GetCaption()));
            $f->GetEditControl()->GetValidatorCollection()->AddValidator($validator);
            
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
                new FilterColumn($this->dataset, 'ID', 'ID', 'ID'),
                new FilterColumn($this->dataset, 'Location_Name', 'Location_Name', 'Location Name'),
                new FilterColumn($this->dataset, 'Province', 'Province', 'Province'),
                new FilterColumn($this->dataset, 'Region', 'Region', 'Region'),
                new FilterColumn($this->dataset, 'City', 'City', 'City'),
                new FilterColumn($this->dataset, 'Street', 'Street', 'Street'),
                new FilterColumn($this->dataset, 'Address', 'Address', 'Address'),
                new FilterColumn($this->dataset, 'ZIP', 'ZIP', 'ZIP'),
                new FilterColumn($this->dataset, 'MapCoordinate', 'MapCoordinate', 'Map Coordinate'),
                new FilterColumn($this->dataset, 'Parent_Location', 'Parent_Location_Location_Name', 'Parent Location'),
                new FilterColumn($this->dataset, 'Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID'])
                ->addColumn($columns['Location_Name'])
                ->addColumn($columns['Province'])
                ->addColumn($columns['Region'])
                ->addColumn($columns['City'])
                ->addColumn($columns['Street'])
                ->addColumn($columns['Address'])
                ->addColumn($columns['ZIP'])
                ->addColumn($columns['MapCoordinate'])
                ->addColumn($columns['Parent_Location'])
                ->addColumn($columns['Nearest_Office']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Parent_Location')
                ->setOptionsFor('Nearest_Office');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['ID'],
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
            
            $main_editor = new TextEdit('location_name_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Location_Name'],
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
            
            $main_editor = new TextEdit('province_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Province'],
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
            
            $main_editor = new TextEdit('region_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Region'],
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
            
            $main_editor = new TextEdit('city_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['City'],
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
            
            $main_editor = new TextEdit('street_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Street'],
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
            
            $main_editor = new TextEdit('Address');
            
            $filterBuilder->addColumn(
                $columns['Address'],
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
            
            $main_editor = new TextEdit('zip_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['ZIP'],
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
            
            $main_editor = new TextEdit('mapcoordinate_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['MapCoordinate'],
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
            
            $main_editor = new AutocompleteComboBox('parent_location_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Parent_Location_Location_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Parent_Location', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Parent_Location_Location_Name_search');
            
            $filterBuilder->addColumn(
                $columns['Parent_Location'],
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
            
            $main_editor = new AutocompleteComboBox('nearest_office_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_Nearest_Office_Awesome_Name_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Nearest_Office', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_Nearest_Office_Awesome_Name_search');
            
            $text_editor = new TextEdit('Nearest_Office');
            
            $filterBuilder->addColumn(
                $columns['Nearest_Office'],
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
            // View column for ID field
            //
            $column = new NumberViewColumn('ID', 'ID', 'ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Location_Name', 'Location_Name', 'Location Name', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Province_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('Region', 'Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Street_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Address_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ZIP field
            //
            $column = new TextViewColumn('ZIP', 'ZIP', 'ZIP', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for MapCoordinate field
            //
            $column = new TextViewColumn('MapCoordinate', 'MapCoordinate', 'Map Coordinate', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Parent_Location', 'Parent_Location_Location_Name', 'Parent Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Parent_Location%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Awesome_Name field
            //
            $column = new TextViewColumn('Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('office.php?operation=view&pk0=%Nearest_Office%');
            $column->setTarget('_blank');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID field
            //
            $column = new NumberViewColumn('ID', 'ID', 'ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Location_Name', 'Location_Name', 'Location Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Province_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('Region', 'Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Street_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Address_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ZIP field
            //
            $column = new TextViewColumn('ZIP', 'ZIP', 'ZIP', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for MapCoordinate field
            //
            $column = new TextViewColumn('MapCoordinate', 'MapCoordinate', 'Map Coordinate', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Parent_Location', 'Parent_Location_Location_Name', 'Parent Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Parent_Location%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Awesome_Name field
            //
            $column = new TextViewColumn('Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('office.php?operation=view&pk0=%Nearest_Office%');
            $column->setTarget('_blank');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Location_Name field
            //
            $editor = new TextEdit('location_name_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Location Name', 'Location_Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Province field
            //
            $editor = new TextEdit('province_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Province', 'Province', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Region', 'Region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for City field
            //
            $editor = new TextEdit('city_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('City', 'City', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Street field
            //
            $editor = new TextEdit('street_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Street', 'Street', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Address field
            //
            $editor = new TextAreaEdit('address_edit', 50, 8);
            $editColumn = new CustomEditColumn('Address', 'Address', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ZIP field
            //
            $editor = new TextEdit('zip_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('ZIP', 'ZIP', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for MapCoordinate field
            //
            $editor = new TextEdit('mapcoordinate_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Map Coordinate', 'MapCoordinate', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Parent_Location field
            //
            $editor = new AutocompleteComboBox('parent_location_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Location_Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Parent Location', 'Parent_Location', 'Parent_Location_Location_Name', 'edit_Parent_Location_Location_Name_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Location_Name', '%Location_Name% - (%ID% , %MapCoordinate%)');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nearest_Office field
            //
            $editor = new AutocompleteComboBox('nearest_office_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`office`');
            $field = new StringField('Office_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Awesome_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 1');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 2');
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Awesome_Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Nearest Office', 'Nearest_Office', 'Nearest_Office_Awesome_Name', 'edit_Nearest_Office_Awesome_Name_search', $editor, $this->dataset, $lookupDataset, 'Office_ID', 'Awesome_Name', '%Office_ID% - (%Awesome_Name%, %MapCoordinate%)');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Location_Name field
            //
            $editor = new TextEdit('location_name_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Location Name', 'Location_Name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Province field
            //
            $editor = new TextEdit('province_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Province', 'Province', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Region field
            //
            $editor = new TextEdit('region_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Region', 'Region', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for City field
            //
            $editor = new TextEdit('city_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('City', 'City', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Street field
            //
            $editor = new TextEdit('street_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Street', 'Street', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Address field
            //
            $editor = new TextAreaEdit('address_edit', 50, 8);
            $editColumn = new CustomEditColumn('Address', 'Address', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ZIP field
            //
            $editor = new TextEdit('zip_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('ZIP', 'ZIP', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for MapCoordinate field
            //
            $editor = new TextEdit('mapcoordinate_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Map Coordinate', 'MapCoordinate', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('1,1');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Parent_Location field
            //
            $editor = new AutocompleteComboBox('parent_location_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Location_Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Parent Location', 'Parent_Location', 'Parent_Location_Location_Name', 'insert_Parent_Location_Location_Name_search', $editor, $this->dataset, $lookupDataset, 'ID', 'Location_Name', '%Location_Name% - (%ID% , %MapCoordinate%)');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nearest_Office field
            //
            $editor = new AutocompleteComboBox('nearest_office_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`office`');
            $field = new StringField('Office_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Awesome_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 1');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 2');
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Awesome_Name', GetOrderTypeAsSQL(otAscending));
            $editColumn = new DynamicLookupEditColumn('Nearest Office', 'Nearest_Office', 'Nearest_Office_Awesome_Name', 'insert_Nearest_Office_Awesome_Name_search', $editor, $this->dataset, $lookupDataset, 'Office_ID', 'Awesome_Name', '%Office_ID% - (%Awesome_Name%, %MapCoordinate%)');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for ID field
            //
            $column = new NumberViewColumn('ID', 'ID', 'ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Location_Name', 'Location_Name', 'Location Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Province_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('Region', 'Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Street_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Address_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for ZIP field
            //
            $column = new TextViewColumn('ZIP', 'ZIP', 'ZIP', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for MapCoordinate field
            //
            $column = new TextViewColumn('MapCoordinate', 'MapCoordinate', 'Map Coordinate', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Parent_Location', 'Parent_Location_Location_Name', 'Parent Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Parent_Location%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Awesome_Name field
            //
            $column = new TextViewColumn('Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('office.php?operation=view&pk0=%Nearest_Office%');
            $column->setTarget('_blank');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID field
            //
            $column = new NumberViewColumn('ID', 'ID', 'ID', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Location_Name', 'Location_Name', 'Location Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Province_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('Region', 'Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Street_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Address_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for ZIP field
            //
            $column = new TextViewColumn('ZIP', 'ZIP', 'ZIP', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for MapCoordinate field
            //
            $column = new TextViewColumn('MapCoordinate', 'MapCoordinate', 'Map Coordinate', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Parent_Location', 'Parent_Location_Location_Name', 'Parent Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Parent_Location%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
            
            //
            // View column for Awesome_Name field
            //
            $column = new TextViewColumn('Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('office.php?operation=view&pk0=%Nearest_Office%');
            $column->setTarget('_blank');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Location_Name', 'Location_Name', 'Location Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Province_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Region field
            //
            $column = new TextViewColumn('Region', 'Region', 'Region', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for City field
            //
            $column = new TextViewColumn('City', 'City', 'City', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Street_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('inventory_locationGrid_Address_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for ZIP field
            //
            $column = new TextViewColumn('ZIP', 'ZIP', 'ZIP', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for MapCoordinate field
            //
            $column = new TextViewColumn('MapCoordinate', 'MapCoordinate', 'Map Coordinate', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Location_Name field
            //
            $column = new TextViewColumn('Parent_Location', 'Parent_Location_Location_Name', 'Parent Location', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('inventory_location.php?operation=view&pk0=%Parent_Location%');
            $column->setTarget('_blank');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Awesome_Name field
            //
            $column = new TextViewColumn('Nearest_Office', 'Nearest_Office_Awesome_Name', 'Nearest Office', $this->dataset);
            $column->SetOrderable(true);
            $column->setHrefTemplate('office.php?operation=view&pk0=%Nearest_Office%');
            $column->setTarget('_blank');
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
            $grid->SetInsertClientEditorValueChangedScript($this->RenderText('if(sender.getFieldName()==\'MapCoordinate\')
            {
             if (sender.getValue()==\'\')
             {
              editors[\'MapCoordinate\'].setValue(\'1,1\');
             }
            }'));
            
            $grid->SetEditClientEditorValueChangedScript($this->RenderText('if(sender.getFieldName()==\'MapCoordinate\')
            {
             if (sender.getValue()==\'\')
             {
              editors[\'MapCoordinate\'].setValue(\'1,1\');
             }
            }'));
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Province_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Street_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Address_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Province_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Street_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Address_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Province_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Street_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Address_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Location_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Parent_Location_Location_Name_search', 'ID', 'Location_Name', $this->RenderText('%Location_Name% - (%ID% , %MapCoordinate%)'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`office`');
            $field = new StringField('Office_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Awesome_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 1');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 2');
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Awesome_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_Nearest_Office_Awesome_Name_search', 'Office_ID', 'Awesome_Name', $this->RenderText('%Office_ID% - (%Awesome_Name%, %MapCoordinate%)'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Location_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Parent_Location_Location_Name_search', 'ID', 'Location_Name', $this->RenderText('%Location_Name% - (%ID% , %MapCoordinate%)'), 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`office`');
            $field = new StringField('Office_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Awesome_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 1');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 2');
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Awesome_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_Nearest_Office_Awesome_Name_search', 'Office_ID', 'Awesome_Name', $this->RenderText('%Office_ID% - (%Awesome_Name%, %MapCoordinate%)'), 20);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Province field
            //
            $column = new TextViewColumn('Province', 'Province', 'Province', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Province_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Street field
            //
            $column = new TextViewColumn('Street', 'Street', 'Street', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Street_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Address field
            //
            $column = new TextViewColumn('Address', 'Address', 'Address', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'inventory_locationGrid_Address_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`inventory_location`');
            $field = new IntegerField('ID', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new IntegerField('Parent_Location');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Nearest_Office');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Location_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Location_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Parent_Location_Location_Name_search', 'ID', 'Location_Name', $this->RenderText('%Location_Name% - (%ID% , %MapCoordinate%)'), 20);
            GetApplication()->RegisterHTTPHandler($handler);$lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`office`');
            $field = new StringField('Office_ID');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Awesome_Name');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $field = new StringField('ZIP');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Province');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Region');
            $lookupDataset->AddField($field, false);
            $field = new StringField('City');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Street');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Address');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 1');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Phone 2');
            $lookupDataset->AddField($field, false);
            $field = new StringField('MapCoordinate');
            $lookupDataset->AddField($field, false);
            $lookupDataset->setOrderByField('Awesome_Name', GetOrderTypeAsSQL(otAscending));
            $lookupDataset->AddCustomCondition(EnvVariablesUtils::EvaluateVariableTemplate($this->GetColumnVariableContainer(), ''));
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_Nearest_Office_Awesome_Name_search', 'Office_ID', 'Awesome_Name', $this->RenderText('%Office_ID% - (%Awesome_Name%, %MapCoordinate%)'), 20);
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
        $Page = new inventory_locationPage("inventory_location", "inventory_location.php", GetCurrentUserPermissionSetForDataSource("inventory_location"), 'UTF-8');
        $Page->SetTitle('Inventory Location');
        $Page->SetMenuLabel('Inventory Location');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("inventory_location"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
