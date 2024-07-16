<?php

namespace App\Http\Controllers;

use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\Seller\ProductCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HomePageSection;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class WebsiteController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:header_setup'])->only('header');
        $this->middleware(['permission:footer_setup'])->only('footer');
        $this->middleware(['permission:view_all_website_pages'])->only('pages');
        $this->middleware(['permission:website_appearance'])->only('appearance');
        $this->middleware(['permission:select_homepage'])->only('select_homepage');
        $this->middleware(['permission:authentication_layout_settings'])->only('authentication_layout_settings');
    }

    public function header(Request $request)
    {
        return view('backend.website_settings.header');
    }
    public function footer(Request $request)
    {
        $lang = $request->lang;
        return view('backend.website_settings.footer', compact('lang'));
    }
    public function pages(Request $request)
    {
        $page = Page::where('type', '!=', 'home_page')->get();
        return view('backend.website_settings.pages.index', compact('page'));
    }
    public function appearance(Request $request)
    {
        return view('backend.website_settings.appearance');
    }
    public function select_homepage(Request $request)
    {
        return view('backend.website_settings.select_homepage');
    }

    public function authentication_layout_settings(Request $request)
    {
        return view('backend.website_settings.authentication_layout_settings');
    }

    public function homepage_sections(Request $request)
    {
        $sections = HomePageSection::where('is_active', '1')->get();
        return view('backend.website_settings.homepage-sections', compact('sections'));
    }

    public function createHomepageSection(Request $request)
    {
        return view('backend.website_settings.create-homepage-section');
    }

    public function storeSection(Request $request)
    {
        // $validate =  $request->validate([
        //     'title'=> 'required',
        //     'device_type'=> 'required',
        //     'section_type'=> 'required',
        // ]);
        
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'device_type' => 'required',
            'section_type' => 'required',  
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $section = [];
        $section['title'] = $request->title;
        $section['device_type'] = $request->device_type;
        $section['section_type'] = $request->section_type;
        $section['is_category'] = $request->section_type == 'category' ? '1' : '0';
        $section['is_product'] = $request->section_type == 'product' ? '1' : '0';
        $section['is_brand'] = $request->section_type == 'brand' ? '1' : '0';
        $section['category_ids'] = $request->section_type == 'category' ? $request->category_ids : [] ;
        $section['product_ids'] = $request->section_type == 'product' ? $request->product_ids : [] ;
        $section['brand_ids'] = $request->section_type == 'brand' ? $request->brand_ids : [] ;
        $section['is_active'] = $request->is_active ? '1' : '0';
        HomePageSection::create($section);
        flash(translate('Section has been inserted successfully'))->success();
        return redirect()->route('website.homepage-sections')->with('success','Section created successfully');
    }

    public function editHomepageSection(Request $request)
    {
        $section = HomePageSection::where('id', $request->id)->first();
        return view('backend.website_settings.edit-homepage-section', compact('section'));
    }

    public function updateHomepageSection(Request $request, $id)
    {
        $section = HomePageSection::find($id);
        $updateSection['is_category'] = $request->section_type == 'category' ? '1' : '0';
        $updateSection['is_product'] = $request->section_type == 'product' ? '1' : '0';
        $updateSection['is_brand'] = $request->section_type == 'brand' ? '1' : '0';
        $updateSection['category_ids'] = $request->section_type == 'category' ? $request->category_ids : [] ;
        $updateSection['product_ids'] = $request->section_type == 'product' ? $request->product_ids : [] ;
        $updateSection['brand_ids'] = $request->section_type == 'brand' ? $request->brand_ids : [] ;
        $request->merge($updateSection);
        $section->update($request->all());
        flash(translate('Section has been updated successfully'))->success();
        return redirect()->route('website.homepage-sections');
    }

}
