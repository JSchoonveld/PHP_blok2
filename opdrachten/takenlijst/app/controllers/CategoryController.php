<?php

namespace app\controllers;

use core\Controller;
use app\models\Category;
use core\Request;
class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::index();

        $this->response->categories = $categories;
        $this->response->title = 'Categories';
        $this->response
            ->show( 'category/index');
    }
    public function create()
    {
        $this->response->title = 'New Category';
        $this->response
            ->show( 'category/create');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->response->category = $category;
        $this->response->title = 'Edit Category';
//        $this->response->redirect(  $id);
        $this->response->show( 'category/edit');
    }
    public function confirmDelete($id)
    {
         $category = Category::findOrFail($id);
        $this->response->category = $category;
        $this->response->title = 'Are You Sure?';

        $this->response->show( 'category/delete');
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $this->response
            ->with('message','Category <strong>' . $category->name . '</strong> deleted.')
            ->redirect( '../../category/index');

        $this->response->show( 'category/index');
    }

    public function store()
    {
        if
        (
            $this->validator
                ->withRules
                ([
                    'name' => ['required', 'max:60', 'unique:\app\models\category'],
                ])
                ->rejects($this->request)
        )
        {
            $this->response->old = $this->validator->getErrors();
            $this->response->title = 'Validation went wrong';
            $this->response
                ->show('category/create');
        }
        else
        {
            $category = new Category;
            $category->name = $this->request->name;
            $category->description = $this->request->description;

            $category->store();
            $this->response
                ->with('message','Category <strong>' . $category->name . '</strong> Added.')
                ->redirect('./index');
        }

    }

}

