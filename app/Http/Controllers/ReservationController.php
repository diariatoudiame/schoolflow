<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class ReservationController extends Controller
{
    // Display the list of reservations
    public function index()
    {
        $reservations = Reservation::with('book')->where('user_id', Auth::id())->get();
        return view('reservations.my-reservations', compact('reservations'));
    }

    // Display the reservation form
    public function create($id)
    {
        $book = Book::findOrFail($id);
        return view('reservations.reserve-book', compact('book'));
    }

    // Store a new reservation
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->book_id);

        // Check availability
        if (!$book->status === 'available') {
            Toastr::error('No books available for reservation.', 'Error');
            return redirect()->back();
        }

        $duration = 7;

        // Create the reservation
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->book_id = $book->id;
        $reservation->reservation_date = now();
        $reservation->duration = $duration; // Reservation duration
        $reservation->save();

        // Decrement the book quantity
        $book->status = 'checked out';
        $book->save();

        // Display success message
        Toastr::success('Your reservation has been made successfully. A confirmation email will be sent to you shortly.', 'Success');
        return redirect()->route('reservations.index');
    }

    // Display a specific reservation
    public function show($id)
    {
        $reservation = Reservation::with('book')->findOrFail($id);
        return view('reservations.infos-res', compact('reservation'));
    }

    // Display the edit reservation form
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $books = Book::where('quantity', '>', 0)->get(); // Retrieve available books
        return view('reservations.edit', compact('reservation', 'books'));
    }

    // Update an existing reservation
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'duration' => 'required|integer|min:1',
        ]);

        $reservation = Reservation::findOrFail($id);
        $book = Book::find($request->book_id);

        // Retrieve the old book to update the quantity
        if ($reservation->book_id != $book->id) {
            // Increment the quantity of the old book
            $oldBook = Book::find($reservation->book_id);
            $oldBook->quantity++;
            $oldBook->save();
        }

        // Update the reservation
        $reservation->book_id = $book->id;
        $reservation->duration = $request->duration;
        $reservation->save();

        // Decrement the quantity of the new book
        $book->quantity--;
        $book->save();

        Toastr::success('Reservation updated successfully.', 'Success');
        return redirect()->route('reservations.index');
    }

    // Return a book
    public function returnBook($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Find the book
        $book = Book::find($reservation->book_id);

        // Increase the quantity of available books
        $book->status = 'available';
        $book->save();

//        $reservation->delete();

        Toastr::success('Book returned successfully.', 'Success');
        return redirect()->route('reservations.index');
    }

    // Delete a reservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Retrieve the book
        $book = Book::find($reservation->book_id);

        // Increase the quantity of available books
        $book->quantity++;
        $book->save();

        // Delete the reservation
        $reservation->delete();

        Toastr::success('Reservation deleted successfully.', 'Success');
        return redirect()->route('reservations.index');
    }
}
