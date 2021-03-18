<?php


namespace App\Entities\Fiuselist\Factory;


use App\Entities\Fiuselist\FiuselistEntity;

class FiuselistEntityFactory
{
    private FiuselistEntryEntityFactory $fiuselistEntryEntityFactory;
    public function __construct(FiuselistEntryEntityFactory $fiuselistEntryEntityFactory)
    {
        $this->fiuselistEntryEntityFactory = $fiuselistEntryEntityFactory;
    }

    public function create(array $fiuselistData): FiuselistEntity
    {
        $fiuselistEntries = [];
        foreach ($fiuselistData as $fiuselistEntryData) {
            $fiuselistEntries[] = $this->fiuselistEntryEntityFactory->create(json_decode(json_encode($fiuselistEntryData), true));
        }
        return new FiuselistEntity($fiuselistEntries);
    }
}
