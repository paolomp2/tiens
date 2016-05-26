<?php

namespace App\Repositories;

use App\Models\prueba;
use InfyOm\Generator\Common\BaseRepository;

class pruebaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        "nombre"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return prueba::class;
    }
}
