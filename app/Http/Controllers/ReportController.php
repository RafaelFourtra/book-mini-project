<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\PublisherModel;
use App\Models\WriterModel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  public function reportByCategory(Request $request)
  {
    if ($request->ajax()) {
      $category = $request->category;

      $query = BookModel::with('category')->with('writer')->with('publisher');

      if (!empty($category)) {
        $query->where('category_id', $category);
      }

      $data = $query->get();
      return response()->json(compact('data'));
    }

    $category = CategoryModel::all();
    return view('reports.category', compact('category'));
  }
  public function reportByPublisher(Request $request)
  {
    if ($request->ajax()) {
      $publisher = $request->publisher;

      $query = BookModel::with('category')->with('writer')->with('publisher');

      if (!empty($publisher)) {
        $query->where('publisher_id', $publisher);
      }

      $data = $query->get();
      return response()->json(compact('data'));
    }
    $publisher = PublisherModel::all();
    return view('reports.publisher', compact('publisher'));
  }
  public function reportByWriter(Request $request)
  {
    if ($request->ajax()) {
      $writer = $request->writer;

      $query = BookModel::with('category')->with('writer')->with('publisher');

      if (!empty($writer)) {
        $query->where('writer_id', $writer);
      }

      $data = $query->get();

      return response()->json(compact('data'));
    }

    $writer = WriterModel::all();
    return view('reports.writer', compact('writer'));
  }
}
