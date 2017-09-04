<?php

namespace Gephart\Configuration;

/**
 * Configration
 *
 * @package Gephart\Configuration
 * @author Michal Katuščák <michal@katuscak.cz>
 * @since 0.2
 */
final class Configuration
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var array
     */
    private $configuration;

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $key)
    {
        if (empty($this->configuration)) {
            $this->parseFiles();
        }

        if (empty($this->configuration[$key])) {
            throw new \Exception("Configuration: '$key' missing in configuration.");
        }

        return $this->configuration[$key];
    }

    /**
     * @param string $directory
     * @throws \Exception
     */
    public function setDirectory(string $directory)
    {
        if (!is_dir($directory)) {
            throw new \Exception("Configuration: '$directory' is not directory.");
        }

        $this->directory = $directory;
    }

    /**
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * @throws \Exception
     */
    private function parseFiles()
    {
        if (empty($this->directory)) {
            throw new \Exception("Configuration: Base directory is not set.");
        }

        $jsons = $this->loadJsonFiles();
        $configuration = $this->parseJsonFiles($jsons);
        $this->configuration = $configuration;
    }

    /**
     * @param array $files
     * @return array
     */
    private function loadJsonFiles(array $files = []): array
    {
        if ($handle = opendir($this->directory)) {
            while (false !== ($entry = readdir($handle))) {
                $path = explode(".", $entry);
                if (!empty($path[1]) && $path[1] == "json") {
                    $files[$path[0]] = file_get_contents($this->directory . "/" . $entry);
                }
            }
        }
        return $files;
    }

    /**
     * @param array $jsons
     * @return array
     */
    private function parseJsonFiles(array $jsons = []): array
    {
        foreach ($jsons as $key => $json) {
            $jsons[$key] = json_decode($json, true);
        }

        return $jsons;
    }

}