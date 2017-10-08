<?php 
     
    /** 
     * Description of SmallGoogleTranslator 
     *  
     *  This Class uses Google Translate to translate text from 
     *  one language to another. Upon success it returns the 
     *  translation using UTF-8 to enable accented and other 
     *  characters. On failure it returns 'FALSE'. It requires these 
     *  arguments: 
     
     *    $txtToTranslate        :     Text to translate 
     *    $translateFromLanguage:     The source language 
     *    $translateToLanguage    :     The destination language 
     *   
     *   $translateFromLanguage and $translateToLanguage must each be one of: Arabic, Bulgarian, 
     *   Simplified Chinese, Traditional Chinese, Croatian, Czech, 
     *   Danish, Dutch, English, Finnish, French, German, Greek, 
     *   Hindi, Italian, Japanese, Korean, Polish, Portuguese, 
     *   Romanian, Russian, Spanish or Swedish. 
     * 
     * This is a simple class to translate text using google translate, can be modified and redistributed, 
     */ 
    class SmallGoogleTranslator{ 
        public    $result;      
        
        /** 
         * This is the constructor function, it initializes the SmallGoogleTranslator Class. 
         *  
         * @param (String) $txtToTranslate - [Text to translate.] 
         * @param (String) $translateFromLanguage - [The source language] 
         * @param (String) $translateToLanguage - [The destination language] 
         *  
         */ 
        public function __construct($txtToTranslate,$translateFromLanguage,$translateToLanguage){ 
            $this->result = $this->_GoogleTranslate($txtToTranslate,$translateFromLanguage,$translateToLanguage);
        } 
        
        /** 
         * Private Function, The Core of the class used for calling translator engine. 
         *  
         * @param (String) $txtToTranslate - > $text. 
         * @param (String) $translateFromLanguage - > $lang1. 
         * @param (String) $translateToLanguage - > $lang2. 
         *  
         * @return boolean 
         */ 
        private function _GoogleTranslate($text, $lang1, $lang2) 
        { 
           /** 
            * The List Of Language Supported by Google Translate. 
            */ 
           $langs = array( 
              'arabic'              => 'ar', 
              'bulgarian'           => 'bg', 
              'simplified chinese'  => 'zh-cn', 
              'traditional chinese' => 'zh-tw', 
              'croatian'            => 'hr', 
              'czech'               => 'cs', 
              'danish'              => 'da', 
              'dutch'               => 'nl', 
              'english'             => 'en', 
              'finnish'             => 'fi', 
              'french'              => 'fr', 
              'german'              => 'de', 
              'greek'               => 'el', 
              'hindi'               => 'hi', 
              'italian'             => 'it', 
              'japanese'            => 'ja', 
              'korean'              => 'ko', 
              'polish'              => 'pl', 
              'portuguese'          => 'pt', 
              'romanian'            => 'ro', 
              'russian'             => 'ru', 
              'spanish'             => 'es', 
              'swedish'             => 'sv'); 
        
            
           $lang1 = strtolower($lang1); 
           $lang2 = strtolower($lang2); 
            
           /* The Root URL to Google Translator.*/ 
           $root  = 'http://ajax.googleapis.com/ajax/services'; 
            
           /* Additional Controls to be provided for the Google Translator. */ 
           $url   = $root . '/language/translate?v=1.0&q='; 
           
           /* CheckIf The Language Selected is supported by Google Translator. */ 
           if (!isset($langs[$lang1]) || !isset($langs[$lang2])){ 
                return 'Sorry Your Selection of Languages is Incorrect.'; 
           } 
        
           /* Call the Google Translator Engine with necessary parameters */ 
           $json = @file_get_contents($url . urlencode($text) . 
                   '&langpair='. $langs[$lang1] . '%7C' . 
                   $langs[$lang2]); 
            
           /* If nothing returned from google, return the message. */ 
           if (!strlen($json)) { 
                   return FALSE; 
           } 
           
           $this->result = json_decode($json); 
           return $this->result->responseData->translatedText; 
         } 
   
        /** 
         * This function returns the translated return in text form. 
         * @return (String) 
         */ 
        public function __toString(){ 
            return $this->result; 

        } 
    } 
?>