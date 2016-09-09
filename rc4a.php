<?php
class rc4a{
    public function arc4($string, $key){
        $s = array();
        for ($i = 0; $i < 256; $i++) {
            $s[$i] = $i;
        }
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
        }
        $i = 0;
        $j = 0;
        $res = '';
        for ($y = 0; $y < strlen($string); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
            $res .= $string[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
        }
        return $res;
    }
    private function randomString($size=16){
        $text = "";
        for ($i = 0; $i < $size; $i++) {
            $text .= mb_convert_encoding('&#'.intval(rand(32,127)).';','UTF-8','HTML-ENTITIES');
        }
        return $text;
    }
    public function encrypt($string, $key, $salt=null /*optional*/){
        if($salt==null){
            $saltSize = 16;
            $stringLength = strlen($string);
            if($stringLength>64) $saltSize = 32;
            if($stringLength>256) $saltSize = 64;
            if($stringLength>1024) $saltSize = 128;
            $salt = $this->randomString($saltSize);
        }else{
            $saltSize = strlen($salt);
        }
        $preEncodedString = "";
        if($saltSize<1000) $preEncodedString .= "0";
        if($saltSize<100) $preEncodedString .= "0";
        if($saltSize<10) $preEncodedString .= "0";
        $preEncodedString .= $saltSize;
        $preEncodedString .= $salt;
        $preEncodedString .= $this->arc4($string,$salt);
        return $this->arc4($preEncodedString,$key);
    }
    public function decrypt($string,$key){
        $preEncodedString = $this->arc4($string,$key);
        $saltSize = intval(substr($preEncodedString,0,4));
        $salt = substr($preEncodedString,4,$saltSize);
        return $this->arc4(substr($preEncodedString,4+$saltSize),$salt);
    }
}