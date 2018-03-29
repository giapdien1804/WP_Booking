<?php

/**
 * Created by giapdien.
 * User: giapdien
 * email: giapdien1804@gmail.com | traihogiap@hotmail.com
 * Date: 27/04/2016
 * Time: 8:18 SA
 */
class TablePriceFieldType extends AdminPageFramework_FieldType
{
    public $aFieldTypeSlugs = array('table_price');
    public $dval;
    public $dname;

    protected $aDefaultKeys = array(
        'attributes' => array(),
        'options' => array(),
        'number_col' => null,
        'extra' => array()
    );

    public function setUp()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
    }

    protected function getEnqueuingScripts()
    {
        return array();
    }

    protected function getEnqueuingStyles()
    {
        return array();
    }

    protected function getScripts()
    {
        return "
       jQuery(document).ready(function ($) {
          $('body').on('focus', '.gds_date_pick', function () {
            $(this).datepicker({
                showOn: 'button',
                buttonText: 'Choose',
                buttonImageOnly: false,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm/dd/yy'
            });
          });
        }
    );
        ";
    }

    protected function getStyles()
    {
        return "
            .ui-datepicker .ui-datepicker-calendar td a,.ui-datepicker a,.ui-datepicker a:hover{text-decoration:none}.price-pax{width:100%;max-width:100%;border:1px solid #9e9e9e;border-collapse:collapse}.price-pax td,.price-pax th{border:1px dashed #9e9e9e;padding:2px;vertical-align:middle}.price-pax th{width:70px}.price-pax input[type=text]{-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none}.table-option,.table-option input[type=text]{width:100%;max-width:100%}.ui-datepicker{background-color:#fff;border:1px solid #66AFE9;border-radius:4px;box-shadow:0 0 8px rgba(102,175,233,.6);display:none;margin-top:4px;padding:10px;width:240px}.ui-datepicker a:hover,.ui-datepicker td:hover a{color:#2A6496;-webkit-transition:color .1s ease-in-out;-moz-transition:color .1s ease-in-out;-o-transition:color .1s ease-in-out;transition:color .1s ease-in-out}.ui-datepicker .ui-datepicker-header{margin-bottom:4px;text-align:center}.ui-datepicker .ui-datepicker-title{font-weight:700}.ui-datepicker .ui-datepicker-next,.ui-datepicker .ui-datepicker-prev{cursor:default;-webkit-font-smoothing:antialiased;font-style:normal;font-weight:400;height:20px;line-height:1;margin-top:2px;width:30px}.ui-datepicker .ui-datepicker-prev{float:left;text-align:left}.ui-datepicker .ui-datepicker-next{float:right;text-align:right}.ui-datepicker .ui-datepicker-prev:before{content:\"Prev\"}.ui-datepicker .ui-datepicker-next:before{content:\"Next\"}.ui-datepicker .ui-icon{display:none}.ui-datepicker .ui-datepicker-calendar{table-layout:fixed;width:100%}.ui-datepicker .ui-datepicker-calendar td,.ui-datepicker .ui-datepicker-calendar th{text-align:center;padding:4px 0}.ui-datepicker .ui-datepicker-calendar td{border-radius:4px;-webkit-transition:background-color .1s ease-in-out,color .1s ease-in-out;-moz-transition:background-color .1s ease-in-out,color .1s ease-in-out;-o-transition:background-color .1s ease-in-out,color .1s ease-in-out;transition:background-color .1s ease-in-out,color .1s ease-in-out}.ui-datepicker .ui-datepicker-calendar td:hover{background-color:#eee;cursor:pointer}.ui-datepicker .ui-datepicker-current-day,.ui-datepicker-today{background-color:#4289cc}.ui-datepicker .ui-datepicker-current-day a{color:#fff}.ui-datepicker .ui-datepicker-calendar .ui-datepicker-unselectable:hover{background-color:#fff;cursor:default}.admin-page-framework-field-table_price{margin-bottom: 10px!important;}"
            . PHP_EOL;
    }

    private function get_attr($name, $index = -1)
    {

        $value = '';
        if (isset($this->dval[$name])) {
            if (is_array($this->dval[$name])) {
                $value = $this->dval[$name][$index];
            } else {
                $value = $this->dval[$name];
            }
        }

        $_name = ($index >= 0) ? sprintf("%s[%s][%s]", $this->dname, $name, $index) : sprintf("%s[%s]", $this->dname, $name);

        return sprintf('id="%s" name="%s" value="%s"', $_name, $_name, $value);
    }

    private function render_input($name, $number = 10)
    {
        $str = '';
        for ($i = 0; $i < $number; $i++) {
            $str .= "<td><input type=\"text\" {$this->get_attr($name,$i)} title=\"Quantity\"> </td>";
        }

        return $str;
    }

    private function _input($name, $title, $cssClass)
    {
        $str = "<td><input class=\"{$cssClass}\" type=\"text\" {$this->get_attr($name)} title=\"{$title}\"> </td>";
        return $str;
    }

    public function getField($aField)
    {
        $aInputAttributes = array();
        foreach ($aField['options'] as $key => $value) {
            if (false === $value) {
                $value = 0;
            }
            $aInputAttributes['data-table_price_' . $key] = $value;
        }
        unset($aField['attributes']['value']);
        $aInputAttributes = array_merge($aInputAttributes, $aField['attributes']);

        $this->dname = $aInputAttributes['name'];
        $this->dval = $aField['value'];

        $str_extra = '';

        foreach ($aField['extra'] as $field_name => $field_option) {
            $str_extra .= '<tr>
				<td><label>' . $field_option['title'] . '</label></td>'
                . $this->_input($field_name, $field_option['title'], $field_option['css']) .
                '</tr>';
        }

        $str =
            $aField['before_label'] . $aField['before_input'] . '
		<table class="table-option"' . $this->generateAttributes($aInputAttributes) . '>'
            . $str_extra .
            '<tr>
				<td colspan="2">
					<table class="price-pax">
						<tr>
							<th>Title</th>
	                        ' . $this->render_input('qty', $aField['number_col']) . '
						</tr>
						<tr>
							<th>Value</th>
							' . $this->render_input('pax', $aField['number_col']) . '
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div class=\'repeatable-field-buttons\'></div>
		' .
            $aField['after_input'] . $aField['after_label'];

        return $str;
    }
}

?>