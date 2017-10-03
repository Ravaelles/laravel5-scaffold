<?php

namespace Ravaelles\RScaffold;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RScaffoldController extends Controller {

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
        $modelName = $this->getModelName($request, true);
        if (isset($modelName::$scaffoldSort)) {
            $sort = $modelName::$scaffoldSort;
        } else {
            $sort = [$model->getPrimaryKey() => 'desc'];
        }

        // === Get objects ======================================================================

        // Sort
        $objects = $model;
        foreach ($sort as $key => $value) {
            $objects = $objects->orderBy($key, $value);
        }

        // Paginate
        $objects = $objects->paginate(10);

        // =========================================================================

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
                'fields' => $fields,
                'model' => $model,
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

        $this->assignAllValidFieldsToObject($object, $request);
        $object->save();

        flash("$modelName added!", 'success');
        return redirect()->route('laravel5-scaffold.index', ['model' => $this->getModelName($request)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id) {
        $model = $this->getModel($request);
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);
        $fields = $this->getFieldsSchemaFromModel($model);

        return $this->view('actions.show', [
                'fields' => $fields,
                'object' => $object,
                'modelName' => $this->getModelName($request)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        $model = $this->getModel($request);
        $modelName = $this->getModelName($request, true);
        $object = $modelName::findOrFail($id);
        $fields = $this->getFieldsSchemaFromModel($model);

        return $this->view('actions.edit', [
                'fields' => $fields,
                'object' => $object,
                'modelName' => $this->getModelName($request)
        ]);
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

        $this->assignAllValidFieldsToObject($object, $request);
        $object->save();

        flash("$modelName updated successfully.", 'info');
        return redirect()->route('laravel5-scaffold.index', ['model' => $this->getModelName($request)]);
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
        flash("$modelName deleted.", 'danger');
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

    private function assignAllValidFieldsToObject($object, $request) {
        foreach ($request->all() as $name => $value) {
            if (!in_array($name, ['_id', '_created', '_updated', '_token', '_method'])) {
                $object->$name = $value;
            }
        }
    }

}
