<form method="POST" action="{{ route('pdf.convert') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="pdf" required>
    <button type="submit">Convert to CSV</button>
</form>
