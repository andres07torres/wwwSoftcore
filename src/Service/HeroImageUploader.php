<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class HeroImageUploader
{
    private const PUBLIC_PREFIX = '/uploads/hero/';

    public function __construct(
        private SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/hero')]
        private string $targetDirectory,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        $safeName = (string) $this->slugger->slug($originalName)->lower();
        if ('' === $safeName) {
            $safeName = 'hero-slide';
        }

        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'webp';
        $fileName = sprintf('%s-%s.%s', $safeName, bin2hex(random_bytes(4)), $extension);

        $file->move($this->targetDirectory, $fileName);

        return self::PUBLIC_PREFIX.$fileName;
    }

    public function deleteIfManaged(?string $imagePath): void
    {
        if (null === $imagePath || !str_starts_with($imagePath, self::PUBLIC_PREFIX)) {
            return;
        }

        $fileName = basename($imagePath);
        $fullPath = $this->targetDirectory.\DIRECTORY_SEPARATOR.$fileName;

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
