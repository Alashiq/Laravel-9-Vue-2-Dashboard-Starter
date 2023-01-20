<?php

namespace App\Features\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Permission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class Playerontroller extends Controller
{


    // Player List
    public function index(Request $request)
    {
        if ($request->count)
            $count = $request->count;
        else
            $count = 10;

        $list = Player::latest()
            ->where('state', '<>', 9)
                ->where('name', 'like', '%' . $request->name . '%') 
->where('club', 'like', '%' . $request->club . '%') 
->where('age', 'like', '%' . $request->age . '%') 

            ->paginate($count);

        if ($list->isEmpty())
            return response()->json(['success' => false, 'message' => 'لا يوجد اي لاعبين في الموقع', 'data' => $list], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب  اللاعبين بنجاح', 'data' => $list], 200);
    }

    // Get Player By Id
    public function show($id)
    {
        $item = Player::with('role:id,name')->where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الالعب غير موجود'], 204);
        return response()->json(['success' => true, 'message' => 'تم جلب الالعب بنجاح', 'data' => $item], 200);
    }



    // Delete Player
    public function delete($id)
    {
        $item = Player::where('id', $id)->where('state', '<>', 9)->first();
        if (!$item)
            return response()->json(['success' => false, 'message' => 'هذه الالعب غير موجود'], 204);


        $item->state = 9;
        $edit = $item->save();
        if ($edit)
            return response()->json(['success' => true, 'message' => 'تم حذف هذا الالعب بنجاح'], 200);
        return response()->json(['success' => true, 'message' => 'حدث خطأ ما'], 400);
    }








    // Add New Player
    public function create(Request $request)
    {
        $newItem = Player::create([
            'name' => $request['name'], 
'club' => $request['club'], 
'age' => $request['age'], 
'club_id' => $request['club_id'], 

        ]);
        return response()->json(['success' => true, 'message' => 'تم إنشاء هذا الالعب بنجاح'], 200);
    }

}
