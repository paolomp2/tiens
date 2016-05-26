<?php

namespace App\Repositories;

use App\Models\BASE;
use InfyOm\Generator\Common\BaseRepository;

class BASERepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        "CAMPO1"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BASE::class;
    }
}
