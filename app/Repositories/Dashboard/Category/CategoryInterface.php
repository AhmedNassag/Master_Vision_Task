<?php

namespace App\Repositories\Dashboard\Category;

interface CategoryInterface 
{

    public function index($request);

    public function show($id);
        
    public function store($request);

    public function update($request);

    public function destroy($request);

    public function deleteSelected($request);

    public function showNotification($route_id,$notification_id);

}
