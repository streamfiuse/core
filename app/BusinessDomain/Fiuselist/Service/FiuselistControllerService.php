<?php

declare(strict_types=1);

namespace App\BusinessDomain\Fiuselist\Service;

use App\DataDomain\Entities\Fiuselist\Factory\FiuselistEntityFactory;
use App\DataDomain\Entities\Fiuselist\FiuselistEntity;
use App\DataDomain\Entities\Fiuselist\FiuselistEntryEntity;
use App\Infrastructure\Repositories\Fiuselist\FiuselistRepository;

class FiuselistControllerService
{
    private FiuselistRepository $fiuselistRepository;
    private FiuselistEntityFactory $fiuselistEntityFactory;
    private FiuselistEntityService $fiuselistEntityService;

    public function __construct(
        FiuselistRepository $fiuselistRepository,
        FiuselistEntityFactory $fiuselistEntityFactory,
        FiuselistEntityService $fiuselistEntityService
    ) {
        $this->fiuselistRepository = $fiuselistRepository;
        $this->fiuselistRepository->setTableName('content_user');

        $this->fiuselistEntityFactory = $fiuselistEntityFactory;
        $this->fiuselistEntityService = $fiuselistEntityService;
    }

    public function getFiuselistByUserId(int $userId): FiuselistEntity
    {
        $fiuselistData = $this->fiuselistRepository->find($userId, 'user_');
        $json = json_encode($fiuselistData);
        if ($json !== false) {
            return $this->fiuselistEntityFactory->create(json_decode($json, true));
        }
        return new FiuselistEntity([]);
    }

    public function insertNewEntryToFiuselist(FiuselistEntryEntity $newFiuselistEntry, FiuselistEntity $oldFiuselist): ?FiuselistEntity
    {
        $newFiuselist = $this->fiuselistEntityService->addEntryToFiuselist($newFiuselistEntry, $oldFiuselist);
        $wasWritingToDbSuccessful = $this->fiuselistRepository->writeFiuselistEntryToDatabase($newFiuselistEntry);

        if ($wasWritingToDbSuccessful) {
            return $newFiuselist;
        }

        return null;
    }
}
