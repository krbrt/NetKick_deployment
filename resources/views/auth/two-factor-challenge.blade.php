<form method="POST" action="{{ url('/two-factor-challenge') }}">
    @csrf
    <input type="text" name="code" placeholder="Enter 6-digit code">
    <button type="submit">Verify</button>
</form>