@extends('app')

@section('title', 'Contact Us')

@section('content')
    <h1>Contact Us</h1>
    <p>If you have any questions, feel free to reach out to us through the following channels:</p>
    <ul>
        <li>Email: info@example.com</li>
        <li>Phone: +123 456 7890</li>
        <li>Address: 123 Example Street, City, Country</li>
    </ul>
    <form action="#" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Your Message:</label>
            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
@endsection
