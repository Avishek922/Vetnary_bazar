<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function index()
    {
        $queries = \App\Models\ContactQuery::latest()->get();
        return view('admin.queries.index', compact('queries'));
    }

    public function show(\App\Models\ContactQuery $query)
    {
        return view('admin.queries.show', compact('query'));
    }

    public function destroy(\App\Models\ContactQuery $query)
    {
        $query->delete();
        return redirect()->route('admin.queries.index')->with('success', 'Query deleted successfully.');
    }
}
