<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'      => fake()->sentence(3),
            'text'       => fake()->paragraphs(3, true),
            'summary_en' => fake()->paragraph(),
            'summary_es' => fake()->paragraph(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function($card) {
            // Add a random tag
            $tags = ['Technology', 'Design', 'Business', 'Education', 'Health', 'Travel', 'Food', 'Sports'];
            $card->attachTag(fake()->randomElement($tags));

            // Generate a simple placeholder image using GD
            $width = 640;
            $height = 480;
            $image = imagecreatetruecolor($width, $height);

            // Random background color
            $bgColor = imagecolorallocate(
                $image,
                fake()->numberBetween(100, 255),
                fake()->numberBetween(100, 255),
                fake()->numberBetween(100, 255)
            );
            imagefill($image, 0, 0, $bgColor);

            // Add text
            $textColor = imagecolorallocate($image, 255, 255, 255);
            $text = $card->title;
            imagestring($image, 5, 20, $height / 2 - 10, substr($text, 0, 50), $textColor);

            // Save to temp file
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
            imagejpeg($image, $tempPath, 90);
            imagedestroy($image);

            $card->addMedia($tempPath)
                ->toMediaCollection('default');

            @unlink($tempPath);
        });
    }
}
