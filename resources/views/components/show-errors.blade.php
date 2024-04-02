@if($errors->any())
    <br>
    @foreach ($errors->all() as $error)
        <div class="subcontainer" style="outline-color: red;">
            {{ $error }}
        </div>
    @endforeach
@endif