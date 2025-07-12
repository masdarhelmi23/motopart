<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold">Buyer Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}! This is your dashboard.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
