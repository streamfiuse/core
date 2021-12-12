<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Content\Enum;

use BenSampo\Enum\Enum;

final class ContentType extends Enum
{
    public const Movie = 'movie';
    public const TvShow = 'tv_show';
    public const ShortFilm = 'short_film';
    public const MiniTvShow = 'mini_tv_show';
    public const Default = 'default';
}
