<?php 
    namespace App\Services;

    use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

    /**

 * Class inlineEmail
 * 
 * Returns rendered Email view with inlined CSS
 * @package App\Library
 */
class CssInlineStyleService {   
    private $view;    
    private $data;

    /**
     * @param string $view Filename/path of view to render
     * @param array $data Data of email
     */
    public function __construct()
    {
        
    }

    public function set($view, array $data) {
        // Render the email view
        $emailView = view($view, $data)->render();
        $this->view = $emailView;
        $this->data = $data;
    }

    /**
     * Convert to inlined CSS
     * 
     * @return string
     * @throws \TijsVerkoyen\CssToInlineStyles\Exception
     */
    public function convert()
    {
        $converter = new CssToInlineStyles();        
        $content =  $converter->convert($this->view);
        return $content;
    }

}