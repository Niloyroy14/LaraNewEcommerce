<?php

namespace App\Repositories;


interface CategoryInterface {

    public function index();

    public function store(array $data);

    public function show($id);

    public function edit($id);

    public function update(array $data,$id);

    public function delete($id);


}