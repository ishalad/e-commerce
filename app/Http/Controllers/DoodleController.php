<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doodle;

class DoodleController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_blogs'])->only('index');
        $this->middleware(['permission:add_blog'])->only('create');
        $this->middleware(['permission:edit_blog'])->only('edit');
        $this->middleware(['permission:delete_blog'])->only('destroy');
        $this->middleware(['permission:publish_blog'])->only('change_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $doodles = Doodle::orderBy('created_at', 'desc');
        
        if ($request->search != null){
            $doodles = $doodles->where('title', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $doodles = $doodles->paginate(15);

        return view('backend.doodle.index', compact('doodles','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.doodle.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'publish_date' => 'required',
            'header_image' => 'required',
            'banner' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $doodle = new Doodle;
        $doodle->title = $request->title;
        $doodle->slug = $request->slug;
        $doodle->publish_date = date('Y-m-d', strtotime($request->publish_date));
        $doodle->header_image = $request->header_image;
        $doodle->banner = $request->banner;
        $doodle->short_description = $request->short_description;
        $doodle->description = $request->description;
        $doodle->meta_title = $request->meta_title;
        $doodle->meta_img = $request->meta_img;
        $doodle->meta_description = $request->meta_description;
        $doodle->meta_keywords = $request->meta_keywords;
        $doodle->save();

        flash(translate('Doodle has been created successfully'))->success();
        return redirect()->route('doodle.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doodle = Doodle::find($id);
        return view('backend.doodle.edit', compact('doodle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'publish_date' => 'required',
            'header_image' => 'required',
            'banner' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ]);

        $doodle = Doodle::find($id);
        $doodle->title = $request->title;
        $doodle->slug = $request->slug;
        $doodle->publish_date = date('Y-m-d', strtotime($request->publish_date));
        $doodle->header_image = $request->header_image;
        $doodle->banner = $request->banner;
        $doodle->short_description = $request->short_description;
        $doodle->description = $request->description;
        $doodle->meta_title = $request->meta_title;
        $doodle->meta_img = $request->meta_img;
        $doodle->meta_description = $request->meta_description;
        $doodle->meta_keywords = $request->meta_keywords;
        $doodle->save();

        flash(translate('Doodle has been updated successfully'))->success();
        return redirect()->route('doodle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Doodle::find($id)->delete();
        return redirect()->route('doodle.index');
    }
}
