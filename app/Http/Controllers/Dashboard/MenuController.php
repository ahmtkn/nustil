<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Menu;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MenuSortingService;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $menus = Menu::orderBy('order');

        if ($request->has('locale')) {
            $menus->locale($request->input('locale'));
        }
        if ($request->has('group')) {
            $menus->group($request->input('group'));
        }

        $menus = $menus->get();
        $temp = [];

        foreach ($menus as $menu) {
            $temp[$menu->locale][$menu->group][] = $menu;
        }
        $menus = collect($temp);

        return view('dashboard.menu.index', compact('menus'));
    }

    public function update(Request $request, string $group, Menu $menu)
    {
        $data = $request->all();
        $data['payload'] = json_decode($request['payload'], true);
        $menu->update($data);
        cache()->flush();

        return redirect()->back()->with('message', 'Menu updated');
    }

    public function create(Request $request)
    {
        if (!$request->title || !$request->to) {
            return redirect()->back()->with('error', 'Menu item is invalid');
        }
        $data = $request->all();
        $data['payload'] = json_decode($request['payload'], true);
        Menu::create($data);

        cache()->flush();

        return redirect()->back()->with('message', 'Menu created');
    }

    public function destroy(string $group, Menu $menu)
    {
        $menu->delete();
        cache()->flush();

        return redirect()->back()->with([
            'message' => __('The :target is permanently deleted.', ['target' => 'menu item']),
        ]);;
    }

    public function move(string $group, Menu $menu, string $direction)
    {
        [$locale, $menuPosition] = explode(':', $group);
        $sort = new MenuSortingService($menuPosition, $locale);
        $func = $sort->direction($direction);
        $sort->$func($menu);
//        $details->items->toArray();

        cache()->flush();

        return redirect()->back();
    }

    public function show(string $group)
    {
        $menu = (object)$this->getMenuItems($group);

        return view('dashboard.menu.editor', $this->getMenuItems($group));
    }


    protected function getMenuItems(string $group)
    {
        [$locale, $group] = explode(':', $group);


        return [
            "lang" => $locale,
            "group" => $group,
            "items" => Menu::locale($locale ?? app()->getLocale())->group($group ?? 'main')->get(),
        ];
    }

}
