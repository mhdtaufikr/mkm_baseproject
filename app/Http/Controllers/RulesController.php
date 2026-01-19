<?php

namespace App\Http\Controllers;

use App\Models\Rule;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RulesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Rule::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-primary btn-sm btn-edit"
                        data-id="' . $row->id . '"
                        data-name="' . $row->rule_name . '"
                        data-value="' . $row->rule_value . '">
                        <i class="fas fa-edit"></i>
                    </button>

                    <form action="' . url('/rule/delete/' . $row->id) . '"
                          method="POST"
                          class="d-inline delete-form">
                        ' . csrf_field() . method_field('delete') . '
                        <button class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('rules.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'rule_name' => 'required',
            'rule_value' => 'required',
        ]);

        $addrule = Rule::create([
            'rule_name' => $request->rule_name,
            'rule_value' => $request->rule_value,
        ]);
        if ($addrule) {
            return redirect()->back()->with('success', 'Success Add Rule');
        } else {
            return redirect()->back()->with('error', 'Failed Add Rule');
        }
    }

    public function delete($id)
    {
        $deleterule = Rule::where('id', $id)
            ->delete();
        if ($deleterule) {
            return redirect()->back()->with('success', 'Success Delete Rule');
        } else {
            return redirect()->back()->with('error', 'Failed Delete Rule');
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'rule_name' => 'required',
            'rule_value' => 'required',
        ]);

        //Validate Input
        $validateInput =  Rule::where('id', $id)->first();
        $validateInput->rule_name = $request->rule_name;
        $validateInput->rule_value = $request->rule_value;

        if ($validateInput->isDirty()) {

            try {
                $updaterule = Rule::where('id', $id)
                    ->update([
                        'rule_name' => $request->rule_name,
                        'rule_value' => $request->rule_value,
                    ]);
                if ($updaterule) {
                    return redirect()->back()->with('success', 'Success Update Rule');
                } else {
                    return redirect()->back()->with('error', 'Failed Update Rule');
                }
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Failed Update Dropdown');
            }
        } else {
            return redirect()->back()->with('error', 'There is no Change in Allowance Data');
        }
    }
}
