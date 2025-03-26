# ImagesGenerator

Can generate random sized images in JPG format, store them in folder and return an array of **full_path** and **name** details.

---

*Example:*
```php
<?php

require __DIR__ . '/ImagesGenerator.php';

// Create instance and set parameters
$generator = new ImagesGenerator(
    savePath: __DIR__ . '/images_folder/',
    count: 10,
    imagePrefix: 'genius.',
);

// Get a list of generated images
$list = $generator->generate()->getList();

// Dump the list
print_r($list);
```
