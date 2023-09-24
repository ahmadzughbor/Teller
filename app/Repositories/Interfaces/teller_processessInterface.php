<?php

namespace App\Repositories\Interfaces;

interface teller_processessInterface
{
    public function all();

    public function dataTable(array $attributes);

    public function find($hashId);

    public function store(array $attributes);
    public function getUsers(array $attributes);

}