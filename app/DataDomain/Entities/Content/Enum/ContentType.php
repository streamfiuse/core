<?php

declare(strict_types=1);

namespace App\DataDomain\Entities\Content\Enum;

use BenSampo\Enum\Enum;

final class ContentType extends Enum
{
    const Movie = 'movie';
    const TvShow = 'tv_show';
    const ShortFilm = 'short_film';
    const MiniTvShow = 'mini_tv_show';
    const Default = 'default';
}
