<?php

class HtmlDocumentBody extends CrawlerBase  { 
     
    /** 
     * Document content 
     */ 
    private $content; 

    public function __construct($htmlContent = null) { 
        $this->findDocumentBody($htmlContent); 
    } 

    /** 
     * read links from content 
     */ 
    public function grabLinks() { 
         
        $links = array(); 
        $matches = array(); 
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";  
        preg_match_all("/$regexp/siU", $this->content, $matches, PREG_SET_ORDER); 
        if(!empty($matches)) { 
            foreach ($matches as $link) { 
                $links[] = new ContentLink($link); 
            } 
        } 
        return     $links;     
    } 
     
    /** 
     * find document <body> part 
     */ 
    public function findDocumentBody($content) { 
        $matches = array(); 
        preg_match('/(<body>)(.*)(<\/body>)/is', $content, $matches); 
		
		//print_r($matches);
		$this->content =  $matches[2]; 
		
    }     
     
    public function getDocumentBody() { 
        return $this->content; 
    } 
     
    public function getStrippedBody() { 
        return new StrippedBody($this->content); 
    } 
     
} 
?>