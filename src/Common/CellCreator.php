<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Common;

use OpenSpout\Common\Entity\Cell;

class CellCreator
{
    /**
     * @param array<int, scalar|\DateTimeInterface|\DateInterval|null> $values
     *
     * @return array<int, Cell>
     */
    public static function toCells(array $values): array
    {
        return array_map(static fn ($v) => Cell::fromValue($v), $values);
    }
}
