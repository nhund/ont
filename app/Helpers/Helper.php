<?php

namespace App\Helpers;

use App\Models\WalletLog;
use Image;

class Helper
{
    protected static $_sizes = array(
        'l' => 192,
        'm' => 96,
        's' => 48
    );
    public static function walletLog($data, $user)
    {        
        $log = new WalletLog();       
        $log->user_id = $user->id;
        $log->type = $data['type'];
        $log->xu_current = $data['xu_current'];
        $log->xu_change = $data['xu_change'];
        $log->note = $data['note'];
        $log->created_at = time();
        $log->save();
    }
    public static function thumbImages($name,$url, $size_w, $size_h, $type = 'fit',$path_store)
    {

        if (!file_exists($path_store)) {
            mkdir($path_store, 0777);
        }
        $img = Image::make($url);
        if($type == 'fit')
        {
            $img->fit($size_w, $size_h);
        }
        //dd($path_store.''.$name);
        $img->save($path_store.'/'.$name);
        return true;
    }
    public static function removeFolder($str)
    {
        if (is_file($str)) {
            //Attempt to delete it.
            return unlink($str);
        }
        //If it's a directory.
        elseif (is_dir($str)) {
            //Get a list of the files in this directory.
            $scan = glob(rtrim($str,'/').'/*');
            //Loop through the list of files.
            foreach($scan as $index=>$path) {
                //Call our recursive function.
                self::removeFolder($path);
            }
            //Remove the directory itself.
            return @rmdir($str);
        }
    }
    public static function detectMathLatex($text,$type = '')
    {
        if($type == 'doan_van')
        {
            if (strpos($text, '$') !== false)
            {
                $pattern = '/\\$(.*?)\\$/';
                        $content = preg_replace_callback($pattern, function($m){
                            return "<span class='math-tex'>\($m[1]\)</span>";
                        },$text);
                $text = $content;        
            }
        }else{
            if (strpos($text, '$') !== false)
            {
                $pattern = '/\\$(.*?)\\$/';
                        $content = preg_replace_callback($pattern, function($m){
                            return '<span class="math-tex">\('.$m[1].'\)</span>';
                        },$text);
                $text = $content;        
            }
        }        
        return $text;
    }
    public static function exportMathLatex($text)
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

    /**
     * Safely decode a given JSON string.
     *
     * @param  string|mixed $payload
     * @param  \Exception|null $e
     * @param  bool $associative
     * @return array|\stdClass
     * @throws \Exception
     */
    public static function decode_json_payload($payload, $e = null, $associative = true)
    {
        if (empty($payload) || !is_string($payload)) {
            if (is_null($e)) {
                return [];
            }

            throw $e;
        }

        $value = json_decode($payload, $associative);

        if (is_null($value) || json_last_error() !== JSON_ERROR_NONE) {
            if (is_null($e)) {
                return [];
            }

            logger()->error(json_last_error_msg());

            throw $e;
        }

        return $value;
    }
}
