<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

trait CanLoadRelationships
{

  private $relations = ['user', 'attendees', 'attendees.user'];
  public function loadRelationships(
    Model|Builder|QueryBuilder|HasMany $for,
    ?array $relations = null,
  ): Model|Builder|QueryBuilder|HasMany {
    $relations = $relations ?? $this->$relations ?? [];

    foreach ($relations as $relation) {
      $for->when(
        $this->shouldIncludeRelation($relation),
        fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
      );
    }

    return $for;
  }

  protected function shouldIncludeRelation(string $relation)
  {
    $include = request()->query('include');

    if (!$include) {
      return false;
    }

    $relations = array_map('trim', explode(',', $include));
    //explode returns an array where string is divided for each ,

    return in_array($relation, $relations);
  }
}