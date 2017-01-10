<?php

namespace Liugj\Xunsearch\Engines;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine as Engine;
use Illuminate\Database\Eloquent\Collection;
use Liugj\Xunsearch\XunsearchClient as Xunsearch;

class XunsearchEngine extends Engine
{
	/**
	 * The Xunsearch client.
	 *
	 * @var Liugj\Xunsearch\XunSearchClient
	 */

	protected $xunsearch;
	/**
	 * Create a new engine instance.
	 *
	 * @return void
	 */
	public function __construct(Xunsearch $xunsearch)
	{
		$this->xunsearch = $xunsearch;
	}

	private function hasDB($db)
	{
		return !empty(cache('xunsearch_'.$db));
	}

	private function setDB($model)
	{
		$dbconfig = [];
		if (!$this->hasDB($model->searchableAs())) {
			$dbconfig['project.name'] = $model->searchableAs();
			$dbconfig['project.default_charset'] = 'utf-8';
			$dbconfig['project.index'] = $this->host.':'.$this->indexPort;
			$dbconfig['project.search'] = $this->host.':'.$this->searchPort;

			$titleMark = false;
			$attrs = $model->toSearchableArray();
			foreach ($attrs as $attr => $value) {
				$type = gettype($value);
				if ($type == 'integer' || $type == 'double') {
					$type = 'numeric';
					$dbconfig[$attr] = ['type' => $type];
				} else {
					$type = 'string';
					if (!$titleMark) {
						$titleMark = true;
						$type = 'title';
						$dbconfig[$attr] = ['type' => $type];
					} else {
						$dbconfig[$attr] = ['type' => $type, 'index' => 'mixed'];
					}
				}
			}
			$dbconfig['xs_id'] = ['type' => 'id'];
			cache()->forever('xunsearch_'.$dbconfig['project.name'], $dbconfig);
		} else {
			$dbconfig = cache('xunsearch_'.$model->searchableAs());
		}

		$this->xs = new \XS($dbconfig);
	}

	/**
	 * Update the given model in the index.
	 *
	 * @param  \Illuminate\Database\Eloquent\Collection  $models
	 * @throws \XSException
	 * @return void
	 */
	public function update($models)
	{
		$this->setDB($models->first());

		$index = $this->xs->index;
		$models->map(function ($model) use ($index) {
				$array = $model->toSearchableArray();

				if (empty($array)) {
				return;
				}
				$array['xs_id'] = $model->getKey();
				$doc = new \XSDocument;
				$doc->setFields($array);
				$index->update($doc);
				});
		$index->flushIndex();
	}

	/**
	 * Remove the given model from the index.
	 *
	 * @param  \Illuminate\Database\Eloquent\Collection  $models
	 * @return void
	 */
	public function delete($models)
	{
		$this->setDB($models->first());

		$index = $this->xs->index;
		$models->map(function ($model) use ($index) {
				$index->del($model->getKey());
				});
		$index->flushIndex();
	}

	/**
	 * Perform the given search on the engine.
	 *
	 * @param  \Laravel\Scout\Builder  $builder
	 * @return mixed
	 */
	public function search(Builder $builder)
	{
		return $this->performSearch($builder, array_filter([
					'hitsPerPage' => $builder->limit,
		]));
	}

	/**
	 * Perform the given search on the engine.
	 *
	 * @param  \Laravel\Scout\Builder  $builder
	 * @param  int  $perPage
	 * @param  int  $page
	 * @return mixed
	 */
	public function paginate(Builder $builder, $perPage, $page)
	{
		return $this->performSearch($builder, [
				'hitsPerPage' => $perPage,
				'page' => $page - 1,
		]);
	}

	/**
	 * Perform the given search on the engine.
	 *
	 * @param  \Laravel\Scout\Builder  $builder
	 * @param  array  $options
	 * @return mixed
	 */
	protected function performSearch(Builder $builder, array $options = [])
	{
		$this->setDB($builder->model);
		$search = $this->xs->search;

		if ($builder->callback) {
			return call_user_func(
					$builder->callback,
					$search,
					$builder->query,
					$options
					);
		}
		$search->setFuzzy()->setQuery($builder->query);
		collect($builder->wheres)->map(function ($value, $key) use ($search){
				$search->addRange($key, $value, $value);
				});
		$offset = 0;
		$perPage = $options['hitsPerPage'];
		if (!empty($options['page'])) {
			$offset = $perPage * $options['page'];
		}
		return $search->setLimit($perPage, $offset)->search();
	}


	/**
	 * Map the given results to instances of the given model.
	 *
	 * @param  mixed  $results
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function map($results, $model)
	{
		if (count($results) === 0) {
			return Collection::make();
		}

		$keys = collect($results)
			->pluck('xs_id')->values()->all();

		$models = $model->whereIn(
				$model->getQualifiedKeyName(), $keys
				)->get()->keyBy($model->getKeyName());

		return Collection::make($results)->map(function ($hit) use ($model, $models) {
				$key = $hit['xs_id'];

				if (isset($models[$key])) {
				return $models[$key];
				}
				})->filter();
	}

	/**
	 * Get the total count from a raw result returned by the engine.
	 *
	 * @param  mixed  $results
	 * @return int
	 */
	public function getTotalCount($results)
	{
		return count($results);
	}
}
