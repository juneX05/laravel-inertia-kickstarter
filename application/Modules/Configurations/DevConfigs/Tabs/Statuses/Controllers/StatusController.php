<?php

namespace Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Configurations\DevConfigs\Tabs\Statuses\Models\Status;

class StatusController extends Controller
{
    public function index() {
        abort_if(Gate::denies('statuses.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Status::all();

        return $this->render('Index', ['data' => $data]);
    }

    public function render($component, $props) {
        return Inertia::render('Configurations/DevConfigs/Tabs/Statuses/Views/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('status.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->render('Create', []);
    }

    public function edit($id) {
        abort_if(Gate::denies('status.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Statuses = Status::where('id',$id)->first();
        return $this->render('Edit', ['status' => $Statuses]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('status.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
            'abbreviation' => ['required'],
            'symbol' => ['nullable'],
        ])->validate();

        Status::create($request->all());

        return redirect()->back()
            ->with('message', 'Statuses Created Successfully.');
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('status.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required'],
            'abbreviation' => ['required'],
            'symbol' => ['nullable'],
        ])->validate();

        if ($request->has('id')) {
            Status::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Statuses Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('status.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Status::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
