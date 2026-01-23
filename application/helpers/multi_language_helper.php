<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/


// This function helps us to get the translated phrase from the file. If it does not exist this function will save the phrase and by default it will have the same form as given
if ( ! function_exists('get_phrase'))
{
    function get_phrase($phrase = '') {
        $CI =& get_instance();
        
        // 1. Get current language
        // We use a static variable to avoid querying the DB on every single word (Performance boost)
        static $language_code = null;
        if ($language_code === null) {
            $CI->load->database();
            $language_code = get_settings('language');
            if (!$language_code) $language_code = 'english'; // Fallback
        }

        // 2. SANITIZE THE KEY (Robust Logic)
        // Convert "L'école & Étudiants" -> "lecole_etudiants"
        
        $key = trim($phrase);
        // Multibyte lowercase (handles accents)
        $key = mb_strtolower($key, 'UTF-8'); 
        // Remove apostrophes specifically first to join words (d'écoles -> decoles)
        $key = str_replace("'", "", $key);
        // Replace spaces, hyphens, and slashes with underscores
        $key = preg_replace('/[\s\-\/]+/', '_', $key);
        // Remove all other special characters (keep only letters, numbers, and underscores)
        $key = preg_replace('/[^\w_]/u', '', $key);
        // Remove duplicate underscores
        $key = preg_replace('/_+/', '_', $key);
        // Remove leading/trailing underscores
        $key = trim($key, '_');

        // If the key becomes empty (e.g. phrase was just "???"), return original phrase
        if (empty($key)) {
            return $phrase;
        }

        // 3. Load the JSON file
        $langArray = openJSONFile($language_code);

        // Safety check: ensure we have an array
        if (!is_array($langArray)) {
            $langArray = array();
        }

        // 4. Check if key exists
        if (!array_key_exists($key, $langArray)) {
            
            // Key missing: Add it to the array using the Original Phrase as the default value
            $langArray[$key] = $phrase;

            // 5. SAVE SAFELY
            // JSON_UNESCAPED_UNICODE: Keeps Arabic/French characters readable
            // JSON_PRETTY_PRINT: Keeps the file formatted nicely
            $jsonData = json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            // Write to file WITHOUT stripslashes() to prevent data corruption
            file_put_contents(APPPATH.'language/'.$language_code.'.json', $jsonData);
        }

        // Return the translated value
        return isset($langArray[$key]) ? $langArray[$key] : $phrase;
    }
}

// This function helps us to decode the language json and return that array to us
if ( ! function_exists('openJSONFile'))
{
	function openJSONFile($code)
	{
		$jsonString = [];
		if (file_exists(APPPATH.'language/'.$code.'.json')) {
			$jsonString = file_get_contents(APPPATH.'language/'.$code.'.json');
			$jsonString = json_decode($jsonString, true);
		}
		return $jsonString;
	}
}

// This function helps us to create a new json file for new language
if ( ! function_exists('saveDefaultJSONFile'))
{
	function saveDefaultJSONFile($language_code){
		$language_code = strtolower($language_code);
		if(file_exists(APPPATH.'language/'.$language_code.'.json')){
			$newLangFile 	= APPPATH.'language/'.$language_code.'.json';
			$enLangFile   = APPPATH.'language/english.json';
			copy($enLangFile, $newLangFile);
		}else {
			$fp = fopen(APPPATH.'language/'.$language_code.'.json', 'w');
			$newLangFile = APPPATH.'language/'.$language_code.'.json';
			$enLangFile   = APPPATH.'language/english.json';
			copy($enLangFile, $newLangFile);
			fclose($fp);
		}
	}
}

// This function helps us to update a phrase inside the language file.
if ( ! function_exists('saveJSONFile'))
{
	function saveJSONFile($language_code, $updating_key, $updating_value){
		$jsonString = [];
		if(file_exists(APPPATH.'language/'.$language_code.'.json')){
			$jsonString = file_get_contents(APPPATH.'language/'.$language_code.'.json');
			$jsonString = json_decode($jsonString, true);
			$jsonString[$updating_key] = $updating_value;
		}else {
			$jsonString[$updating_key] = $updating_value;
		}
		$jsonData = json_encode($jsonString, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		file_put_contents(APPPATH.'language/'.$language_code.'.json', stripslashes($jsonData));
	}
}


// ------------------------------------------------------------------------
/* End of file language_helper.php */
