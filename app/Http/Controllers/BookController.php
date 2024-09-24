<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Import du modèle Book
use Brian2694\Toastr\Facades\Toastr; // Pour les messages Toast
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import pour générer un identifiant unique

class BookController extends Controller
{
    /** Display the list of books */
    public function bookList()
    {
        $books = Book::all(); // Retrieve all books
        return view('books.list-book', compact('books')); // Show the view with the list of books
    }

    /** Show the form for adding a new book */
    public function bookAdd()
    {
        return view('books.add-book'); // Show the view to create a book
    }

    /** Store a new book */
    public function saveRecord(Request $request)
    {
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'genre' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Create a new book with a generated unique identifier
            Book::create([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'book_number' => Str::uuid(), // Génère un identifiant unique
                'published_date' => $request->input('published_date'),
                'quantity' => $request->input('quantity'),
                'genre' => $request->input('genre'),
            ]);

            DB::commit();
            Toastr::success('Book added successfully :)', 'Success');
            return redirect()->route('book/list/page'); // Redirect to the list of books

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to add the book: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Display the details of a book */
    public function show($id)
    {
        $book = Book::findOrFail($id); // Find the book by ID
        return view('books.infos-book', compact('book')); // Show the details of the book
    }

    /** Show the form for editing a book */
    public function editRecord($id)
    {
        $book = Book::findOrFail($id); // Find the book by ID
        return view('books.edit-book', compact('book')); // Show the edit form
    }

    /** Update a book */
    public function updateRecordBook(Request $request, $id)
    {
//        dd($request);
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'genre' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            $book->update([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'book_number' => $request->input('book_number'),
                'published_date' => $request->input('published_date'),
                'quantity' => $request->input('quantity'),
                'genre' => $request->input('genre'),
            ]);

            DB::commit();
            Toastr::success('Book updated successfully :)', 'Success');
            return redirect()->route('book/list/page'); // Redirect to the list of books

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to update the book: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /** Delete a book */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $book = Book::findOrFail($id); // Find the book by ID
            $book->delete(); // Delete the book

            DB::commit();
            Toastr::success('Book deleted successfully :)', 'Success');
            return redirect()->route('books.index'); // Redirect to the list of books

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete the book: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
