<?php

namespace App\Http\Controllers\Administration;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\TableRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $clauses = "";
        if (!empty($request->floorId)) {
            $clauses .= " and t.floor_id = '$request->floorId'";
        }
        if (!empty($request->inchargeId)) {
            $clauses .= " and t.incharge_id = '$request->inchargeId'";
        }
        if (!empty($request->categoryId)) {
            $clauses .= " and r.category_id = '$request->categoryId'";
        }
        if (!empty($request->tabletypeId)) {
            $clauses .= " and t.table_type_id = '$request->tabletypeId'";
        }
        if (!empty($request->tableId)) {
            $clauses .= " and t.id = '$request->tableId'";
        }

        $tables = DB::select("select t.*,
                f.name as floor_name,
                e.name as incharge_name,
                c.name as category_name,
                rt.name as tabletype_name
            from tables t
            left join floors f on f.id = t.floor_id
            left join employees e on e.id = t.incharge_id
            left join categories c on c.id = t.category_id
            left join table_types rt on rt.id = t.table_type_id
            where t.status != 'd' and t.deleted_at is null 
            $clauses");
        return response()->json($tables, 200);
    }

    public function create()
    {
        if (!checkAccess('table')) {
            return view('error.unauthorize');
        }

        return view('administration.table.create');
    }

    public function store(TableRequest $request)
    {
        // dd($request);

        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Table::where('name', $request->name)
            ->where('floor_id', $request->floor_id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The table name must be unique for the given floor!"], 422);
        }
        try {
            $check = DB::table('tables')->where('deleted_at', '!=', NULL)->where('name', $request->name)->first();
            if (!empty($check)) {
                DB::select("UPDATE tables SET deleted_by = NULL, deleted_at = NULL , status = 'a' WHERE id = ?", [$check->id]);
            } else {
                $data     = new Table();
                $tableKeys = $request->except('id', 'image');
                foreach (array_keys($tableKeys) as $key) {
                    $data->$key = $request->$key;
                }

                if ($request->hasFile('image')) {
                    $data->image = imageUpload($request, 'image', 'uploads/table', trim($data->code));
                }
                $data->added_by       = Auth::user()->id;
                $data->last_update_ip = request()->ip();
                $data->save();
            }

            return response()->json(['status' => true, 'message' => 'Table insert successfully', 'code' => generateCode('Table', 'T')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }
    public function update(TableRequest $request)
    {
        if (!$request->validated()) return send_error("Validation Error", $request->validated(), 422);
        $exists = Table::where('name', $request->name)
            ->where('floor_id', $request->floor_id)
            ->where('id', '!=', $request->id)
            ->exists();
        if ($exists) {
            return response()->json(['status' => true, 'message' => "The table name must be unique for the given category!"], 422);
        }
        try {
            $data = Table::find($request->id);
            $data->code = generateCode("Table", 'T');
            $tableKeys = $request->except('id', 'image');
            foreach (array_keys($tableKeys) as $key) {
                $data->$key = $request->$key;
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image = imageUpload($request, 'image', 'uploads/table', trim($data->code));
            }
            $data->updated_by     = Auth::user()->id;
            $data->updated_at     = Carbon::now();
            $data->last_update_ip = request()->ip();
            $data->update();

            return response()->json(['status' => true, 'message' => 'Table update successfully', 'code' => generateCode('Table', 'T')], 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data                 = Table::find($request->id);
            $data->status         = 'd';
            $data->last_update_ip = request()->ip();
            $data->deleted_by     = Auth::user()->id;
            $data->update();

            $data->delete();
            return response()->json("Table delete successfully", 200);
        } catch (\Throwable $th) {
            return send_error("Something went wrong", $th->getMessage());
        }
    }

    public function tableList()
    {
        if (!checkAccess('tableList')) {
            return view('error.unauthorize');
        }

        return view('administration.table.tablelist');
    }
}
