<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\RequirementRawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $data  = Menu::all();
        return view('manager.menu.index', compact('data'));
    }

    public function create()
    {
        return view('manager.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/menu', $image->hashName());

        $simpan = new Menu();
        $simpan->name = $request->name;
        $simpan->price = $request->price;
        $simpan->category = $request->category;
        $simpan->image = $image->hashName();
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => true,
                'message' => 'Menu berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => false,
                'message' => 'Menu gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = Menu::find($id);
        return view('manager.menu.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Menu::find($id);
        return view('manager.menu.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
        ]);
        $simpan = Menu::find($id);

        if($request->hasFile('image')){
            //hapus file lama
            $oldImage = Menu::find($id)->image;
            Storage::delete('public/menu/'.$oldImage);

            $image = $request->file('image');
            $image->storeAs('public/menu', $image->hashName());
            $simpan->image = $image->hashName();
        }else{
            $image = Menu::find($id)->image;
        }

        $simpan->name = $request->name;
        $simpan->price = $request->price;
        $simpan->category = $request->category;
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => true,
                'message' => 'Menu berhasil diubah'
            ]);
        }else{
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => false,
                'message' => 'Menu gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Menu::find($id);
        //hapus data salesDetail dan requirementRawMaterial
        $data->salesDetails()->delete();
        $data->requirementRawMaterials()->delete();
        $image = $data->image;
        Storage::delete('public/menu/'.$image);
        $data = $data->delete();

        if($data){
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => true,
                'message' => 'Menu berhasil dihapus'
            ]);
        }else{
            return redirect()->route('manager.menu.index')->with('message', [
                'success' => false,
                'message' => 'Menu gagal dihapus'
            ]);
        }
    }

    public function viewRequirement($id)
    {
        $menu = Menu::find($id);
        $data = $menu->requirementRawMaterials;
        return view('manager.menu.viewRequirement', compact('data', 'menu'));
    }

    public function addRequirement($id)
    {
        $data = Menu::find($id);
        $raw = RawMaterial::all();
        return view('manager.menu.addRequirement', compact('data', 'raw'));
    }

    public function storeRequirement(Request $request, $id)
    {
        $request->validate([
            'raw_material_id' => 'required',
            'qty' => 'required',
        ]);

        $simpan = new RequirementRawMaterial();
        $simpan->menu_id = $id;
        $simpan->raw_material_id = $request->raw_material_id;
        $simpan->qty = $request->qty;
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('manager.menu.viewRequirement', $id)->with('message', [
                'success' => true,
                'message' => 'Bahan baku berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.menu.viewRequirement', $id)->with('message', [
                'success' => false,
                'message' => 'Bahan baku gagal ditambahkan'
            ]);
        }
    }

    public function destroyRequirement($id)
    {
        $data = RequirementRawMaterial::find($id);
        $data = $data->delete();

        if($data){
            return redirect()->route('manager.menu.show', $data->menu_id)->with('message', [
                'success' => true,
                'message' => 'Bahan baku berhasil dihapus'
            ]);
        }else{
            return redirect()->route('manager.menu.show', $data->menu_id)->with('message', [
                'success' => false,
                'message' => 'Bahan baku gagal dihapus'
            ]);
        }
    }
}
