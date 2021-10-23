<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Fiuselist;

class FiuselistEntity
{
    /**
     * @var FiuselistEntryEntity[]
     */
    private array $fiuselistEntries;

    /**
     * FiuselistEntity constructor.
     */
    public function __construct(array $fiuselistEntries)
    {
        $this->fiuselistEntries = $fiuselistEntries;
    }

    /**
     * @return FiuselistEntryEntity[]
     */
    public function getFiuselistEntries(): array
    {
        return $this->fiuselistEntries;
    }

    public function setFiuselistEntries(array $fiuselistEntries): void
    {
        $this->fiuselistEntries = $fiuselistEntries;
    }
}
