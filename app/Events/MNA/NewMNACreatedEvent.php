<?php

namespace App\Events\MNA;

use Illuminate\Http\Request;
use App\Models\MNA;

class NewMNACreatedEvent
{

    /**
     * Public declaration of variables.
     *
     * @var Request $request
     * @var  MNA $mna
     */
    public $request;
    public $mna;

    /**
     * Dependency Injection of variables
     *
     * @param Request $request
     * @param MNA $mna
     * @return void
     */
    public function __construct(Request $request, MNA $mna)
    {
        $this->request = $request;
        $this->mna = $mna;
    }
}