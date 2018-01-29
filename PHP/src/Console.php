<?php
/**
 *  @description - singleton to print to the terminal, 
 *  formats output by given format tags
 */

define('ESC_CLEAR_SCREEN',"\x1bc");

class Console {

    /**
     *  @description - terminal format options and tag descriptions table
     */
    private static $term_styles = ['</end>' => "\x1b[0m",
    '<Bright>' => "\x1b[1m",
    '<Dim>' => "\x1b[2m",
    '<Underscore>' => "\x1b[4m",
    '<Blink>' => "\x1b[5m",
    '<Reverse>' => "\x1b[7m",
    '<Hidden>' => "\x1b[8m",
    
    '<FgBlack>' => "\x1b[30m",
    '<FgRed>' => "\x1b[31m",
    '<FgGreen>' => "\x1b[32m",
    '<FgYellow>' => "\x1b[33m",
    '<FgBlue>' => "\x1b[34m",
    '<FgMagenta>' => "\x1b[35m",
    '<FgCyan>' => "\x1b[36m",
    '<FgWhite>' => "\x1b[37m",

    '<FgBBlack>' => "\x1b[90m",
    '<FgBRed>' => "\x1b[91m",
    '<FgBGreen>' => "\x1b[92m",
    '<FgBYellow>' => "\x1b[93m",
    '<FgBBlue>' => "\x1b[94m",
    '<FgBMagenta>' => "\x1b[95m",
    '<FgBCyan>' => "\x1b[96m",
    '<FgBWhite>' => "\x1b[97m",
    
    '<BgBlack>' => "\x1b[40m",
    '<BgRed>' => "\x1b[41m",
    '<BgGreen>' => "\x1b[42m",
    '<BgYellow>' => "\x1b[43m",
    '<BgBlue>' => "\x1b[44m",
    '<BgMagenta>' => "\x1b[45m",
    '<BgCyan>' => "\x1b[46m",
    '<BgWhite>' => "\x1b[47m",

    '<BgBBlack>' => "\x1b[100m",
    '<BgBRed>' => "\x1b[101m",
    '<BgBGreen>' => "\x1b[102m",
    '<BgBYellow>' => "\x1b[103m",
    '<BgBBlue>' => "\x1b[104m",
    '<BgBMagenta>' => "\x1b[45m",
    '<BgBCyan>' => "\x1b[106m",
    '<BgBWhite>' => "\x1b[107m"];


    /**
     *  @description - standart log
     */
    public static function log( $a, $b=''){
    
        if(array_search('-v',$_SERVER['argv'])!==false){
            if($b===''){
                print_r(self::getTimeStamp ().' '.self::formater($a));
                echo "\n";
            }else{
                print_r(self::getTimeStamp ().' '.self::formater($a));
                print_r(self::formater($b));
                echo "\n";
            }
        }
    }

    /**
     *  @description - error log
     */
    public static function error( $a, $b=''){
    
        if(array_search('-v',$_SERVER['argv'])!==false){
            if($b===''){
                print_r(self::getTimeStamp ().self::formater(' <FgRed><Bright>Error</end> <FgRed>'.$a.'</end>'));
                echo "\n";
            }else{
                print_r(self::getTimeStamp ().self::formater(' <FgRed><Bright>'.$a.'</end>'));
                print_r(self::formater(' <FgRed>'.$b.'</end>'));
                echo "\n";
            }
        }
    }

    /**
     *  @description - log without timestamp
     */
    public static function nolog ($a,$b='') {
        if($b===''){
            print_r(self::formater($a));
            echo "\n";
        }else{
            print_r(self::formater($a));
            print_r(self::formater($b));
            echo "\n";
        }
    }

    private function getTimeStamp () {
        date_default_timezone_set('UTC');
        return '['.date(DATE_RFC822).']';
    }

    private function formater ( $s ) {
        if(is_string($s)){
            $s = str_replace(array_keys(self::$term_styles),array_values(self::$term_styles),$s);
        }
        return $s;
    }

    
}
?>