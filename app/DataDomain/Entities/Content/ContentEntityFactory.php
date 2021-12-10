<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Content;

class ContentEntityFactory
{
    public function __invoke(array $contentData): ContentEntity
    {
        $contentEntity = new ContentEntity();
        $contentEntity->setTitle($contentData['title']);
        $contentEntity->setReleaseDate($contentData['release_date']);
        $contentEntity->setContentType($contentData['content_type']);
        $contentEntity->setGenre($contentData['genre']);
        $contentEntity->setTags($contentData['tags']);
        $contentEntity->setRuntime($contentData['runtime']);
        $contentEntity->setShortDescription($contentData['short_description']);
        $contentEntity->setCast($contentData['cast']);
        $contentEntity->setDirectors($contentData['directors']);
        $contentEntity->setAgeRestriction($contentData['age_restriction']);
        $contentEntity->setPosterUrl($contentData['poster_url']);
        $contentEntity->setYoutubeTrailerUrl($contentData['youtube_trailer_url']);
        $contentEntity->setProductionCompany($contentData['production_company']);
        $contentEntity->setSeasons($contentData['seasons']);
        $contentEntity->setAverageEpisodeCount($contentData['average_episode_count']);

        return $contentEntity;
    }
}
