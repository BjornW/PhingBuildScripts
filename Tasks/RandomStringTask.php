<?php

require_once "phing/Task.php";

/**
 * RandomString is a custom task for creating strings of a specified length 
 * with random ascii characters.
 *
 * Usage  
 * Use the code below to create a random string. The attributes are: 
 *
 * - length      = string length defaults to 32 characters. 
 * 
 * - ascii_start = start ascii character number. Sets the start of the range of
 *                 ascii characters to choose from. Defaults to 33
 * 
 * - ascii_stop  = stop ascii character number. Sets the ending of the range of
 *                 ascii characters to choose from. Defaults to 126                   
 * 
 * - exclude     = comma seperated list of ascii character numbers which may not
 *                 be used. Defaults to '34 , 39, 96' also known as double quote, 
 *                 single quote and apastroph
 *  
 * For more information on the ascii numbers and the corresponding characters
 * See @link http://www.asciitable.com                  
 *
 * <code>
 * <randomstring propertyName="random_string_result"
 *                        length="2"
 *                        ascii_start="33"
 *                        ascii_stop="126"
 *                        exclude="34, 39, 96"
 *                        />
 * </code>
 * 
 * See also the included phing buildscript 
 * @example TestRandomString.xml
 *
 * @author    Bjorn Wijers <burobjorn@burobjorn.nl>
 * @link      https://github.com/BjornW/PhingBuildScripts 
 */
class RandomStringTask extends Task {

  /**
   * The length of the random string
   */
  private $length = 32;

  /** 
   * The ASCII range start character number for the characters 
   * used in the string
   */
  private $ascii_start = 33;

  /** 
   * The ASCII range end character number for the characters 
   * used in the string
   */
  private $ascii_stop = 126;

  /**
   * Set the return value to this property
   */
  private $propertyName = null;

  /** 
   * Exclude these comma seperated ascii numbers by default
   * by default exclude: double quote, single quote and apastroph
   */
  private $exclude = "34, 39, 96";


  /**
   * The setter for the attribute "length"
   */
  public function setLength($length) 
  {
    $this->length = (int) $length; 
  }

  /**
   * The setter for the attribute "ascii_start"
   */
  public function setAscii_Start($ascii_start) 
  {
    $this->ascii_start = (int) $ascii_start; 
  }

  /**
   * The setter for the attribute "ascii_stop"
   */
  public function setAscii_Stop($ascii_stop) 
  {
    $this->ascii_stop = (int) $ascii_stop; 
  }

  /**
   * The setter for the attribute "exclude"
   */
  public function setExclude($exclude) 
  {
    $this->exclude = $exclude; 
  }

  /**
   * The setter for the attribute "propertyName"
   */
  public function setPropertyName($propertyName) 
  {
    $this->propertyName = $propertyName; 
  }

  /**
   * The getter for the attribute "propertyName"
   */
  public function getPropertyName() {
    return $this->propertyName;  
  }

  
  /**
   * The init method: Do init steps.
   */
  public function init() 
  {
    // nothing to do here
  }

  /**
   * The main entry point method.
   *
   * @access public
   */
  public function main() 
  {
    if ( $this->propertyName === null) {
      throw new BuildException("You must specify a value for propertyName attribute.");
    }

    // prevent non printable characters from selecting
    if( $this->ascii_start < (int) 33) {
      throw new BuildException("The ascii_start property value needs a value bigger than 33");
    }  
      
    if( $this->ascii_stop > (int) 126) {
      throw new BuildException("The ascii_stop property value needs a value smaller than 126");
    }

    // returns the random string to the phing build script
    $this->project->setUserProperty( $this->getPropertyName(), $this->randomString()); 
  }

  /**
   * Retrieves and processes the ascii numbers which should not be used
   *
   * @access private
   * @return array integers of Ascii character numbers to exclude 
   */
  private function getExcludedAsciiNumbers() 
  {
    $excluded = explode(',', $this->exclude);
    if( is_array($excluded) ) {
      array_walk( 
        $excluded, 
        function(&$value, $key) { $value = trim($value); $value = (int)$value; } 
      );
    }      
    return $excluded;
  }


  /** 
   * Generate a string of a given length with random characters in the ASCII
   * range given See for instance http://www.asciitable.com/
   *
   * @access private
   * @return string random characters
   */ 
  private function randomString() 
  {
    $str = '';
    
    for( $i = 0; $i < $this->length; $i++) {
      $ascii_nr = $this->randomNumber(); 
      $str .= chr( $ascii_nr );
    }
    return (string) $str;
  }

  
  /** 
   * Generate a random number between the 
   * $ascii_start and $ascii_top values and prevents using
   * an excluded number
   *
   * @access private
   * @return int random number from selected range
   */ 
  function randomNumber( $ascii_nr = null ) 
  {
    $excluded = $this->getExcludedAsciiNumbers();
    
    if( ( ! is_null($ascii_nr) ) &&  ( ! in_array($ascii_nr, $excluded) ) ) {
      return $ascii_nr;
    }   
    
    $ascii_nr = mt_rand( $this->ascii_start, $this->ascii_stop );
    return $this->randomNumber( $ascii_nr ); 
    
  }
}
?>
