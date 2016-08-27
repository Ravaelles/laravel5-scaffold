<?php

namespace Ravaelles\Laravel5Scaffold;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SkillsTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ScaffoldController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($model) {
//        $skills_templates = SkillsTemplate::orderBy('id', 'desc')->paginate(10);
//
//        return view('skills_templates.index', compact('skills_templates'));

        $class = "App\\" . $model;
        $model = app("App\\{$model}");

        $objects = $model::orderBy($model->getPrimaryKey(), 'desc')->paginate(10);

//        foreach ($objects as $object) {
//            var_dump($object);
//        }
//        exit;

        return View::make('laravel5-scaffold::index', [
                'objects' => $objects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('skills_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $skills_template = new SkillsTemplate();



        $skills_template->save();

        return redirect()->route('skills_templates.index')->with('message', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $skills_template = SkillsTemplate::findOrFail($id);

        return view('skills_templates.show', compact('skills_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $skills_template = SkillsTemplate::findOrFail($id);

        return view('skills_templates.edit', compact('skills_template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) {
        $skills_template = SkillsTemplate::findOrFail($id);



        $skills_template->save();

        return redirect()->route('skills_templates.index')->with('message', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $skills_template = SkillsTemplate::findOrFail($id);
        $skills_template->delete();

        return redirect()->route('skills_templates.index')->with('message', 'Item deleted successfully.');
    }

}
