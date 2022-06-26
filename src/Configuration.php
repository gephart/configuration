<?php

namespace Gephart\Configuration;

use Gephart\Configuration\Exception\ConfigurationException;

/**
 * Configuration
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
     * @var array<string, mixed>
     */
    private $configuration;

    /**
     * @since 0.4 Now throw \Gephart\Configuration\Exception\ConfigurationException
     * @since 0.2
     *
     * @param string $key
     * @throws ConfigurationException
     * @return mixed
     */
    public function get(string $key)
    {
        if (empty($this->configuration)) {
            $this->parseFiles();
        }

        if (empty($this->configuration[$key])) {
            throw new ConfigurationException("'$key' missing in configuration.");
        }

        return $this->configuration[$key];
    }

    /**
     * @since 0.4 Now throw \Gephart\Configuration\Exception\ConfigurationException
     * @since 0.2
     *
     * @param string $directory
     * @throws ConfigurationException
     * @return void
     */
    public function setDirectory(string $directory)
    {
        if (!is_dir($directory)) {
            throw new ConfigurationException("'$directory' is not directory.");
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
     * @since 0.4 Now throw \Gephart\Configuration\Exception\ConfigurationException
     * @since 0.2
     *
     * @throws ConfigurationException
     * @return void
     */
    private function parseFiles()
    {
        if (empty($this->directory)) {
            throw new ConfigurationException("Base directory of configuration is not set.");
        }

        $jsons = $this->loadJsonFiles();
        $configuration = $this->parseJsonFiles($jsons);
        $this->configuration = $configuration;
    }

    /**
     * @param array<string|false> $files
     * @return array<string|false>
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
     * @param array<mixed> $jsons
     * @return array<mixed>
     */
    private function parseJsonFiles(array $jsons = []): array
    {
        foreach ($jsons as $key => $json) {
            $jsons[$key] = json_decode($json, true);
        }

        return $jsons;
    }
}
