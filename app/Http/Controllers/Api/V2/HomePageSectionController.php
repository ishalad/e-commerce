<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\HomePageSectionCollection;
use App\Models\HomePageSection;
use Cache;
use Illuminate\Http\Request;

class HomePageSectionController extends Controller
{
    
    public function index(Request $request)
    {
        // $home_page_sections = Cache::remember('home_page_sections', 3600, function () {
        // });
        $homepageSections =  HomePageSection::where('is_active', 1)->get();
        return new HomePageSectionCollection($homepageSections);
    }
}
