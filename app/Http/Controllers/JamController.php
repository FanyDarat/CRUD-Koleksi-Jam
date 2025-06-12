<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJamRequest;
use App\Http\Requests\UpdateJamRequest;
use App\Models\Jam;
use Illuminate\Http\Request;
use App\Models\User;

class JamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();
        $jams = $user ? Jam::where('id_user', null)->orWhere('id_user', $user->id_user)->get() : Jam::where('id_user', null)->get();
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil mengambil data jam",
            'data' => $jams->map(function ($jam) use ($user) {
                return [
                    'id_jam' => $jam->id_jam,
                    'name' => $jam->name,
                    'serialNumber' => $jam->serialNumber,
                    'mine' => $user && $jam->id_user === $user->id_user ? "1" : "0"
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getImage($id_jam) {
        $jam = Jam::find($id_jam);

        if ($jam) {
            $path = public_path($jam->imageUrl);
            return response()->file($path);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJamRequest $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "serialNumber" => ["required", "string"],
            "image" => ["required", "image"],
        ]);

        $image = $request->image;
        $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('gambar'), $filename);

        $jam = Jam::create([
            "id_user" => $request->user()->id_user,
            'name' => $request->name,
            'serialNumber' => $request->serialNumber,
            'imageUrl' => "gambar/$filename"
        ]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil menambahkan jam"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jam $jam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jam $jam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJamRequest $request, $id_jam)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "serialNumber" => ["required", "string"],
            "image" => ["image"],
        ]);

        $jam = Jam::find($id_jam);

        if(!$jam) {
            return response()->json([
                'success' => false,
                'message' => "Jam tidak ditemukan"
            ]);
        }

        if ($jam->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $image = $request->image;
        if ($image) {
            $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar'), $filename);
            $jam->imageUrl = "gambar/$filename";
        }

        $jam->name = $request->name;
        $jam->serialNumber = $request->serialNumber;
    
        $jam->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id_jam)
    {
        $jam = Jam::find($id_jam);

        if (!$jam) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        if ($jam->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $jam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}