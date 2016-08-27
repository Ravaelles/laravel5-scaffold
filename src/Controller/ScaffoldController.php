<?php

namespace Ravaelles\Laravel5Scaffold;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ScaffoldController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $model = $this->getModel($request);
        $objects = $model::orderBy($model->getPrimaryKey(), 'desc')->paginate(10);

        return $this->view('index', [
                'objects' => $objects,
                'modelName' => $this->getModelName($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request) {
        return $this->view('create', [
                'model' => $this->getModel($request),
                'modelName' => $this->getModelName($request),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $modelName = $this->getModelName($request, true);
        $object = new $modelName();

        $object->save();

        return redirect()->route('laravel5-scaffold.index')->with('message', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id) {
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);

        return $this->view('show', compact('object'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);

        $modelName = $this->getModelName($request);
        return $this->view('edit', compact('object', 'modelName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) {
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);

        $object->save();

        return redirect()->route('index')->with('message', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);
        $object->delete();

        return redirect()->route('index')->with('message', 'Item deleted successfully.');
    }

    // =========================================================================

    private function view($viewName, $params = []) {
        return View::make('laravel5-scaffold::' . $viewName, $params);
    }

    private function getModel($request) {
        $modelName = $request->get("model");
        $class = $modelName;
        $model = app("App\\{$modelName}");
        return $model;
    }

    private function getModelName($request, $prefixWithApp = false) {
        return ($prefixWithApp ? "App\\" : "") . $request->get("model");
    }

}
