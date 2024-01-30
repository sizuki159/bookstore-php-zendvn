<?php
class Form
{
	public static function select($name, $class, $arrValue, $keySelect = 'default', $style = null)
	{
		$xhtml = '<select style="' . $style . '" name="' . $name . '" class="' . $class . '" >';
		foreach ($arrValue as $key => $value) {
			if ($key == $keySelect) {
				$xhtml .= '<option selected value = "' . $key . '">' . $value . '</option>';
			} else {
				$xhtml .= '<option value = "' . $key . '">' . $value . '</option>';
			}
		}
		$xhtml .= '</select>';
		return $xhtml;
	}

	public static function input($type, $name, $id, $value, $class = null, $attribute = null, $required = false)
	{
		$required = $required ? 'required' : '';
		$strClass = ($class == null) ? '' : 'class="' . $class . '"';
		$xhtml = '<input type="' . $type . '" name="' . $name . '" id="' . $id . '" value="' . $value . '"' . $strClass . $attribute . $required .'>';
		return $xhtml;
	}

	public static function textarea($rows = 5, $name, $value, $id, $class = null, $required = false)
	{
		$required = $required ? 'required' : '';
		$strClass = ($class == null) ? '' : 'class="' . $class . '"';
		$xhtml = '<textarea rows="'.$rows.'" name="' . $name . '" id="' . $id . '" ' . $strClass . $required .'>'.$value.'</textarea>';
		return $xhtml;
	}

	public static function formGroup($labelName, $input, $required = false)
	{
		$required = $required ? 'required' : '';
		$xhtml = '
		<div class="form-group row align-items-center">
			<label class="col-sm-2 col-form-label text-sm-right ' . $required . '">' . $labelName . '</label>
			<div class="col-xs-12 col-sm-8">
				' . $input . '
			</div>
		</div>
		';

		return $xhtml;
	}
}
