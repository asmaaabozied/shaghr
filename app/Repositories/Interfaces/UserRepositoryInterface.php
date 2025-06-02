<?php


namespace App\Repositories\Interfaces;


interface UserRepositoryInterface
{


    public function getAll($data);

    public function create();

    public function edit($Id);

    public function show($Id);

    public function destroy($user);

    public function store($request);

    public function update($user, $request);
}
