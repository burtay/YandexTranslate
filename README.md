# Yandex Translate API
###Simple Usage
```php
require("class.yandexTranslate.php");
/* Instance */
$yt = new YandexTranslate();

/* Set Api Key */
$yt->setApiKey('YOUR_API_KEY');

/*Optinal*/
$yt->dedectSource("Your String");

/* If you dont use  above optinal method this method is necessary */
$yt->setTranslateLangs("en-tr");	

/* Translate it */
$yt->translate(array("Your String Part 1","Your String Part 2"));
```

