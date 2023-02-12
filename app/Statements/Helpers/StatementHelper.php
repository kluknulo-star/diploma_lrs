<?php

namespace App\Statements\Helpers;

class StatementHelper
{
    public static function getBeautifulString(string|null $uglyString, string $separator): string
    {
        if (!$uglyString) {
            return '';
        }
        $explodedUglyString = explode($separator, $uglyString);
        return $explodedUglyString[count($explodedUglyString) - 1];
    }

    public static function prepareDataForDisplay(array $statements): array
    {
        return array_map(function ($statement) {
            return [
                'statement_id' => $statement['statement_id'],
                'actor_mbox' => [
                    'link' => $statement['actor_mbox'],
                    'text' => self::getBeautifulString(
                        $statement['actor_mbox'],
                        'mailto:'
                    )
                ],
                'verb_id' => [
                    'link' => $statement['verb_id'],
                    'text' => self::getBeautifulString(
                        $statement['verb_id'],
                        '/'
                    )
                ]
                ,
                'object_id' =>
                    [
                        'link' => $statement['object_id'],
                        'text' => self::getBeautifulString(
                            $statement['object_id'],
                            'http://'
                        )
                    ],
            ];
        }, $statements);
    }
}
