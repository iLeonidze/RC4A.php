# RC4A.js v0.1.2
[NodeJS/JavaScript](https://github.com/iLeonidze/RC4A.js) implementation of simple and powerfull string encryption/decryption with the password & UTF-8 support.
You can encrypt string in the browser and decrypt it on the PHP-server. Or encrypt on the PHP-server and decrypt in browser.

###[Go to RC4A for JavaScript/NodeJS on GitHub](https://github.com/iLeonidze/RC4A.js)

No dependecies! No OpenSSL required. Javascript, NodeJS, PHP compatible.

## How to use in project
```php
include_once("rc4a.php");
$rc4a = new rc4a;
```

## Encryption
```php
$text = "Lorem ipsum 123 ёюйяъэ !№;%:?*()";
$password = "supёrP@$$w0rd";
$secret = $rc4a->encrypt($text,$password);
echo $secret; // Will output something like this: ]êòd»÷[c #hümZºí¤xì/S-ѲѩҴӷдӂp±⅁ÑD_»¼ú{
```

## Decryption
```php
$decryptedText = $rc4a->decrypt($secret,$password);
echo $decryptedText; // Will output: Lorem ipsum 123 ёюйяъэ !№;%:?*()
```

## Encryption with the custom salt
RC4A.js automatically generate random salt via rand(). Salt size is dynamic - from 16 up to 128. If you do not trust, you can use your own salt up to 9999-size length. Just specify it: 
```php
$customSalt = "397ba6e0085f182db7ee7f6e3515530d";
$secret = $rc4a->encrypt($text,$password,$customSalt);
```
And that's it. You don't have to pass salt for the decryption.

## Error catching
Do not forget about damaged data. Test your code like this:
```php
$text = "Lorem ipsum 123 ёюйяъэ !№;%:?*()";
$password = "supёrP@$$w0rd";
$secret = substr($rc4a->encrypt($text,$password),4); // let's damage this encrypted content
try{
  $decryptedText = $rc4a->decrypt($secret,$password); // here you will get an error
  echo "Successfully decrypted! Decrypted text:".$decryptedText);
}catch(Exception $e){
  echo "Can\'t decrypt your data.";
}
```

## TODO:
- Beatiful Threw Error
- Add streams
