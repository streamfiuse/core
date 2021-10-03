<?php

namespace App\DataDomain\Entities\Fiuselist;

class FiuselistEntity
{
    /**
     * @var FiuselistEntryEntity[]
     */
    private array $fiuselistEntries;

    /**
     * FiuselistEntity constructor.
     * @param FiuselistEntryEntity[] $fiuselist
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

    /**
     * @param FiuselistEntryEntity[] $fiuselistEntries
     */
    public function setFiuselistEntries(array $fiuselistEntries): void
    {
        $this->fiuselistEntries = $fiuselistEntries;
    }

}
