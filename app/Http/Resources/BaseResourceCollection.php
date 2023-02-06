<?php
/**
 * Created by PhpStorm.
 * User: Jourdon
 * Date: 2019-08-07
 * Time: 13:51
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    protected $withoutFields = [];
    protected $hide = true;
    protected $withData = null;

    public function __construct($resource, $withData = null)
    {
        parent::__construct($resource);
        $this->withData = $withData;
    }

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }

    public function show(array $fields)
    {
        $this->withoutFields = $fields;
        $this->hide = false;

        return $this;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                $item->withData = $this->withData;
                if (!$this->hide) {
                    return collect($item)->only($this->withoutFields)->all();
                }
                return collect($item)->except($this->withoutFields)->all();
            }),
            'meta' => [
                "pagination" => $this->when(!empty($this->pageMeta()), $this->pageMeta())
            ]
        ];
    }

    //定义这个方法主要用于分页，当用josn返回的时候是没有 links 和 meta 的
    public function pageMeta()
    {
        try {
            return [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
                'count' => $this->resource->count(),
                'total_pages' => $this->resource->lastPage(),
            ];
        } catch (\BadMethodCallException $exception) {
            return [];
        }
    }

    /**
     * 重写 withResponse，用于meta头的重构
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     */
    public function withResponse($request, $response)
    {
        $data = $response->getData(true);
        collect($data)->each(function ($item, $key) use (&$data) {
            if (!in_array($key, ['data', 'links', 'meta'])) {
                unset($data[$key]);
                $data['meta'][$key] = $item;
            }
        });
        if (empty($data['meta'])) {
            unset($data['meta']);
        }
        $response->setData($data);
    }
}
