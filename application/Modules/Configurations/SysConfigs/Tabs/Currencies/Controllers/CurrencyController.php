<?php

namespace Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Application\Modules\Configurations\SysConfigs\Tabs\Currencies\Models\Currency;

class CurrencyController extends Controller
{
    public function index() {
        abort_if(Gate::denies('currencies.view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Currency::all();

        return $this->render('Index', ['data' => $data]);
    }

    public function render($component, $props) {
        return Inertia::render('Configurations/SysConfigs/Tabs/Currencies/Views/' . $component, $props);
    }

    public function create() {
        abort_if(Gate::denies('currency.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->render('Create', []);
    }

    public function edit($id) {
        abort_if(Gate::denies('currency.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Currencies = Currency::where('id',$id)->first();
        return $this->render('Edit', ['currency' => $Currencies]);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('currency.create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'name' => ['required'],
            'abbreviation' => ['required'],
            'symbol' => ['nullable'],
        ])->validate();

        Currency::create($request->all());

        return redirect()->back()
            ->with('message', 'Currencies Created Successfully.');
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('currency.edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required'],
            'abbreviation' => ['required'],
            'symbol' => ['nullable'],
        ])->validate();

        if ($request->has('id')) {
            Currency::find($request->input('id'))->update($request->all());

            return redirect()->back()
                ->with('message', 'Currencies Updated Successfully.');
        }
    }

    public function destroy(Request $request)
    {
        abort_if(Gate::denies('currency.delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->has('id')) {
            Currency::find($request->input('id'))->delete();

            return redirect()->back();
        }
    }
}
