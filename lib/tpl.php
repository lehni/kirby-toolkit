<?php

/**
 * Tpl
 *
 * Super simple template engine
 *
 * @package   Kirby Toolkit
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Support for multiple template engines based on:
 * https://github.com/lehni/kirbycms by Juerg Lehni <juerg@scratchdisk.com>
 * Ported to Kirby 2 by Leo Koppelkamm <hello@leo-koppelkamm.de>
 */
class Tpl extends Silo {

  public static $data = array();

  public static function load($_file, $_data = array(), $_return = true) {
    if(!file_exists($_file)) return false;
    $_extension = pathinfo($_file, PATHINFO_EXTENSION);
    $_engines = c::get('tpl.engines');
    
    if (isset($_engines[$_extension])) {
      $_engine = $_engines[$_extension];
      $_file = $_engine($_file);
    }

    return self::loadFile($_file, $_data, $_return);
  }

  static public function loadFile($_file, $_data = array(), $_return = true) {
    if(!file_exists($_file)) return false;
    ob_start();
    extract(array_merge(static::$data, (array)$_data));
    require($_file);
    $_content = ob_get_contents();
    ob_end_clean();
    if($_return) return $_content;
    echo $_content;
  }

}