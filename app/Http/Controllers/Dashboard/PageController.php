<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(?string $filter = null)
    {
        $pages = Page::orderBy('created_at', 'desc');
        $filter = $filter ?? request()->input('filter') ?? 'all';

        switch ($filter) {
            case "trashed":
                $pages = $pages->onlyTrashed();
                break;
            case "published":
                $pages = $pages->published();
                break;
            case "draft":
                $pages = $pages->onlyDraft();
                break;
            case "all":
                $pages = $pages->latest();
                break;
        }
        $pages = $pages->paginate(10);
        $counts = (object)[
            'all' => Page::count(),
            'published' => Page::published()->count(),
            'draft' => Page::onlyDraft()->count(),
            'trashed' => Page::onlyTrashed()->count(),
        ];

        return view('dashboard.pages.index', compact('pages', 'filter', 'counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.pages.editor', ['page' => new Page(), 'editing' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePageRequest $request)
    {
        $page = Page::create($request->validated());

        return redirect()->route('dashboard.pages.index')->with('message', 'Page created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \App\Models\Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Page $page)
    {
        return view('dashboard.pages.editor', ['page' => $page, 'editing' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  \App\Models\Page $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->validated());

        return redirect()->route('dashboard.pages.index')->with('message', 'Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \App\Models\Page $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        if ($page->trashed()) {
            $page->forceDelete();
        } else {
            $page->delete();
        }

        return redirect()->route('dashboard.pages.index')->with('message', 'Page deleted successfully');
    }

}
