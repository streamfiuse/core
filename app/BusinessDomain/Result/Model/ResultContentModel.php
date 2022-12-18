<?php

declare(strict_types=1);

namespace App\BusinessDomain\Result\Model;

use App\DataDomain\Entities\Content\Enum\ContentType;
use BenSampo\Enum\Exceptions\InvalidEnumMemberException;
use Carbon\Carbon;

class ResultContentModel
{
    private int $id;

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

    private ?string $likeStatus;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

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

    public function setReleaseDate(Carbon $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    public function getContentType(): ContentType
    {
        return $this->contentType;
    }

    public function setContentType(ContentType $contentType): void
    {
        $this->contentType = $contentType;
    }

    public function getGenre(): array
    {
        return $this->genre;
    }

    public function setGenre(array $genre): void
    {
        $this->genre = $genre;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

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

    public function getCast(): array
    {
        return $this->cast;
    }

    public function setCast(array $cast): void
    {
        $this->cast = $cast;
    }

    public function getDirectors(): array
    {
        return $this->directors;
    }

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

    /**
     * @param string $youtubeTrailerUrl
     */
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

    public function getLikeStatus(): ?string
    {
        return $this->likeStatus;
    }

    public function setLikeStatus(?string $likeStatus): void
    {
        $this->likeStatus = $likeStatus;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'release_date' => $this->releaseDate->format('d.m.Y'),
            'content_type' => $this->contentType->value,
            'genre' => $this->genre,
            'tags' => $this->tags,
            'runtime' => $this->runtime,
            'short_description' => $this->shortDescription,
            'cast' => $this->cast,
            'directors' => $this->directors,
            'age_restriction' => $this->ageRestriction,
            'poster_url' => $this->posterUrl,
            'youtube_trailer_url' => $this->youtubeTrailerUrl,
            'production_company' => $this->productionCompany,
            'seasons' => $this->seasons,
            'average_episode_count' => $this->averageEpisodeCount,
        ];
    }
}
