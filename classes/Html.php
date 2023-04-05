<?php
declare (strict_types = 1);
/**
 * Description of Html
 *
 * @author ryszard
 */
class Html {
    
    public static function initialHtmlCode() : void {
        echo '<html>'
            . '<head>'
                . '<meta charset="utf-8">'
                . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
                . '<title>Currency rate service</title>'
                .'<link rel="stylesheet" href="CSS/style.css">'
            .'</head>'
            .'<body><div class="content-box">';
    }
    
    public static function finalHtmlCode() : void {
        echo '</div></body></html>';
    }

    public static function htmlForDisplayChart(string $chart) : void {
        echo '<div><img src="' . $chart . '" alt="chart" width="100%" ></div>';
    }
    
    public static function htmlForFooter() : void {
        echo '<p class="footer-box">&copy; Copyright 2023</p>';
    }
}