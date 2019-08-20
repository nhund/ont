<?php

if (! function_exists('web_asset')) {
    /**
     * Format text.
     *
     * @param  string  $urlString
     * @return string
     */
    function web_asset($urlString)
    {
        $v = '102';
        if(config('app.env') === 'production')
        { 
            return secure_asset($urlString). '?v='.$v;
        }else{
            return asset($urlString). '?v='.$v;
        }

    }
}

if (! function_exists('export_math_latex')) {
    /**
     * Format text.
     *
     * @param  string  $urlString
     * @return string
     */
    function export_math_latex($text)
    {
        $str = $text;
        if (strpos($str, 'class="math-tex"') !== false)
        {
            $pattern = '/<span class="math-tex">(.*?)<\/span>/';
            $content = preg_replace_callback($pattern, function($m){ 
                $math_text = '';
                if(isset($m[1]))
                {
                    $result = substr($m[1],2);
                    $result = substr($result, 0, -2);                
                    $math_text = '$'.$result.'$';
                }
                return $math_text;
            }, $str);
            $text = $content;
        }        
        return $text;
    }
}
