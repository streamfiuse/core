<?php

namespace App\Http\Controllers\Fiuselist\Service;

use App\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\Entities\Fiuselist\Factory\FiuselistEntryEntityFactory;
use App\Entities\Fiuselist\FiuselistEntity;
use App\Entities\Fiuselist\FiuselistEntryEntity;
use App\Entities\Fiuselist\Service\FiuselistEntityService;
use App\Repositories\Fiuselist\FiuselistRepository;
use App\Rules\Fiuselist\IsFiuselistEntryAlreadyInFiuselistRule;
use Carbon\Carbon;

class FiuselistControllerService
{
    private FiuselistRepository $fiuselistRepository;
    private FiuselistEntityFactory $fiuselistEntityFactory;
    private FiuselistEntryEntityFactory $fiuselistEntryEntityFactory;
    private FiuselistEntityService $fiuselistEntityService;
    private IsFiuselistEntryAlreadyInFiuselistRule $isFiuselistEntryAlreadyInFiuselistRule;

    public function __construct(
        FiuselistRepository $fiuselistRepository,
        FiuselistEntityFactory $fiuselistEntityFactory,
        FiuselistEntryEntityFactory $fiuselistEntryEntityFactory,
        FiuselistEntityService $fiuselistEntityService,
        IsFiuselistEntryAlreadyInFiuselistRule $isFiuselistEntryAlreadyInFiuselistRule
    )
    {
        $this->fiuselistRepository = $fiuselistRepository;
        $this->fiuselistRepository->setTableName('content_user');

        $this->fiuselistEntityFactory = $fiuselistEntityFactory;
        $this->fiuselistEntryEntityFactory = $fiuselistEntryEntityFactory;
        $this->fiuselistEntityService = $fiuselistEntityService;
        $this->isFiuselistEntryAlreadyInFiuselistRule = $isFiuselistEntryAlreadyInFiuselistRule;
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
