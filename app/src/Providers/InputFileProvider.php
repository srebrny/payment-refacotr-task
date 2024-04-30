<?php

namespace Application\Providers;

use Application\Contracts\DataProviderInterface;

class InputFileProvider implements DataProviderInterface
{
    private ?string $fileName = null;

    private ?array $data = null;

    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @throws \Exception
     */
    public function load(): int
    {
        if (!$this->fileName) {
            throw new \Exception('File name not set');
        }

        $data = file_get_contents($this->fileName);
        if (!$data) {
            throw new \Exception('File not readable');
        }
        $dataExploded = explode("\n", $data);

        foreach ($dataExploded as $item) {
            if (!$item) {
                continue;
            }
            $decodedItem = json_decode($item, true, 512, JSON_THROW_ON_ERROR);
            if ($decodedItem !== false && is_array($decodedItem)) {
                $this->data[] = $decodedItem;
            }
        }

        return count($this->data);
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }
}
