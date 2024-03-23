<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    public function index(Request $request)
    {
        $dogs = Dog::where('adopted', false)->get();
        return view('dogs.index', compact('dogs'));
    }

    public function create()
    {
        return view('dogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'breed' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'adopted' => 'required'
        ]);

        $dog = new Dog();
        $dog->name = $request->name;
        $dog->breed = $request->breed;
        $dog->age = $request->age;
        $dog->sex = $request->sex;
        $dog->adopted = $request->adopted;
        $dog->save();

        return redirect('/');
    }

    public function show($id)
    {
        $dog = Dog::findOrFail($id);
        return view('dogs.show', compact('dog'));
    }

    public function edit($id)
    {
        $dog = Dog::findOrFail($id);
        return view('dogs.edit', compact('dog'));
    }

    public function update(Request $request, $id)
    {
//        $request->validate([
//            'name' => 'required',
//            'breed' => 'required',
//            'age' => 'required',
//            'sex' => 'required',
//            'adopted' => 'required'
//        ]);
    }
}
