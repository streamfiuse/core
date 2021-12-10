<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Content;

use App\DataDomain\Entities\Content\Enum\ContentType;
use BenSampo\Enum\Exceptions\InvalidEnumMemberException;
use Carbon\Carbon;

class ContentEntity
{
    private string $title;

    private Carbon $releaseDate;

    private ContentType $contentType;

    /**
     * @var string[]
     */
    private array $genre;

    /**
     * @var string[]
     */
    private array $tags;

    private int $runtime;

    private string $shortDescription;

    /**
     * @var string[]
     */
    private array $cast;

    /**
     * @var string[]
     */
    private array $directors;

    private int $ageRestriction;

    private string $posterUrl;

    private string $youtubeTrailerUrl;

    private string $productionCompany;

    private int $seasons;

    private int $averageEpisodeCount;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getReleaseDate(): Carbon
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = Carbon::createFromFormat('Y-m-d', $releaseDate);
    }

    public function getContentType(): ContentType
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): void
    {
        try {
            $this->contentType = new ContentType($contentType);
        } catch (InvalidEnumMemberException $e) {
            $this->contentType = new ContentType(ContentType::Default);
        }
    }

    /**
     * @return string[]
     */
    public function getGenre(): array
    {
        return $this->genre;
    }

    /**
     * @param string[] $genre
     */
    public function setGenre(array $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }

    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string[]
     */
    public function getCast(): array
    {
        return $this->cast;
    }

    /**
     * @param string[] $cast
     */
    public function setCast(array $cast): void
    {
        $this->cast = $cast;
    }

    /**
     * @return string[]
     */
    public function getDirectors(): array
    {
        return $this->directors;
    }

    /**
     * @param string[] $directors
     */
    public function setDirectors(array $directors): void
    {
        $this->directors = $directors;
    }

    public function getAgeRestriction(): int
    {
        return $this->ageRestriction;
    }

    public function setAgeRestriction(int $ageRestriction): void
    {
        $this->ageRestriction = $ageRestriction;
    }

    public function getPosterUrl(): string
    {
        return $this->posterUrl;
    }

    public function setPosterUrl(string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    public function getYoutubeTrailerUrl(): string
    {
        return $this->youtubeTrailerUrl;
    }

    public function setYoutubeTrailerUrl(string $youtubeTrailerUrl): void
    {
        $this->youtubeTrailerUrl = $youtubeTrailerUrl;
    }

    public function getProductionCompany(): string
    {
        return $this->productionCompany;
    }

    public function setProductionCompany(string $productionCompany): void
    {
        $this->productionCompany = $productionCompany;
    }

    public function getSeasons(): int
    {
        return $this->seasons;
    }

    public function setSeasons(int $seasons): void
    {
        $this->seasons = $seasons;
    }

    public function getAverageEpisodeCount(): int
    {
        return $this->averageEpisodeCount;
    }

    public function setAverageEpisodeCount(int $averageEpisodeCount): void
    {
        $this->averageEpisodeCount = $averageEpisodeCount;
    }
}
