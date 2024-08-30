<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\PublisherModel;
use App\Models\User;
use App\Models\WriterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->roles[0]->name == 'writer'){
                $writer = WriterModel::where('user_id', auth()->user()->id)->first();

                if($writer){
                    $data = BookModel::with('category')->with('writer')->with('publisher')
                            ->where('writer_id', $writer->id)->get();
                } else {
                    $data = BookModel::with('category')->with('writer')->with('publisher')->get();
                }
            } else {
                $data = BookModel::with('category')->with('writer')->with('publisher')->get();
            }
            return response()->json(compact('data'));
        }
        $category = CategoryModel::all();
        $publisher = PublisherModel::all();
        $writer = WriterModel::all();

        return view('master.book.index', compact('category', 'publisher', 'writer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'page_count' => ['required'],
                'category_id' => ['required'],
                'writer_id' => ['required'],
                'publisher_id' => ['required'],
                'publication_year' => ['required'],
            ], [
                'title.required' => 'The Title field is required.',
                'page_count.required' => 'The Page Count field is required.',
                'category_id.required' => 'The Category field is required.',
                'writer_id.required' => 'The Writer field is required.',
                'publisher_id.required' => 'The Publisher field is required.',
                'publication_year.required' => 'The Publication Year field is required.',

            ]);

            BookModel::create([
                'title' => $request->title,
                'page_count' => $request->page_count,
                'category_id' => $request->category_id,
                'writer_id' => $request->writer_id,
                'publisher_id' => $request->publisher_id,
                'publication_year' => $request->publication_year,
                'qty' => $request->qty,
                'user_created' => auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Store Master Book - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Validasi Error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Store Master Book - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BookModel::where('id', $id)->first();
        $category = CategoryModel::all();
        $publisher = PublisherModel::all();
        $writer = WriterModel::all();

        return view('master.book.edit', compact('data', 'category', 'publisher', 'writer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'page_count' => ['required'],
                'category_id' => ['required'],
                'writer_id' => ['required'],
                'publisher_id' => ['required'],
                'publication_year' => ['required'],
            ], [
                'title.required' => 'The Title field is required.',
                'page_count.required' => 'The Page Count field is required.',
                'category_id.required' => 'The Category field is required.',
                'writer_id.required' => 'The Writer field is required.',
                'publisher_id.required' => 'The Publisher field is required.',
                'publication_year.required' => 'The Publication Year field is required.',

            ]);

            $book = BookModel::findOrFail($id);
            $book->update([
                'title' => $request->title,
                'page_count' => $request->page_count,
                'category_id' => $request->category_id,
                'writer_id' => $request->writer_id,
                'publisher_id' => $request->publisher_id,
                'publication_year' => $request->publication_year,
                'qty' => $request->qty,
                'user_updated' => auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Update Master Book - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Validasi Error.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update Master Book - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = BookModel::findOrFail($id);
            $book->delete();
            return response()->json([
                'success' => true,
                'message' => 'Success',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Delete Master Book - Terjadi kesalahan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], 500);
        }
    }
}
