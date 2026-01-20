<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dropdown;
use Yajra\DataTables\DataTables;

class DropdownController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Dropdown::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-primary btn-sm btn-edit"
                        data-id="' . $row->id . '"
                        data-category="' . $row->category . '"
                        data-name="' . $row->name_value . '"
                        data-code="' . $row->code_format . '">
                        <i class="fas fa-edit"></i>
                    </button>

                    <form action="' . route('dropdown.delete', $row->id) . '"
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

        return view('dropdown.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'name_value' => 'required',
            'code_format' => 'required',
        ]);

        $addDropdown = Dropdown::create([
            'category' => $request->category,
            'name_value' => $request->name_value,
            'code_format' => $request->code_format,
        ]);
        if ($addDropdown) {
            return redirect()->back()->with('success', 'Success Add Dropdown');
        } else {
            return redirect()->back()->with('error', 'Failed Add Dropdown');
        }
    }

    public function destroy($id)
    {
        $deleterule = Dropdown::where('id', $id)
            ->delete();
        if ($deleterule) {
            return redirect()->back()->with('success', 'Success Delete Dropdown');
        } else {
            return redirect()->back()->with('error', 'Failed Delete Dropdown');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'name_value' => 'required',
            'code_format' => 'required',
        ]);

        //Validate Input
        $validateInput =  Dropdown::where('id', $id)->first();
        $validateInput->category = $request->category;
        $validateInput->name_value = $request->name_value;
        $validateInput->code_format = $request->code_format;

        if ($validateInput->isDirty()) {

            try {
                $updaterule = Dropdown::where('id', $id)
                    ->update([
                        'category' => $request->category,
                        'name_value' => $request->name_value,
                        'code_format' => $request->code_format,
                    ]);
                if ($updaterule) {
                    return redirect()->back()->with('success', 'Success Update Dropdown');
                } else {
                    return redirect()->back()->with('error', 'Failed Update Dropdown');
                }
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Failed Update Dropdown');
            }
        } else {
            return redirect()->back()->with('error', 'There is no Change in Allowance Data');
        }
    }
}
