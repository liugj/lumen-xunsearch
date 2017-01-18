<?php
namespace Liugj\Xunsearch;

use Laravel\Scout\Searchable as ScoutSearchable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Liugj\Xunsearch\Jobs\MakeSearchable;

trait Searchable
{
    use  ScoutSearchable;
    /**
     * Dispatch the job to make the given models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @return void
     */
    public function queueMakeSearchable($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        if (! config('scout.queue')) {
            return $models->first()->searchableUsing()->update($models);
        }

        dispatch((new MakeSearchable($models))
                ->onQueue($models->first()->syncWithSearchUsingQueue())
                ->onConnection($models->first()->syncWithSearchUsing()));
    }
}
