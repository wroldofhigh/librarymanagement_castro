<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // Store a new book
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn',
            'published_year' => 'required|integer|digits:4',
        ]);

        // Create a new book
        $book = Book::create($validated);

        // Provide feedback
        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }
    // Update an existing book
    public function update(Request $request, $id)
    {
        // Find the book
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'published_year' => 'required|integer|digits:4',
        ]);

        // Update the book
        $book->update($validated);

        // Provide feedback
        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }
    // Delete a book
    public function destroy($id)
    {
        // Find the book
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        // Delete the book
        $book->delete();

        // Provide feedback
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
    public function index()
    {
    $books = Book::all();
    return view('books.index', compact('books'));
    }

    public function create()
    {
    return view('books.create');
    }

    public function edit($id)
    {
    $book = Book::find($id);
    if (!$book) {
        return redirect()->route('books.index')->with('error', 'Book not found.');
    }
    return view('books.edit', compact('book'));
    }
}
