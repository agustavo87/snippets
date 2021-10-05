<?php

declare(strict_types=1);

namespace Arete\Snippets;

class SnippetManager
{
    protected string $root = '';
    protected ?string $fullPath = null;
    protected ?string $relPath = null;
    protected ?string $viewCache = null;
    protected ?string $snippetPath = null;
    protected string $extension = '.html';

    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * Saves the relative path and returns the full patth
     * @param string $path relative to root
     *
     * @return void full path
     */
    public function setPath($path = ''): self
    {
        $this->processPath($path);
        return $this;
    }

    public function getFullPath(): ?string
    {
        return $this->fullPath;
    }

    public function isDir()
    {
        return is_dir($this->fullPath);
    }

    public function links()
    {
        $files = scandir($this->fullPath);
        array_shift($files);
        $links =   array_map(function ($value) {
            return $this->relPath . '/' . $value;
        }, $files);
        return $links;
    }

    public function processPath($relPath)
    {
        $fullPath =  realpath($this->root . '/' . $relPath);
        if (strlen($fullPath) > strlen($this->root)) {
            $relPath = str_replace($this->root . '\\', '', $fullPath);
        } else {
            $relPath = '';
        }
        $this->fullPath = $fullPath;
        $this->relPath = $relPath;
        $path = str_contains($this->fullPath, $this->extension) ? $this->fullPath : $this->fullPath . $this->extension;
        if (file_exists($path)) {
            $this->snippetPath = $path;
            return $path;
        }
    }

    public function getSnippetPath(): ?string
    {
        return $this->snippetPath;
    }

    public function getData()
    {
        if (!$this->snippetPath) {
            return null;
        }
        $file = basename($this->snippetPath, '.html');
        return [
            'relativePath' => $this->relPath,
            'html' => file_get_contents($this->snippetPath),
            'path' => dirname($this->relPath),
            'file' => $file,
            'title' => ucwords(str_replace('_', ' ', $file))
        ];
    }

    public function getRelativePath()
    {
        return $this->relPath;
    }
}
