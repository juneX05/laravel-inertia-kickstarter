<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Status_Model;

class Status_Controller extends Controller
{
    public function index() {
        abort_if(Gate::denies('statuses.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Status_Model::all();

        return $this->render('Index', ['data' => $data]);
    }

    public function render($component, $props) {
        return Inertia::render('Configurations/DevConfigs/Tabs/Statuses/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('status.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->render('Create', []);
    }

    public function edit($id) {
        abort_if(Gate::denies('status.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Statuses = Status_Model::where('id',$id)->first();
        return $this->render('Edit', ['status' => $Statuses]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('status.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
            'id' => ['required'],
            'color' => ['nullable'],
        ])->validate();

        Status_Model::create($request->all());

        return redirect()->back()
            ->with('message', 'Statuses Created Successfully.');
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('status.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'key_id' => ['required'],
            'name' => ['required'],
            'id' => ['required'],
            'color' => ['nullable'],
        ])->validate();

        if ($request->has('key_id')) {
            Status_Model::find($request->input('key_id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Statuses Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('status.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Status_Model::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
