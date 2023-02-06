<?php

namespace App\Admin\Repositories;

use App\Models\Mark as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Mark extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
