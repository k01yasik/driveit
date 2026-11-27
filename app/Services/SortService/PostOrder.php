<?php

namespace App\Services\SortService;

enum PostOrder
{
    case Rating;
    case Comments;
    case Views;
}
