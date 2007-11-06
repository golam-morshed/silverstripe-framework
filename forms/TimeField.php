<?php
/**
 * Date field.
 * Default Value represented in the format passed as constructor.
 * 
 * @param name - The name of the field
 * @param title - The Title of the field
 * @param value - the value for the field
 * @param format - The Time format in date php format e.g. G:ia
 */
class TimeField extends TextField {
	// Stores our time format;
	protected $timeformat;
	
	/**
	 * Constructor saves the format difference. Timefields shouldn't 
	 * have a problem with length as times can only be represented in on way.
	 */
	function __construct($name, $title = null, $value = "",$timeformat = "g:ia"){
		parent::__construct($name,$title,$value);
		$this->timeformat = $timeformat;
	}
	
	/**
	 * Change the setValue to store the time (in a datetime field)
	 * we store the current date as well (although we don't use it for this field)
	 */
	function setValue( $val ) {
		if( $val )
			$this->value = (date("Y-m-d",time()) . " " . date("H:i",strtotime($val)) );
		else
			$this->value = null;
	}
	
	/**
	 * Creates a new readonly field specified below
	 */
	function performReadonlyTransformation() {
		return new TimeField_Readonly( $this->name, $this->title, $this->dataValue(),$this->timeformat);
	}
	
	/**
	 * Added to the value of the input, put the date into the format
	 * specified in the constructer.
	 */
	function attrValue(){
		if($this->value){
			return date($this->timeformat,strtotime($this->value));	
		}else{
			return "";
		}
	}
	
}

/**
 * The readonly class for our TimeField
 */
class TimeField_Readonly extends TimeField {
	
	function Field() {
		if( $this->value )
			$val = $this->attrValue();
		else
			$val = '<i>(not set)</i>';
		
		return "<span class=\"readonly\" id=\"" . $this->id() . "\">$val</span>";
	}
}