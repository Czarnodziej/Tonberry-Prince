<?php

/*
  Based on http://blog.vokiel.com/php-date-polskie-nazwy-dni-i-miesiecy-funkcje-date-strftime/
  It corrects semantics of month names displayed in Polish language.
 */

date_default_timezone_set('Europe/Warsaw');

function dateV($format, $timestamp = null) {
  $to_convert = array(// define translated data in an array
      'l' => array('dat' => 'N', 'str' => array('Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela')),
      'F' => array('dat' => 'n', 'str' => array('styczeń', 'luty', 'marzec', 'kwiecień', 'maj', 'czerwiec', 'lipiec', 'sierpień', 'wrzesień', 'październik', 'listopad', 'grudzień')),
      'f' => array('dat' => 'n', 'str' => array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'))
  );

  $pieces = preg_split('#[:/.\-, ]#', $format); // splits translated arrays

  if ($timestamp === null) {
    $timestamp = time();
  }
  foreach ($pieces as $datepart) {
    if (array_key_exists($datepart, $to_convert)) { // checks if date format is present in translated array definied above
      $replace[] = // adds translated array element
              $to_convert[$datepart]['str'][( // reference to array of weekday/months with an index of:
              date(// date in form of:
                      $to_convert[$datepart]['dat'], // array of weekday/months: N for weekdays, F/f for months (1->Monday/January)
                      $timestamp
              ) - 1)]; // because array begins at 0, not 1.
    } else {
      $replace[] = date($datepart, $timestamp); //if date format is other than specified in translated array
    }
  }
  $result = strtr($format, array_combine($pieces, $replace)); //replaces results of translations in date()
  return $result;
}

function get_page_mod_time() { //checks all website files for modification time
  $incls = get_included_files();
  $included = array_filter($incls, "is_file");
  $mod_times = array_map('filemtime', $included);
  $mod_time = max($mod_times);
  return $mod_time;
}

echo "Ostatnia aktualizacja: " . dateV("l j f Y", get_page_mod_time());
?>