<?php

namespace App\Http\Controllers\Fiuselist\Service;

use App\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\Entities\Fiuselist\FiuselistEntity;
use App\Entities\Fiuselist\FiuselistEntryEntity;
use App\Entities\Fiuselist\Service\FiuselistEntityService;
use App\Repositories\Fiuselist\FiuselistRepository;

class FiuselistControllerService
{
    private FiuselistRepository $fiuselistRepository;
    private FiuselistEntityFactory $fiuselistEntityFactory;
    private FiuselistEntityService $fiuselistEntityService;

    public function __construct(
        FiuselistRepository $fiuselistRepository,
        FiuselistEntityFactory $fiuselistEntityFactory,
        FiuselistEntityService $fiuselistEntityService
    )
    {
        $this->fiuselistRepository = $fiuselistRepository;
        $this->fiuselistRepository->setTableName('content_user');

        $this->fiuselistEntityFactory = $fiuselistEntityFactory;
        $this->fiuselistEntityService = $fiuselistEntityService;
    }

    public function getFiuselistByUserId(int $userId): FiuselistEntity
    {
        $fiuselistData = $this->fiuselistRepository->find($userId, 'user_');
        return $this->fiuselistEntityFactory->create(json_decode(json_encode($fiuselistData), true));
    }

    public function insertNewEntryToFiuselist(FiuselistEntryEntity $newFiuselistEntry, FiuselistEntity $oldFiuselist): ?FiuselistEntity
    {
        $newFiuselist = $this->fiuselistEntityService->addEntryToFiuselist($newFiuselistEntry, $oldFiuselist);
        $wasWritingToDbSuccessful = $this->fiuselistRepository->writeFiuselistEntryToDatabase($newFiuselistEntry);

        if ($wasWritingToDbSuccessful){
            return $newFiuselist;
        }

        return null;
    }
}
