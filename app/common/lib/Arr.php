<?php


namespace app\common\lib;


class Arr
{
    public static function getPageDefault($limit)
    {
        return [
              "total" => 0,
              "per_page" => $limit,
              "current_page" => 0,
              "last_page" => 0,
              "data" => []
        ];
    }

}