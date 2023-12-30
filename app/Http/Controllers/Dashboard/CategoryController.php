<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Category\CategoryInterface;
use App\Http\Requests\Dashboard\Category\StoreRequest;
use App\Http\Requests\Dashboard\Category\UpdateRequest;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }



    public function index(Request $request)
    {
        return $this->category->index($request);
    }



    public function show($id)
    {
        return $this->category->show($id);
    }



    public function store(StoreRequest $request)
    {
        return $this->category->store($request);
    }



    public function update(UpdateRequest $request)
    {
        return $this->category->update($request);
    }



    public function destroy(Request $request)
    {
        return $this->category->destroy($request);
    }



    public function deleteSelected(Request $request)
    {
        return $this->category->deleteSelected($request);
    }



    public function showNotification($route_id,$notification_id)
    {
        return $this->category->showNotification($route_id,$notification_id);
    }
}
