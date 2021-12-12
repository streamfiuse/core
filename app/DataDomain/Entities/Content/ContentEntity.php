<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Content;

use App\DataDomain\Entities\Content\Enum\ContentType;
use App\DataDomain\Entities\EntityInterface;
use BenSampo\Enum\Exceptions\InvalidEnumMemberException;
use Carbon\Carbon;

class ContentEntity implements EntityInterface
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
    public function setGenre(string $genre): void
    {
        $this->genre = json_decode($genre, true);
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
    public function setTags(string $tags): void
    {
        $this->tags = json_decode($tags, true);
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
    public function setCast(string $cast): void
    {
        $this->cast = json_decode($cast, true);
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
    public function setDirectors(string $directors): void
    {
        $this->directors = json_decode($directors, true);
    }

    public function getAgeRestriction(): int
    {
        return $this->ageRestriction;
    }

    public function setAgeRestriction(string $ageRestriction): void
    {
        $this->ageRestriction = (int)$ageRestriction;
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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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
