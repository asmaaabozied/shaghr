<?php


namespace App\Repositories\Interfaces;


interface RoleRepositoryInterface
{


    public function getAll($data);

    public function create();

    public function edit($role);

    public function show($Id);

    public function destroy($role);

    public function store($request);

    public function update($role,$request);
}
