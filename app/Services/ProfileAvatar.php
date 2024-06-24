<?php

namespace App\Services;

use Core\Constants\Constants;
use Core\Database\ActiveRecord\Model;

class ProfileAvatar
{
    /** @var array<string, mixed> $image */
    private array $image;

    public function __construct(
        private Model $model
    ) {
    }

    public function path(): string
    {
        if ($this->model->profile_picture) {
            return $this->baseDir() . $this->model->profile_picture;
        }

        return "/assets/images/defaults/avatar.png";
    }

    /**
     * @param array<string, mixed> $image
     */
    public function update(array $image): void
    {
        $this->image = $image;

        if (!empty($this->getTmpFilePath())) {
            $this->removeOldImage();
            $this->model->update(['profile_picture' => $this->getFileName()]);
            move_uploaded_file($this->getTmpFilePath(), $this->getAbsoluteFilePath());
        }
    }

    private function getTmpFilePath(): string
    {
        return $this->image['tmp_name'];
    }

    private function removeOldImage(): void
    {
        if ($this->model->profile_picture) {
            $path = Constants::rootPath()->join('public' . $this->baseDir())->join($this->model->profile_picture);
            unlink($path);
        }
    }

    private function getFileName(): string
    {
        $file_name_splitted  = explode('.', $this->image['name']);
        $file_extension = end($file_name_splitted);
        return 'avatar.' . $file_extension;
    }

    private function getAbsoluteFilePath(): string
    {
        return $this->storeDir() . $this->getFileName();
    }

    private function baseDir(): string
    {
        return "/assets/uploads/{$this->model::table()}/{$this->model->id}/";
    }

    private function storeDir(): string
    {
        $path = Constants::rootPath()->join('public' . $this->baseDir());
        if (!is_dir($path)) {
            mkdir(directory: $path, recursive: true);
        }

        return $path;
    }
}
