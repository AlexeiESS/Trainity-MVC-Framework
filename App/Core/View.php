<?php

namespace App\Core;
if(!defined(SECURITY)){exit();}
class View 
{
    var $manuale = array();
    var $width = '100';
    var $unmanule = array();
    var $set_template;
	
    function __construct($temp='public/')
    {
        $this->set_template = $temp;
    }

    function create($tpl, $path='public/')
    {
        global $setting;
        if (in_array($tpl,$this->manuale)) {
            $contents = $manuale[$tpl];
        } else {
            $contents = @file_get_contents($path.$tpl.'.tpl');
            $mtpl = str_replace('/','_',$tpl);
            $this->manuale[$mtpl] = $contents;
        }
        return (empty($contents)) ? '0' : $contents;
    }

    function block($tpl)
    {
        if (in_array($tpl,$this->manuale)) {
            $contents = $manuale[$tpl];
        } else {
            $contents = @file_get_contents(TMP.$tpl.".tpl");
            $mtpl = str_replace('/','_',$tpl);
            $this->manuale[$mtpl] = $contents;
        }
        return (empty($contents)) ? '<strong>'.$tpl.'.tpl</strong> Not found !<br />' : $contents;
    }

    function parse($carray, $contents)
    {
        global $lang;
        $newkey = $newval = array();
        foreach ($carray as $key => $value) {
            $newkey[$key] = '{'.$key.'}';
            $newval[$key] = $value;
        }
        return str_replace($newkey,$newval,$contents);
    }

    function parseprint($carray, $contents)
    {
        global $lang;
        $newkey = $newval = array();
        foreach ($carray as $key => $value) {
        	$newkey[$key] = '{'.$key.'}';
        	$newval[$key] = $value;
        }
        echo str_replace($newkey,$newval,$contents);
    }
	
    function parsein($content)
    {
        if ($count = preg_match_all('#<\!--(if|buffer|add):([a-zA-Z0-9_]*):([a-zA-Z0-9_]*)-->(.*?)<\!--(if|buffer|add)-->#is', $content, $attribut)) {
            for ($i = 0; $i < $count; $i++) {
                 $tags = $attribut[1][$i];
                 $pers = $attribut[2][$i];
                 $vals = $attribut[3][$i];
                 if ($tags == 'if') {
                     if (isset($this->unmanule[$pers])) {
                         if ($this->unmanule[$pers] == $vals) {
                             $content = str_replace('<!--'.$tags.':'.$pers.':'.$vals.'-->','',$content);
                        } else {
                             $content = str_replace('<!--'.$tags.':'.$pers.':'.$vals.'-->'.$attribut[4][$i].'<!--'.$tags.'-->','',$content);
                        }
                     }
                 }
                 if ($tags == 'buffer') {
                     $this->manuale[$pers] = $attribut[4][$i];
                     $content = str_replace('<!--'.$tags.':'.$pers.':'.$vals.'-->'.$attribut[4][$i].'<!--'.$tags.'-->','',$content);
                 }
                 if ($tags == 'add') {
                     if (isset($attribut[4][$i]) && !empty($attribut[4][$i])) {
                         $add = @file_get_contents($attribut[4][$i]);
                         $content = str_replace('<!--'.$tags.':'.$pers.':'.$vals.'-->'.$attribut[4][$i].'<!--'.$tags.'-->',$add,$content);
                     }
                 }
            }
        }
        return str_replace('<!--if-->','',$content);
    }
}

?>
