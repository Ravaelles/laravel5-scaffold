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
        if ($model !== null) {
            return $this->listObjects($request, $model);
        } else {
            return $this->dashboard($request);
        }
    }

    private function dashboard($request) {
        $rawModels = glob(app_path("*.php"));
        $models = [];
        $appPath = app_path("");
        foreach ($rawModels as $rawFile) {
            $models[$rawFile] = substr(str_replace([$appPath, ".php"], "", $rawFile), 1);
        }

        return $this->view('dashboard.dashboard', compact('models'));
    }

    private function listObjects($request, $model) {
        $objects = $model::orderBy($model->getPrimaryKey(), 'desc')->paginate(10);
        $fields = $this->getFieldsSchemaFromModel($model);

        return $this->view('actions.index', [
                'objects' => $objects,
                'fields' => $fields,
                'modelName' => $this->getModelName($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request) {
        $model = $this->getModel($request);
        $fields = $this->getFieldsSchemaFromModel($model);

        return $this->view('actions.create', [
                'model' => $model,
                'modelName' => $this->getModelName($request),
                'fields' => $fields,
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

        $modelName = $this->getModelName($request);
        flash('Item added!', 'success');
        return redirect()->route('laravel5-scaffold.index', ['model' => $modelName]);
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
        return $this->view('actions.edit', compact('object', 'modelName'));
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

        flash('Item updated successfully.', 'info');
        return redirect()->route('laravel5-scaffold.index', ['model' => $modelName]);
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

        $modelName = $this->getModelName($request);
        flash('Item deleted.', 'danger');
        return redirect()->route('laravel5-scaffold.index', ['model' => $modelName]);
    }

    // =========================================================================

    private function view($viewName, $params = []) {
        return View::make('laravel5-scaffold::' . $viewName, $params);
    }

    private function getModel($request) {
        $modelName = $request->get("model");
        if (strlen($modelName)) {
            $model = app("App\\{$modelName}");
            return $model;
        } else {
            return null;
        }
    }

    private function getModelName($request, $prefixWithApp = false) {
        $model = $request->get("model");
        if (strlen($model)) {
            return ($prefixWithApp ? "App\\" : "") . $model;
        } else {
            return null;
        }
    }

    private function getFieldsSchemaFromModel($model) {
        $class = get_class($model);
        $fieldsSchema = $class::$scaffold;
        return $fieldsSchema;
    }

}
