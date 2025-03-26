<?php

use Random\RandomException;

/**
 * Class responsible for generating and managing a collection of image files
 * from a URL (https://picsum.photos/<width>/<height>) providing a free random JPG image.
 */
class ImagesGenerator
{
    private string $url = 'https://picsum.photos/';
    private int $min;
    private int $max;
    private string $savePath;
    private int $count;

    /**
     * @var array<int, string>
     */
    private array $images = [];
    private string $imagePrefix;

    public function __construct(
        string $savePath,
        int $min = 300,
        int $max = 600,
        int $count = 10,
        string $imagePrefix  = 'image_'
    )
    {
        $this->savePath = $savePath;
        $this->min = $min;
        $this->max = $max;
        $this->count = $count;
        $this->imagePrefix = $imagePrefix;
    }

    /**
     * Generates a collection of images depending on $this->>count property.
     *
     * @return ImagesGenerator instance
     * @throws RandomException
     */
    public function generate(): static
    {
        for ($i = 0; $i < $this->count; $i++) {
            $image = $this->generateImage();
            if ($image) {
                $this->images[] = [
                    'full_path' => $this->savePath . $image,
                    'name' => $image,
                ];
            }
        }

        return $this;
    }

    /**
     * Provide an array of generated images
     *
     * @return array<int, string>
     */
    public function getList(): array
    {
        return $this->images;
    }

    /**
     * Generate an image and store its details.
     *
     * @return false|string
     * @throws RandomException
     */
    private function generateImage(): false|string
    {
        $imageUrl = $this->url.'/'.random_int($this->min, $this->max).'/'.random_int($this->min, $this->max);

        if (!file_exists($this->savePath)) {
            mkdir($this->savePath, 0777, true);
        }

        $filename = uniqid($this->imagePrefix) . '.jpg';
        $filePath = $this->savePath . $filename;
        $imageData = file_get_contents($imageUrl);

        if ($imageData !== false) {
            file_put_contents($filePath, $imageData);
            $split = explode('/', $filePath);
            return  end($split);
        }

        return false;
    }
}
