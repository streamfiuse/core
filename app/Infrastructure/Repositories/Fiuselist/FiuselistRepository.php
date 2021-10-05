<?php

namespace App\Infrastructure\Repositories\Fiuselist;

use App\BusinessDomain\Fiuselist\Service\FiuselistEntryEntityService;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;
use App\Exceptions\NotCreatedException;
use App\Infrastructure\Repositories\QueryBaseRepository;

class FiuselistRepository extends QueryBaseRepository implements FiuselistRepositoryInterface
{
    private FiuselistEntryEntityService $fiuselistEntryEntityService;

    public function __construct(
        FiuselistEntryEntityService $fiuselistEntryEntityService,
        string $tableName = ''
    ) {
        parent::__construct($tableName);
        $this->fiuselistEntryEntityService = $fiuselistEntryEntityService;
    }


    public function writeFiuselistEntryToDatabase(FiuselistEntryEntity $newFiuselistEntry): bool
    {
        $fiuselistEntryAttributes = $this->fiuselistEntryEntityService
            ->extractAttributesArrayFromFiuselistEntryEntity($newFiuselistEntry);
        try {
            $this->create($fiuselistEntryAttributes);
            return true;
        } catch (NotCreatedException $exception) {
            return false;
        }
    }
}