<?php

namespace App\Http\Controllers\BackEnd;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Alert;

class MenuController extends AdminBaseController
{
    public function index(Request $request){
        //dd(Lang::locale());
        $menus = Menu::where('parent_id',0)->orderBy('menu_order','asc')->get();
        foreach ($menus as $menu)
        {
            $child = Menu::where('parent_id',$menu->id)->orderBy('menu_order','asc')->get();
            if(count($child))
            {
                $menu->child = $child;
            }
        }
        $var['menus'] = $menus;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.menu.index'),
                'title' => 'Danh sách menu',
            )
        );
        return view('backend.menu.index',compact('var'));
    }
    public function add()
    {
        
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.menu.index'),
                'title' => 'Danh sách menu',
            ),
            array(
                'url'=> route('admin.menu.add'),
                'title' => 'Thêm menu',
            )
        );
        $var['menu_all'] = Menu::where('status',Menu::STATUS_ON)->where('parent_id',0)->get();
        return view('backend.menu.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        
        if(empty($data['name']))
        {
            alert()->error('Có lỗi','name không được để trống');
            return redirect()->route('admin.menu.add');
        }

        $menu = new Menu();
        $menu->name = $data['name'];
        $menu->parent_id = empty($data['parent_id']) ? 0 : $data['parent_id'];
        $menu->status = $data['status'];
        $menu->url = empty($data['url']) ? '#' : $data['url'];
        $menu->create_date = time();        
        $menu->save();
        alert()->success('Thông báo','Thêm dữ liệu thành công');

        return redirect()->route('admin.menu.index');
    }
    public function edit($id,Request $request)
    {
        $menu = Menu::find($id);
        if(!$menu)
        {
            alert()->error('Có lỗi','Dữ liệu không tồn tại');
            return redirect()->route('admin.menu.index');
        }
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.menu.index'),
                'title' => 'Danh sách menu',
            ),
            array(
                'url'=> route('admin.menu.edit',['id'=>$id]),
                'title' => 'Sửa : ' .$menu->name,
            )
        );
        $var['menu'] = $menu;
        $var['menu_all'] = Menu::where('status',Menu::STATUS_ON)->where('parent_id',0)->get();
        return view('backend.menu.edit',compact('var'));
    }
    public function update(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']) || empty($data['id']))
        {
            alert()->error('Có lỗi','Dữ liệu không tồn tại');
            return redirect()->route('admin.menu.index');
        }
        $menu = Menu::find($data['id']);
        if(!$menu)
        {
            alert()->error('Có lỗi','Dữ liệu không tồn tại');
            return redirect()->route('admin.menu.index');
        }
        $menu->name = $data['name'];
        $menu->parent_id = empty($data['parent_id']) ? 0 : $data['parent_id'];
        $menu->url = empty($data['url']) ? '#' : $data['url'];
        $menu->status = $data['status'];
        $menu->save();

        alert()->success('Thông báo','Cập nhật thành công');
        return redirect()->route('admin.menu.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            //alert()->error('Có lỗi','Bài viết không tồn tại');
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $menu = Menu::find($data['id']);
        if(!$menu)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }

        if($menu->delete())
        {
            DB::table('menu')->where('parent_id', $data['id'])->delete();
            return response()->json(array('error' => false, 'msg' => 'Xóa Dữ liệuthành công'));

        }
        return response()->json(array('error' => true, 'msg' => 'Xóa không thành công'));

    }
    public function order(Request $request)
    {
        $data = $request->all();
        if($data['order'] != '')
        {
            $menu_order = json_decode($data['order']);
            foreach ($menu_order as $key => $order)
            {
                $menu = Menu::find($order->id);
                if($menu)
                {
                    $menu->menu_order = $key;
                    $menu->save();
                }
                if(isset($order->children))
                {
                    $list_ids = [];
                    foreach ($order->children as $key_child => $children)
                    {
                        $menu_child = Menu::find($children->id);
                        if($menu_child)
                        {
                            $menu_child->menu_order = $key_child;
                            $menu_child->parent_id = $order->id;
                            $menu_child->save();
                        }
                        //$list_ids[] = $children->id;
                        //array_push($list_ids,$children->id);
                    }
                    //dd($list_ids);
//                    DB::table('menu')
//                        ->whereIn('id', $list_ids)
//                        ->update(['parent_id' => $order->id]);
                }
            }
        }
        dd(json_decode($data['order']));
    }
}
