<?php
if(isset($_COOKIE['dev']) && $_COOKIE['dev'] == 1) {
    add_action('wp_footer', 'bb_dev');
    if(!function_exists('bb_dev')) {
        function bb_dev(){
            if(isset($_COOKIE['sync']) && $_COOKIE['sync'] != '') {
                echo '<script id="__bs_script__">//<![CDATA[
                        document.write("<script async src=\''.$_COOKIE['sync'].'\'><\/script>".replace("HOST", location.hostname));
                    //]]></script>';
            } else {
                echo '<script id="__bs_script__">//<![CDATA[
                    document.write("<script async src=\'http://HOST:'.(isset($_COOKIE['port'])?$_COOKIE['port']:'3000').'/browser-sync/browser-sync-client.'.(isset($_COOKIE['version'])?$_COOKIE['version']:'2.14.0').'.js\'><\/script>".replace("HOST", location.hostname));
                //]]></script>';
            }
        }
    }
    add_action('admin_footer', 'bb_dev');
    if(!function_exists('bb_dev')) {
        function bb_dev(){
            if(isset($_COOKIE['sync']) && $_COOKIE['sync'] != '') {
                echo '<script id="__bs_script__">//<![CDATA[
                        document.write("<script async src=\''.$_COOKIE['sync'].'\'><\/script>".replace("HOST", location.hostname));
                    //]]></script>';
            } else {
                echo '<script id="__bs_script__">//<![CDATA[
                    document.write("<script async src=\'http://HOST:'.(isset($_COOKIE['port'])?$_COOKIE['port']:'3000').'/browser-sync/browser-sync-client.'.(isset($_COOKIE['version'])?$_COOKIE['version']:'2.14.0').'.js\'><\/script>".replace("HOST", location.hostname));
                //]]></script>';
            }
        }
    }
}